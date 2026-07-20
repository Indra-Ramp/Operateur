<?php

namespace App\Controllers;

use App\Models\CompteModel;
use App\Models\PrefixeModel;
use App\Models\OperationModel;

class AuthController extends BaseController
{
    public function index()
    {
        $prefixeModel = new PrefixeModel();
        $data['prefixes'] = $prefixeModel->findAll();

        return view('client/login', $data);
    }

    public function dashboard()
    {
        $session = session();
        $compteModel = new CompteModel();
        $operationModel = new OperationModel();

        $phone = $this->request->getPost('phone');
        $prefixe = $this->request->getPost('prefixe');

        if ($prefixe && $phone) {
            $fullPhone = $prefixe . $phone;
            $compte = $compteModel->where('tel', $fullPhone)->first();

            if (! $compte) {
                $compteId = $compteModel->insert(['tel' => $fullPhone]);
                $compte = $compteModel->find($compteId);
            }

            $session->set('compte', [
                'id' => $compte['id'],
                'tel' => $compte['tel'],
            ]);
        }

        $compteSession = $session->get('compte');

        if (! $compteSession) {
            return redirect()->to('/client/login');
        }

        $idCompte = $compteSession['id'];
        $data['soldeCompte'] = $operationModel->getSolde($idCompte);
        $data['operations'] = $operationModel
            ->select('operation.*, t.label as type_label')
            ->join('type_operation t', 'operation.id_type = t.id')
            ->groupStart()
                ->where('operation.id_compte1', $idCompte)
                ->orWhere('operation.id_compte2', $idCompte)
            ->groupEnd()
            ->orderBy('date_track', 'DESC')
            ->findAll();
        $data['compte'] = $compteSession;

        return view('client/dashboard', $data);
    }
}
