<?php

namespace App\Controllers;

use App\Libraries\PhoneHelper;
use App\Models\CompteModel;
use App\Models\OperationModel;
use App\Models\PrefixeModel;

class AuthController extends BaseController
{

    public function index()
    {
        if (session()->get('compte')) {
            return redirect()->to('/client/dashboard');
        }

        $prefixeModel = new PrefixeModel();

        return view('client/login', [
            'prefixes' => $prefixeModel->findAll(),
        ]);
    }

    public function dashboard()
    {
        if ($this->request->getMethod() === 'post') {
            $loginResult = $this->attemptLogin();

            if ($loginResult !== true) {
                return $loginResult;
            }
        }

        $compteSession = session()->get('compte');

        if (! $compteSession) {
            return redirect()->to('/client/login');
        }

        $operationModel = new OperationModel();
        $idCompte = (int) $compteSession['id'];

        $perPage = 5;
        $totalOperations = $operationModel->countHistorique($idCompte);
        $totalPages = max(1, (int) ceil($totalOperations / $perPage));

        $page = (int) ($this->request->getGet('page') ?? 1);
        $page = max(1, min($page, $totalPages));

        $operations = $operationModel->getHistorique($idCompte, $perPage, ($page - 1) * $perPage);

        return view('client/dashboard', [
            'compte'           => $compteSession,
            'soldeCompte'      => $operationModel->getSolde($idCompte),
            'operations'       => $operations,
            'currentPage'      => $page,
            'totalPages'       => $totalPages,
            'totalOperations'  => $totalOperations,
            'perPage'          => $perPage,
        ]);
    }

    public function logout()
    {
        session()->remove('compte');
        session()->destroy();

        return redirect()->to('/client/login');
    }

    private function attemptLogin()
    {
        $prefixe = $this->request->getPost('prefixe');
        $phone   = $this->request->getPost('phone');

        $check = PhoneHelper::validate($prefixe, $phone);

        if (! $check['valid']) {
            return redirect()->to('/client/login')
                ->withInput()
                ->with('errors', $check['errors']);
        }

        $compteModel = new CompteModel();
        $compte = $compteModel->where('tel', $check['phone'])->first();

        if (! $compte) {
            $compteId = $compteModel->insert(['tel' => $check['phone']]);

            if (! $compteId) {
                return redirect()->to('/client/login')
                    ->withInput()
                    ->with('errors', $compteModel->errors() ?: ['Impossible de créer le compte, veuillez réessayer.']);
            }

            $compte = $compteModel->find($compteId);
        }

        session()->set('compte', [
            'id'  => $compte['id'],
            'tel' => $compte['tel'],
        ]);

        return true;
    }
}
