<?php

    namespace App\Controllers;
    use App\Models\PrefixeModel;
    class PrefixeController extends BaseController {
        function list() {
            $prefixeModel = new PrefixeModel();
            $data['prefixes'] = $prefixeModel->where('id_operateur', NULL)->findAll();
            $data['activePage'] = 'prefixes';
            return view('operateur/prefix', $data);
        }

        function addPrefix() {
            $data = $this->request->getPost();
            $prefix = new PrefixeModel();
            if(!$prefix->save($data)) {
                return redirect()->back()->with('errors', $prefix->errors());
            }
            if(!empty($data['id_operateur'])) {
                return redirect()->to('/operateur/prefix/'.$data['id_operateur']);
            }
            return redirect()->to('/operateur/prefix');
        }

    }

?>