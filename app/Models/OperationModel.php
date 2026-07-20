<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table         = 'operation';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['id_type', 'id_compte1', 'id_compte2', 'montant', 'date_track'];

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

    public function getSolde($idCompte)
    {
        $depots = $this->db->table('operation o')
            ->selectSum('o.montant')->join('type_operation t', 't.id = o.id_type')
            ->where('t.label', self::TYPE_DEPOT)->where('o.id_compte1', $idCompte)
            ->get()->getRow()->montant ?? 0;

        $transfertsRecus = $this->db->table('operation o')
            ->selectSum('o.montant')->join('type_operation t', 't.id = o.id_type')
            ->where('t.label', self::TYPE_TRANSFERT)->where('o.id_compte2', $idCompte)
            ->get()->getRow()->montant ?? 0;

        $sorties = $this->db->table('operation o')
            ->selectSum('o.montant')->join('type_operation t', 't.id = o.id_type')
            ->whereIn('t.label', [self::TYPE_RETRAIT, self::TYPE_TRANSFERT])->where('o.id_compte1', $idCompte)
            ->get()->getRow()->montant ?? 0;

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

    public function depot($compteId, $montant)
    {
        if ($compteId <= 0 || $montant <= 0) return ['success' => false, 'message' => 'Données invalides.'];
        $typeId = $this->getTypeId(self::TYPE_DEPOT);
        if (!$typeId || !$this->insOp($typeId, $compteId, $montant)) return ['success' => false, 'message' => 'Échec du dépôt.'];
        return ['success' => true, 'message' => 'Dépôt effectué.'];
    }

    public function retrait($compteId, $montant)
    {
        if ($compteId <= 0 || $montant <= 0) return ['success' => false, 'message' => 'Données invalides.'];
        $typeId = $this->getTypeId(self::TYPE_RETRAIT);
        $frais = $this->getFrais($montant, $typeId);
        
        if (($montant + $frais) > $this->getSolde($compteId)) return ['success' => false, 'message' => 'Solde insuffisant.'];

        $this->db->transStart();
        $this->insOp($typeId, $compteId, $montant);
        if ($frais > 0) {
            $fraisTemporaires = $frais;
            $this->db->table('operateur')->where('id', 1)->set('solde', 'solde - ' . $fraisTemporaires, false)->update();
        }
        $this->db->transComplete();

        return ['success' => $this->db->transStatus(), 'message' => 'Retrait effectué.'];
    }

    public function transfert($compte1Id, $compte2Id, $montant, $inclureFrais = false)
    {
        if ($compte1Id <= 0 || $compte2Id <= 0 || $compte1Id === $compte2Id || $montant <= 0) return ['success' => false, 'message' => 'Données invalides.'];
        
        $typeTransfert = $this->getTypeId(self::TYPE_TRANSFERT);
        $frais = $this->getFrais($montant, $typeTransfert);
        
        $montantEnvoye = $inclureFrais ? $montant - $frais : $montant;
        $total = $inclureFrais ? $montant : $montant + $frais;

        if ($montantEnvoye <= 0 || $total > $this->getSolde($compte1Id)) return ['success' => false, 'message' => 'Solde insuffisant.'];

        $this->db->transStart();
        $this->insOp($typeTransfert, $compte1Id, $montantEnvoye, $compte2Id);
        if ($frais > 0) {
            $fraisTemporaires = $frais;
            $this->db->table('operateur')->where('id', 1)->set('solde', 'solde - ' . $fraisTemporaires, false)->update();
        }
        $this->db->transComplete();

        return ['success' => $this->db->transStatus(), 'message' => 'Transfert réussi.'];
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
}
