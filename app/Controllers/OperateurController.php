<?php

    namespace App\Controllers;
    use App\Models\OperateurModel;
    use App\Models\OperationModel;
    use App\Models\PrefixeModel;
    use App\Models\CommissionModel;
    class OperateurController extends BaseController {
        public function list() {
            $operateurModel = new OperateurModel();
            $data['list'] = $operateurModel->findAll();
            $data['activePage'] = 'other';
            return view('operateur/operateurs', $data);
        }

        public function listBeforeSituation() {
            $operateurModel = new OperateurModel();
            $data['list'] = $operateurModel->findAll();
            $data['activePage'] = 'situation';
            return view('operateur/list_operateurs_situation', $data);
        }

        public function listPrefix($idOp) {
            $prefixeModel = new PrefixeModel();
            $operateurModel = new OperateurModel();
            $commissionModel = new CommissionModel();
            $data['prefixes'] = $prefixeModel->where("id_operateur", $idOp)->findAll();
            $data['operator'] = $operateurModel->find($idOp);
            $data['activePage'] = 'other';
            $data['operator']['commission'] = $commissionModel->where('id_operateur', $idOp)->first()['perc'] ?? null;
            return view('operateur/prefix_operator', $data);
        }

        public function updateCommission() {
            $post = $this->request->getPost();;
            $commissionModel = new CommissionModel();
            $commissionData = $commissionModel->where('id_operateur', $post['id_operateur'])->first();
            $post['id'] = $commissionData['id'] ?? null;
            if(!$commissionModel->save($post)) {
                return redirect()->back()->withInput()->with('errors_commission', $commissionModel->errors());
            }
            return redirect()->back();
        }

        public function getSituation($idOperateur) {
            $operationModel = new OperationModel();
            $perPage = 5;
            $currentPage = (int) ($this->request->getGet('page') ?? 1);
            $currentPage = max(1, $currentPage);

            $totalOperations = $operationModel->countSituation($idOperateur);
            $totalPages = max(1, (int) ceil($totalOperations / $perPage));
            $currentPage = min($currentPage, $totalPages);
            $offset = ($currentPage - 1) * $perPage;

            $operationData = $operationModel->select('operation.*, c1.tel AS tel1, c2.tel AS tel2, (operation.montant + operation.commission) AS total_operateur')
                ->join("compte AS c1", "operation.id_compte1 = c1.id")
                ->join("compte AS c2", "operation.id_compte2 = c2.id")
                ->where('operation.id_operateur', $idOperateur)
                ->orderBy('operation.date_track', 'DESC')
                ->limit($perPage, $offset)
                ->get()
                ->getResultArray();

            $data['operations'] = $operationData;
            $data['sum'] = $operationModel->getTotalSituation($idOperateur);
            $data['currentPage'] = $currentPage;
            $data['totalPages'] = $totalPages;
            $data['perPage'] = $perPage;
            $data['totalOperations'] = $totalOperations;
            $data['idOperateur'] = $idOperateur;
            $data['activePage'] = 'situation';

            return view('operateur/situations', $data);
        }
    }

?>