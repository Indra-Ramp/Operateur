<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table         = 'operation';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['id_type', 'id_compte1', 'id_compte2', 'montant', 'date_track', 'frais', 'id_operateur', 'commission'];

    public const TYPE_RETRAIT   = 'retrait';
    public const TYPE_TRANSFERT = 'transfert';
    public const TYPE_DEPOT     = 'depot';

    private array $typeCache = [];

    protected function getTypeId($label)
    {
        if (!array_key_exists($label, $this->typeCache)) {
            $type = (new TypeOperationModel())->where('label', $label)->first();
            $this->typeCache[$label] = $type['id'] ?? null;
        }
        return $this->typeCache[$label];
    }

    public function getSolde($idCompte){
        $depots = $this->db->table('operation o')
            ->selectSum('o.montant')->join('type_operation t', 't.id = o.id_type')
            ->where('t.label', self::TYPE_DEPOT)->where('o.id_compte1', $idCompte)
            ->get()->getRow()->montant ?? 0;

        $transfertsRecus = $this->db->table('operation o')
            ->selectSum('o.montant')->join('type_operation t', 't.id = o.id_type')
            ->where('t.label', self::TYPE_TRANSFERT)->where('o.id_compte2', $idCompte)
            ->get()->getRow()->montant ?? 0;

        $sorties = $this->db->table('operation o')
            ->select('SUM(COALESCE(o.montant, 0)) + SUM(COALESCE(o.frais, 0)) as total_sorties')
            ->join('type_operation t', 't.id = o.id_type')
            ->whereIn('t.label', [self::TYPE_RETRAIT, self::TYPE_TRANSFERT])
            ->where('o.id_compte1', $idCompte)
            ->get()->getRow()->total_sorties ?? 0;

        return (float)$depots + (float)$transfertsRecus - (float)$sorties;
    }

    public function getHistorique($idCompte, $limit = null, $offset = 0)
    {
        $b = $this->db->table('operation o')
            ->select('o.*, t.label as type_label, c1.tel as tel_compte1, c2.tel as tel_compte2')
            ->join('type_operation t', 't.id = o.id_type')
            ->join('compte c1', 'c1.id = o.id_compte1')
            ->join('compte c2', 'c2.id = o.id_compte2', 'left')
            ->groupStart()->where('o.id_compte1', $idCompte)->orWhere('o.id_compte2', $idCompte)->groupEnd()
            ->orderBy('o.date_track', 'DESC')->orderBy('o.id', 'DESC');
        return $limit ? $b->limit($limit, $offset)->get()->getResultArray() : $b->get()->getResultArray();
    }

    protected function getFrais($montant, $typeId)
    {
        if ($montant <= 0) return 0;
        $tranche = (new TrancheModel())->where('id_type', $typeId)->where('montant1 <=', $montant)->where('montant2 >=', $montant)->first();
        return (float)($tranche['frais'] ?? 0);
    }

    protected function insOp($typeId, $compte1, $montant, $compte2 = null)
    {
        return (bool) $this->insert(['id_type' => $typeId, 'id_compte1' => $compte1, 'id_compte2' => $compte2, 'montant' => $montant, 'date_track' => date('Y-m-d')]);
    }

    public function depot($compteId, $montant){
        if ($compteId <= 0 || $montant <= 0) {
            return ['success' => false, 'message' => 'Données invalides.'];
        }

        // Insertion automatique avec id_type = 3
        $saved = $this->insert([
            'id_type'    => 3,
            'id_compte1' => $compteId,
            'id_compte2' => null,
            'montant'    => $montant,
            'date_track' => date('Y-m-d')
        ]);

        return [
            'success' => (bool)$saved,
            'message' => $saved ? 'Dépôt effectué avec succès.' : 'Échec du dépôt.'
        ];
    }


    public function countHistorique($idCompte)
    {
        return (int) $this->db->table('operation o')
            ->join('type_operation t', 't.id = o.id_type')
            ->groupStart()->where('o.id_compte1', $idCompte)->orWhere('o.id_compte2', $idCompte)->groupEnd()
            ->countAllResults();
    }

    public function retrait($compteId, $montant)
    {
        if ($compteId <= 0 || $montant <= 0) {
            return ['success' => false, 'message' => 'Données invalides.'];
        }

        $tranche = $this->db->table('tranche')
            ->where('id_type', 1)
            ->where('montant1 <=', $montant)
            ->where('montant2 >=', $montant)
            ->get()->getRowArray();

        $fraisTemporaires = (float)($tranche['frais'] ?? 0);

        if (($montant + $fraisTemporaires) > $this->getSolde($compteId)) {
            return ['success' => false, 'message' => 'Solde insuffisant pour ce retrait.'];
        }

        $saved = $this->insert([
            'id_type'    => 1,
            'id_compte1' => $compteId,
            'id_compte2' => null,
            'montant'    => $montant,
            'frais'      => $fraisTemporaires,
            'date_track' => date('Y-m-d')
        ]);

        return [
            'success' => (bool)$saved,
            'message' => $saved ? 'Retrait effectué.' : 'Échec du retrait.'
        ];
    }

    public function transfert($compte1Id, $compte2Id, $montant, $inclureFrais = false)
    {
        if ($compte1Id <= 0 || $compte2Id <= 0 || $compte1Id === $compte2Id || $montant <= 0) {
            return ['success' => false, 'message' => 'Données invalides.'];
        }

        $compteModel = new CompteModel();
        $c1 = $compteModel->find($compte1Id);
        $c2 = $compteModel->find($compte2Id);

        if (!$c2) {
            $compte2Id = $compteModel->insert(['tel' => $c2['tel']]);
            if (!$compte2Id) {
                return ['success' => false, 'message' => 'Compte introuvable.'];
            }
            $c2 = $compteModel->find($compte2Id);
        }

        $prefixe1 = substr((string)$c1['tel'], 0, 3);
        $prefixe2 = substr((string)$c2['tel'], 0, 3);

        $commissionTemporaire = 0.0;
        if($prefixe1 != $prefixe2){
            // $commissionModel = new CommissionModel();
            // $commission1 = $commissionModel->getCommissionByOperateur($prefixe1);
            // $commission2 = $commissionModel->getCommissionByOperateur($prefixe2);

            // if (!$commission2) {
            //     return ['success' => false, 'message' => 'Commissions introuvables pour l\'operateur.'];
            // }

            // $commissionTemporaire = $montant * ($commission2['perc']);
            $commissionTemporaire = 0.1 * $montant;

        } else {
            $commissionTemporaire = 0;
        }

        $tranche = $this->db->table('tranche')
            ->where('id_type', 2)
            ->where('montant1 <=', $montant)
            ->where('montant2 >=', $montant)
            ->get()
            ->getRowArray();

        $fraisTemporaires = (float)($tranche['frais'] ?? 0);

        if ($inclureFrais) {
            $montantEnvoye      = $montant - $fraisTemporaires;
            $montantEnregistre1 = $montantEnvoye - $commissionTemporaire; 
            $totalDebitRequired = $montant + $commissionTemporaire;
        } else {
            $montantEnvoye      = $montant;
            $montantEnregistre1 = $montant;
            $totalDebitRequired = $montant + $fraisTemporaires + $commissionTemporaire;
        }

        if ($montantEnvoye <= 0 || $totalDebitRequired > $this->getSolde($compte1Id)) {
            return ['success' => false, 'message' => 'Solde insuffisant pour ce transfert.'];
        }

        $this->db->transBegin();

        $this->db->table('operation')->insert([
            'id_type'    => 2,
            'id_compte1' => $compte1Id,
            'id_compte2' => $compte2Id, 
            'montant'    => $montantEnregistre1,
            'frais'      => $fraisTemporaires,
            'commission' => $commissionTemporaire,
            'date_track' => date('Y-m-d')
        ]);

        $this->db->table('operation')->insert([
            'id_type'    => 3,
            'id_compte1' => $compte2Id,
            'id_compte2' => null,
            'montant'    => $montantEnvoye,
            'frais'      => 0,
            'commission' => 0,
            'date_track' => date('Y-m-d')
        ]);

        if ($this->db->transStatus() == false) {
            $this->db->transRollback();
            return ['success' => false, 'message' => 'Échec de la transaction en base de données.'];
        }

        $this->db->transCommit();
        return ['success' => true, 'message' => 'Transfert effectué avec succès.'];
    }

    public function transfertMultiple($compte1Id, $destinataireIds, $montantTotal, $inclureFrais = false)
    {
        $destinataireIds = array_values(array_unique($destinataireIds));
        $nb = count($destinataireIds);

        if ($compte1Id <= 0 || $nb < 2 || in_array($compte1Id, $destinataireIds, true) || $montantTotal <= 0) {
            return ['success' => false, 'message' => 'Données ou destinataires invalides.'];
        }

        $typeTransfert = $this->getTypeId(self::TYPE_TRANSFERT);
        $base = intdiv((int)round($montantTotal), $nb);
        $reste = (int)round($montantTotal) - ($base * $nb);

        if ($base <= 0) return ['success' => false, 'message' => 'Montant trop faible.'];

        $totalDebit = 0;
        $operations = [];
        $fraisCumulesTemporaires = 0.0;

        foreach ($destinataireIds as $index => $destId) {
            $part = $base + ($index < $reste ? 1 : 0);
            $frais = $this->getFrais($part, $typeTransfert);
            
            $montantEnvoye = $inclureFrais ? $part - $frais : $part;
            $debit = $inclureFrais ? $part : $part + $frais;

            if ($montantEnvoye <= 0) return ['success' => false, 'message' => 'Frais trop élevés pour une des parts.'];

            $totalDebit += $debit;
            $fraisCumulesTemporaires += $frais;
            $operations[] = ['dest' => $destId, 'envoye' => $montantEnvoye];
        }

        if ($totalDebit > $this->getSolde($compte1Id)) return ['success' => false, 'message' => 'Solde insuffisant.'];

        $this->db->transStart();
        foreach ($operations as $op) {
            $this->insOp($typeTransfert, $compte1Id, $op['envoye'], $op['dest']);
        }
        if ($fraisCumulesTemporaires > 0) {
            $this->db->table('operateur')->where('id', 1)->set('solde', 'solde - ' . $fraisCumulesTemporaires, false)->update();
        }
        $this->db->transComplete();

        return ['success' => $this->db->transStatus(), 'message' => 'Envoi multiple réussi.'];
    }

    public function getFraisForMontant($montant, int $typeId)
    {
        if (! is_numeric($montant) || $montant <= 0) {
            return 0;
        }

        $trancheModel = new TrancheModel();
        $tranche = $trancheModel
            ->where('id_type', $typeId)
            ->where('montant1 <=', $montant)
            ->where('montant2 >=', $montant)
            ->first();

        return $tranche['frais'] ?? 0;
    }

    public function getStat($startDate, $endDate, $isGlobalMode) {
        $db = \Config\Database::connect();
        $builder = $db->table('operation');
        $builder->select("
            SUM(CASE WHEN id_type = 1 THEN frais ELSE 0 END) as withdrawalFees,
            COUNT(CASE WHEN id_type = 1 THEN 1 END) as withdrawalCount,
            SUM(CASE WHEN id_type = 2 AND id_operateur IS NULL THEN frais ELSE 0 END) as transferInternalFees,
            COUNT(CASE WHEN id_type = 2 AND id_operateur IS NULL THEN 1 END) as transferInternalCount,
            SUM(CASE WHEN id_type = 2 AND id_operateur IS NOT NULL THEN frais ELSE 0 END) as transferExternalFees,
            COUNT(CASE WHEN id_type = 2 AND id_operateur IS NOT NULL THEN 1 END) as transferExternalCount
        ");
        if (!$isGlobalMode) {
            $builder->where('date_track >=', $startDate);
            $builder->where('date_track <=', $endDate);
        }
        return $builder->get()->getRowArray();
    }

    public function getGraphStat($graphStartDate, $graphEndDate) {
        $db = \Config\Database::connect();
        $graphBuilder = $db->table('operation');
        $graphBuilder->select("
            DATE(date_track) as date_jour,
            SUM(CASE WHEN id_type = 1 OR (id_type = 2 AND id_operateur IS NULL) THEN frais ELSE 0 END) as daily_internal,
            SUM(CASE WHEN id_type = 2 AND id_operateur IS NOT NULL THEN frais ELSE 0 END) as daily_external
        ");
        $graphBuilder->where('date_track >=', $graphStartDate);
        $graphBuilder->where('date_track <=', $graphEndDate);
        $graphBuilder->groupBy('DATE(date_track)');
        
        return $graphBuilder->get()->getResultArray();
    }

    public function getTotalSituation($idOperateur) {
        $db = \Config\Database::connect();
        $builder = $db->table('operation');
        $builder->select("
            COALESCE(SUM(COALESCE(montant,0) + COALESCE(commission,0)), 0) AS sum
        ");
        $builder->where('id_operateur', $idOperateur);
        return $builder->get()->getRow()->sum;
    }

    public function countSituation($idOperateur)
    {
        return $this->where('id_operateur', $idOperateur)->countAllResults();
    }

}
