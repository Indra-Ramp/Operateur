<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class OperateurModel extends Model{
        protected $table = 'operateur';
        protected $primaryKey = 'id';
        protected $allowedFields = ['label'];
        protected $validationRules = [
            'label' => 'required|is_unique[prefixe.label]'
        ];
        protected $validationMessages = [
            'label' => [
                'required' => 'Le champ prefixe est requis.',
                'is_unique' => 'Ce prefixe existe deja.'
            ]
        ];
    }

?>