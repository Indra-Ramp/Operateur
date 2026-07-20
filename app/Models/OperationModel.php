<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table = 'operation';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_type', 'id_compte1', 'id_compte2', 'montant', 'date_track', 'id_operateur'];

    public function getSolde($idCompte)
    {
        $entrees = $this->builder()
            ->selectSum('montant')
            ->join('type_operation t', 'operation.id_type = t.id')
            ->groupStart()
                ->where(['t.label' => 'depot', 'operation.id_compte1' => $idCompte])
                ->orWhere(['t.label' => 'transfert', 'operation.id_compte2' => $idCompte])
            ->groupEnd()
            ->get()
            ->getRow()->montant ?? 0;

        $sorties = $this->builder()
            ->selectSum('montant')
            ->join('type_operation t', 'operation.id_type = t.id')
            ->groupStart()
                ->where(['t.label' => 'retrait', 'operation.id_compte1' => $idCompte])
                ->orWhere(['t.label' => 'transfert', 'operation.id_compte1' => $idCompte])
            ->groupEnd()
            ->get()
            ->getRow()->montant ?? 0;

        return $entrees - $sorties;
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

    protected function insertOperation(int $typeId, int $compte1Id, float $montant, ?int $compte2Id = null)
    {
        return $this->insert([
            'id_type' => $typeId,
            'id_compte1' => $compte1Id,
            'id_compte2' => $compte2Id,
            'montant' => $montant,
            'date_track' => date('Y-m-d'),
        ]);
    }

    public function depot(int $compteId, float $montant)
    {
        if ($compteId <= 0 || $montant <= 0) {
            return false;
        }

        return $this->insertOperation(3, $compteId, $montant, null);
    }

    public function retrait(int $compteId, float $montant)
    {
        if ($compteId <= 0 || $montant <= 0) {
            return false;
        }

        $operationId = $this->insertOperation(1, $compteId, $montant, null);
        $frais = $this->getFraisForMontant($montant, 1);

        if ($frais > 0) {
            $this->insertOperation(1, $compteId, $frais, null);
        }

        return $operationId;
    }

    public function transfert(int $compte1Id, int $compte2Id, float $montant)
    {
        if ($compte1Id <= 0 || $compte2Id <= 0 || $montant <= 0) {
            return false;
        }

        $operationId = $this->insertOperation(2, $compte1Id, $montant, $compte2Id);
        $frais = $this->getFraisForMontant($montant, 2);

        if ($frais > 0) {
            $this->insertOperation(1, $compte1Id, $frais, null);
        }

        return $operationId;
    }
}

?>