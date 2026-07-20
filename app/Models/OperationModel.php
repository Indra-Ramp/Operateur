<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class OperationModel extends Model{
        protected $table = 'compte';
        protected $primaryKey = 'id';
        protected $allowedFields = ['label'];
    }

?>