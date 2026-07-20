<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class TrancheModel extends Model{
        protected $table = 'tranche';
        protected $primaryKey = 'id';
        protected $allowedFields = ['montant1', 'montant2', 'frais', 'id_type'];
        protected $validationRules = [
            'montant1' => 'required|numeric|greater_than_equal_to[0]',
            'montant2' => 'required|numeric|greater_than_equal_to[0]',
            'frais'    => 'required|numeric|greater_than_equal_to[0]',
            'id_type'  => 'required|is_natural_no_zero',
        ];

        protected $validationMessages = [
            'montant1' => [
                'required'              => 'Le montant minimum est obligatoire.',
                'numeric'               => 'Le montant minimum doit être un nombre valide.',
                'greater_than_equal_to' => 'Le montant minimum ne peut pas être inférieur à 0.',
            ],
            'montant2' => [
                'required'              => 'Le montant maximum est obligatoire.',
                'numeric'               => 'Le montant maximum doit être un nombre valide.',
                'greater_than_equal_to' => 'Le montant maximum ne peut pas être inférieur à 0.',
            ],
            'frais' => [
                'required'              => 'Le montant des frais est obligatoire.',
                'numeric'               => 'Les frais doivent être un nombre valide.',
                'greater_than_equal_to' => 'Les frais ne peuvent pas être inférieurs à 0.',
            ],
            'id_type' => [
                'required'            => 'Le type d\'opération est requis.',
                'is_natural_no_zero'  => 'Le type d\'opération sélectionné n\'est pas valide.',
            ],
        ];

        public function isIntervalOverlapping($montant1, $montant2, $id_type, $excludeId = null): bool {
            $builder = $this->builder();

            $builder->where('id_type', $id_type);

            if ($excludeId !== null) {
                $builder->where('id !=', $excludeId); 
            }

            $builder->groupStart()
                    ->where('montant1 <=', $montant2)
                    ->where('montant2 >=', $montant1)
                    ->groupEnd();

            return $builder->countAllResults() > 0;
        }
    }

?>