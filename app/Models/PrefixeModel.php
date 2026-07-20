<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class PrefixeModel extends Model{
        protected $table = 'prefixe';
        protected $primaryKey = 'id';
        protected $allowedFields = ['label', 'created_at', 'id_operateur'];
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