<?php

    namespace App\Controllers;
    use App\Models\PrefixeModel;
    class PrefixeController extends BaseController {
        function list() {
            $prefixeModel = new PrefixeModel();
            $data['prefixes'] = $prefixeModel->findAll();
            return view('operateur/prefix', $data);
        }

        function addPrefix() {
            $data = $this->request->getPost();
            $prefix = new PrefixeModel();
            if(!$prefix->save($data)) {
                return redirect()->back()->with('errors', $prefix->errors());
            }
            return redirect()->to('/operateur/prefix');
        }

    }

?>