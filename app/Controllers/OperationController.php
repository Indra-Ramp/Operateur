<?php

namespace App\Controllers;

use App\Models\CompteModel;
use App\Models\OperationModel;
use App\Models\PrefixeModel;

class OperationController extends BaseController
{
    public function transactions()
    {
        $compte = session()->get('compte');
        $compteId = isset($compte['id']) ? (int) $compte['id'] : null;

        if (!$compteId) {
            return redirect()->to('/client/login');
        }

        $operationModel = new OperationModel();
        $prefixeModel   = new PrefixeModel();

        return view('client/transaction', [
            'prefixes'    => $prefixeModel->findAll(),
            'soldeCompte' => $operationModel->getSolde($compteId),
            'recentes'    => $operationModel->getHistorique($compteId, 3),
            'compte'      => $compte,
        ]);
    }

    public function depot(){
        $operationModel = new OperationModel();
        $compte = session()->get('compte');
        $compteId = isset($compte['id']) ? (int) $compte['id'] : null;

        if (!$compteId) {
            return redirect()->to('/client/login');
        }

        $raw = $this->request->getPost('montant');
        $montant = ($raw !== null && $raw !== '' && is_numeric($raw) && (float)$raw > 0) ? (float)$raw : null;

        if ($montant === null) {
            return redirect()->back()->withInput()->with('error', 'Veuillez saisir un montant valide.');
        }

        $result = $operationModel->depot($compteId, $montant);

        return redirect()->to('/client/dashboard')->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function retrait(){
        $operationModel = new OperationModel();
        $compte = session()->get('compte');
        $compteId = isset($compte['id']) ? (int) $compte['id'] : null;

        if (!$compteId) {
            return redirect()->to('/client/login');
        }

        $raw = $this->request->getPost('montant');
        $montant = ($raw !== null && $raw !== '' && is_numeric($raw) && (float)$raw > 0) ? (float)$raw : null;

        if ($montant === null) {
            return redirect()->back()->withInput()->with('error', 'Veuillez saisir un montant valide.');
        }

        $result = $operationModel->retrait($compteId, $montant);

        return redirect()->to('/client/dashboard')->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function transfert(){
        $operationModel = new OperationModel();
        $compte = session()->get('compte');
        $compteId = isset($compte['id']) ? (int) $compte['id'] : null;

        if (!$compteId) {
            return redirect()->to('/client/login');
        }

        $raw = $this->request->getPost('montant');
        $montant = ($raw !== null && $raw !== '' && is_numeric($raw) && (float)$raw > 0) ? (float)$raw : null;

        if ($montant === null) {
            return redirect()->back()->withInput()->with('error', 'Veuillez saisir un montant valide.');
        }

        $prefixe = trim((string) $this->request->getPost('prefixe'));
        $phone   = trim((string) $this->request->getPost('phone'));

        if (!preg_match('/^\d{3}$/', $prefixe) || !preg_match('/^\d{7}$/', $phone)) {
            return redirect()->back()->withInput()->with('error', 'Numéro de téléphone invalide.');
        }

        $tel = $prefixe . $phone;
        $compteModel = new CompteModel();
        $destinataireRow = $compteModel->where('tel', $tel)->first();

        if ($destinataireRow) {
            $destinataire = (int) $destinataireRow['id'];
        } else {
            $destinataire = $compteModel->insert(['tel' => $tel]);
            if (!$destinataire) {
                return redirect()->back()->withInput()->with('error', "Impossible de créer le compte destinataire.");
            }
            $destinataire = (int) $destinataire;
        }

        $inclureFrais = (bool) $this->request->getPost('inclure_frais');

        $result = $operationModel->transfert($compteId, $destinataire, $montant, $inclureFrais);

        return redirect()->to('/client/dashboard')->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function transfertMultiple()
    {
        $compte = session()->get('compte');
        $compteId = isset($compte['id']) ? (int) $compte['id'] : null;

        if (!$compteId) {
            return redirect()->to('/client/login');
        }

        $raw = $this->request->getPost('montant');
        $montant = ($raw !== null && $raw !== '' && is_numeric($raw) && (float)$raw > 0) ? (float)$raw : null;

        if ($montant === null) {
            return redirect()->back()->withInput()->with('error', 'Veuillez saisir un montant total valide.');
        }

        $prefixes = $this->request->getPost('prefixe');
        $phones   = $this->request->getPost('phone');

        if (!is_array($prefixes) || !is_array($phones) || count($prefixes) !== count($phones)) {
            return redirect()->back()->withInput()->with('error', 'La liste des destinataires est invalide.');
        }

        $destinataires = [];
        $compteModel = new CompteModel();

        foreach ($prefixes as $index => $rawPrefixe) {
            $rawPhone = $phones[$index] ?? null;

            if (trim((string) $rawPrefixe) === '' && trim((string) $rawPhone) === '') {
                continue;
            }

            $prefixe = trim((string) $rawPrefixe);
            $phone   = trim((string) $rawPhone);

            if (!preg_match('/^\d{3}$/', $prefixe) || !preg_match('/^\d{7}$/', $phone)) {
                return redirect()->back()->withInput()->with('error', 'Destinataire n°' . ($index + 1) . ' : Téléphone invalide.');
            }

            $tel = $prefixe . $phone;
            $destinataireRow = $compteModel->where('tel', $tel)->first();

            if ($destinataireRow) {
                $destinataires[] = (int) $destinataireRow['id'];
            } else {
                $newId = $compteModel->insert(['tel' => $tel]);
                if (!$newId) {
                    return redirect()->back()->withInput()->with('error', 'Destinataire n°' . ($index + 1) . ' : Échec de création.');
                }
                $destinataires[] = (int) $newId;
            }
        }

        if (count($destinataires) < 2) {
            return redirect()->back()->withInput()->with('error', 'Un envoi multiple nécessite au moins deux destinataires valides.');
        }

        $inclureFrais = (bool) $this->request->getPost('inclure_frais');

        $operationModel = new OperationModel();
        $result = $operationModel->transfertMultiple($compteId, $destinataires, $montant, $inclureFrais);

        return redirect()->to('/client/dashboard')->with($result['success'] ? 'success' : 'error', $result['message']);
    }
}
