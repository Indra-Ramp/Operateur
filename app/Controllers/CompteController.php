<?php

    namespace App\Controllers;

    use App\Models\CompteModel;

    class CompteController extends BaseController{
        public function formEpargne() {
            $compte = session()->get('compte');
            return view('client/epargne.php', ['compte' => $compte]);
        }

        public function updateEpargne() {
            $post = $this->request->getPost();
            $compteModel = new CompteModel();
            $compte = session()->get('compte');
            $compte['epargne'] = $post['epargne'];
            $compteModel
            ->update($compte['id'], ['epargne' => $compte['epargne']]);
            session()->set('compte', $compteModel->find($compte['id']));
            return redirect()->back();
        }
    }

?>