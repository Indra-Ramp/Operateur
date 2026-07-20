<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class CommissionModel extends Model {
        protected $table = "commission";
        protected $primaryKey = "id";
        protected $allowedFields = ["id_operateur", "perc"];
        protected $validationRules = [
            "perc" => "required|greater_than_equal_to[0]|less_than_equal_to[1]"
        ];
        protected $validationMessages = [
            "perc" => [
                'required' => 'Le pourcentage est requis.',
                'greater_than_equal_to' => 'Le pourcentage ne peut pas etre inferieur a 0.',
                'less_than_equal_to' => 'Le pourcentage ne peut pas etre superieur a 1.'
            ]
        ];
    }

?>