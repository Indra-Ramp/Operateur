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


    protected function getTypeId(string $label): ?int
    {
        if (! array_key_exists($label, $this->typeCache)) {
            $type = (new TypeOperationModel())->where('label', $label)->first();
            $this->typeCache[$label] = $type['id'] ?? null;
        }

        return $this->typeCache[$label];
    }


    public function getSolde(int $idCompte): float
    {
        $entrees = $this->db->table('operation o')
            ->selectSum('o.montant')
            ->join('type_operation t', 't.id = o.id_type')
            ->groupStart()
                ->where(['t.label' => self::TYPE_DEPOT, 'o.id_compte1' => $idCompte])
                ->orWhere(['t.label' => self::TYPE_TRANSFERT, 'o.id_compte2' => $idCompte])
            ->groupEnd()
            ->get()
            ->getRow()
            ->montant ?? 0;

        $sorties = $this->db->table('operation o')
            ->selectSum('o.montant')
            ->join('type_operation t', 't.id = o.id_type')
            ->groupStart()
                ->where(['t.label' => self::TYPE_RETRAIT, 'o.id_compte1' => $idCompte])
                ->orWhere(['t.label' => self::TYPE_TRANSFERT, 'o.id_compte1' => $idCompte])
            ->groupEnd()
            ->get()
            ->getRow()
            ->montant ?? 0;

        return (float) $entrees - (float) $sorties;
    }


    public function getHistorique(int $idCompte, ?int $limit = null, int $offset = 0): array
    {
        $builder = $this->historiqueBuilder($idCompte)
            ->orderBy('o.date_track', 'DESC')
            ->orderBy('o.id', 'DESC');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        return $builder->get()->getResultArray();
    }

    public function countHistorique(int $idCompte): int
    {
        return $this->historiqueBuilder($idCompte)->countAllResults();
    }

    private function historiqueBuilder(int $idCompte)
    {
        return $this->db->table('operation o')
            ->select('o.*, t.label as type_label, c1.tel as tel_compte1, c2.tel as tel_compte2')
            ->join('type_operation t', 't.id = o.id_type')
            ->join('compte c1', 'c1.id = o.id_compte1')
            ->join('compte c2', 'c2.id = o.id_compte2', 'left')
            ->groupStart()
                ->where('o.id_compte1', $idCompte)
                ->orWhere('o.id_compte2', $idCompte)
            ->groupEnd();
    }

  
    protected function getFrais(float $montant, int $typeId): float
    {
        if ($montant <= 0) {
            return 0;
        }

        $tranche = (new TrancheModel())
            ->where('id_type', $typeId)
            ->where('montant1 <=', $montant)
            ->where('montant2 >=', $montant)
            ->first();

        return (float) ($tranche['frais'] ?? 0);
    }

    protected function insertOperation(int $typeId, int $compte1Id, float $montant, ?int $compte2Id = null): bool
    {
        return (bool) $this->insert([
            'id_type'    => $typeId,
            'id_compte1' => $compte1Id,
            'id_compte2' => $compte2Id,
            'montant'    => $montant,
            'date_track' => date('Y-m-d'),
        ]);
    }

 
    public function depot(int $compteId, float $montant): array
    {
        if ($compteId <= 0) {
            return $this->fail('Compte invalide.');
        }

        if ($montant <= 0) {
            return $this->fail('Le montant du dépôt doit être supérieur à 0.');
        }

        $typeId = $this->getTypeId(self::TYPE_DEPOT);

        if (! $typeId || ! $this->insertOperation($typeId, $compteId, $montant)) {
            return $this->fail('Le dépôt a échoué, veuillez réessayer.');
        }

        return $this->success('Dépôt de ' . $this->formatMontant($montant) . ' Ar effectué avec succès.');
    }


    public function retrait(int $compteId, float $montant): array
    {
        if ($compteId <= 0) {
            return $this->fail('Compte invalide.');
        }

        if ($montant <= 0) {
            return $this->fail('Le montant du retrait doit être supérieur à 0.');
        }

        $typeId = $this->getTypeId(self::TYPE_RETRAIT);

        if (! $typeId) {
            return $this->fail("Le type d'opération \"retrait\" est introuvable.");
        }

        $frais = $this->getFrais($montant, $typeId);
        $total = $montant + $frais;

        if ($total > $this->getSolde($compteId)) {
            return $this->fail('Solde insuffisant pour ce retrait (montant + frais de ' . $this->formatMontant($frais) . ' Ar).');
        }

        if (! $this->insertOperation($typeId, $compteId, $montant)) {
            return $this->fail('Le retrait a échoué, veuillez réessayer.');
        }

        if ($frais > 0) {
            $this->insertOperation($typeId, $compteId, $frais);
        }

        $message = 'Retrait de ' . $this->formatMontant($montant) . ' Ar effectué avec succès';
        $message .= $frais > 0 ? ' (frais : ' . $this->formatMontant($frais) . ' Ar).' : '.';

        return $this->success($message);
    }

    public function transfert(int $compte1Id, int $compte2Id, float $montant): array
    {
        if ($compte1Id <= 0 || $compte2Id <= 0) {
            return $this->fail('Compte invalide.');
        }

        if ($compte1Id === $compte2Id) {
            return $this->fail('Vous ne pouvez pas transférer de l\'argent vers votre propre compte.');
        }

        if ($montant <= 0) {
            return $this->fail('Le montant du transfert doit être supérieur à 0.');
        }

        $typeTransfert = $this->getTypeId(self::TYPE_TRANSFERT);
        $typeRetrait   = $this->getTypeId(self::TYPE_RETRAIT);

        if (! $typeTransfert || ! $typeRetrait) {
            return $this->fail("Les types d'opération sont introuvables.");
        }

        $frais = $this->getFrais($montant, $typeTransfert);
        $total = $montant + $frais;

        if ($total > $this->getSolde($compte1Id)) {
            return $this->fail('Solde insuffisant pour ce transfert (montant + frais de ' . $this->formatMontant($frais) . ' Ar).');
        }

        if (! $this->insertOperation($typeTransfert, $compte1Id, $montant, $compte2Id)) {
            return $this->fail('Le transfert a échoué, veuillez réessayer.');
        }

        if ($frais > 0) {
            $this->insertOperation($typeRetrait, $compte1Id, $frais);
        }

        $message = 'Transfert de ' . $this->formatMontant($montant) . ' Ar effectué avec succès';
        $message .= $frais > 0 ? ' (frais : ' . $this->formatMontant($frais) . ' Ar).' : '.';

        return $this->success($message);
    }

    private function formatMontant(float $montant): string
    {
        return number_format($montant, 0, ',', ' ');
    }

    private function fail(string $message): array
    {
        return ['success' => false, 'message' => $message];
    }

    private function success(string $message): array
    {
        return ['success' => true, 'message' => $message];
    }
}
