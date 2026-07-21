<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class MvtEpargneModel extends Model {
        protected $table = "mvt_epargne";
        protected $primaryKey = 'id';
        protected $allowedFields = ['id_compte', 'date_mvt', 'montant'];
        public function getEpargne($idCompte) {
            return $this->select("COALESCE(SUM(montant),0) AS sum")
            ->where("id_compte", $idCompte)
            ->get()
            ->getRowArray()['sum'];
        }
    }

?>