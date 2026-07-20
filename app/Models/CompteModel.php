<?php

namespace App\Models;

use CodeIgniter\Model;

class CompteModel extends Model
{
    protected $table         = 'compte';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['tel'];

    protected $validationRules = [
        'tel' => 'required|exact_length[10]|numeric|is_unique[compte.tel,id,{id}]',
    ];

    protected $validationMessages = [
        'tel' => [
            'required'     => 'Le numéro de téléphone est obligatoire.',
            'exact_length' => 'Le numéro de téléphone doit contenir exactement 10 chiffres.',
            'numeric'      => 'Le numéro de téléphone ne doit contenir que des chiffres.',
            'is_unique'    => 'Ce numéro de téléphone est déjà associé à un compte.',
        ],
    ];
}
