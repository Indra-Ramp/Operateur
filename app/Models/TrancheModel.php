<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class TrancheModel extends Model{
        protected $table = 'tranche';
        protected $primaryKey = 'id';
        protected $allowedFields = ['montant1', 'montant2', 'frais'];
    }

?>