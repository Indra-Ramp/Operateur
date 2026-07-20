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
            $operationData = $operationModel->where('id_operateur', $idOperateur)->findAll();
            $data['operation'] = $operationData;
            $data['sum'] = $operationModel->getTotalSituation($idOperateur);
            
        }
    }

?>