<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class ConfigModel extends Model{
        protected $table = 'config';
        protected $allowedFields = ['cle', 'valeur'];
    }

?>