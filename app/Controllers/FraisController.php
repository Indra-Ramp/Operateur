<?php

    namespace App\Controllers;

    use App\Models\OperationModel;

    class FraisController extends BaseController {
        function listOperation() {
            $operationModel = new OperationModel();
            $data['operations'] = $operationModel->findAll();
            return view('operateur/list_operations', $data);
        }
    }

?>