<?php

    namespace App\Controllers;

    use App\Models\TypeOperationModel;
    use App\Models\TrancheModel;

    class FraisController extends BaseController {
        function listOperation() {
            $typeOperationModel = new TypeOperationModel();
            $data['operations'] = $typeOperationModel->where('label !=', 'depot')->findAll();
            return view('operateur/list_operations', $data);
        }

        function list($idType) {
            $trancheModel = new TrancheModel();
            $data['list'] = $trancheModel->where("id_type", $idType)->findAll();
            return view('operateur/list_fees', $data);
        }

        function addFee() {
            $trancheModel = new TrancheModel();
            $post = $this->request->getPost();
            if(!empty($post['montant1']) && !empty($post['montant2'])) {
                if($post['montant2'] <= $post['montant1']) {
                    $error['montant2'] = "Le montant maximum doit etre superieur au montant minimum.";
                    return redirect()->back()->withInput()->with('add_errors', $error);
                }
                if(!empty($post['id_type'])) {
                    if($trancheModel->isIntervalOverlapping($post['montant1'], $post['montant2'], $post['id_type'])) {
                        $error['montant2'] = "L'intervalle se chevauche avec une autre.";
                        $error['montant1'] = "L'intervalle se chevauche avec une autre.";
                        return redirect()->back()->withInput()->with('add_errors', $error);
                    }
                } 
            }
            if(!$trancheModel->save($post)) {
                return redirect()->back()->withInput()->with('add_errors', $trancheModel->errors());
            }
            return redirect()->back();
        }

        function updateFee() {
            $trancheModel = new TrancheModel();
            $post = $this->request->getPost();
            if($post['montant1'] !== '' && ['montant2'] !== '') {
                if($post['montant2'] <= $post['montant1']) {
                    $error['montant2'] = "Le montant maximum doit etre superieur au montant minimum.";
                    return redirect()->back()->withInput()->with('update_errors', $error)->with('error_id', $post['id']);
                }
                if(!empty($post['id_type'])) {
                    if($trancheModel->isIntervalOverlapping($post['montant1'], $post['montant2'], $post['id_type'], $post['id'])) {
                        $error['montant2'] = "L'intervalle se chevauche avec une autre.";
                        $error['montant1'] = "L'intervalle se chevauche avec une autre.";
                        return redirect()->back()->withInput()->with('update_errors', $error)->with('error_id', $post['id']);
                    }
                } 
            }
            if(!$trancheModel->save($post)) {
                return redirect()->back()->withInput()->with('update_errors', $trancheModel->errors())->with('error_id', $post['id']);
            }
            return redirect()->back();
            // var_dump($post['montant1']);
        }

    }

?>