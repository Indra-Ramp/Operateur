<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class CompteModel extends Model{
        protected $table = 'compte';
        protected $primaryKey = 'id';
        protected $allowedFields = ['nom', 'prenom', 'date_naissance', 'tel', 'adresse'];
    }

?>