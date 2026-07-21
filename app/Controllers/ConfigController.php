<?php

    namespace App\Controllers;

    use App\Models\ConfigModel;

    class ConfigController extends BaseController{
        
        public function renderForm(){
            return view('operateur/configuration');
        }

        public function create(){
            $input = $this->request->getPost();
            $configModel = new configModel();

            $configModel->save($input);

            return redirect()->back()->withInput()->with('success', "Ajout de configuration avec succes");
        }
    }

?>