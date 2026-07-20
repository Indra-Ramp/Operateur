<?php

namespace App\Controllers;

use App\Libraries\PhoneHelper;
use App\Models\CompteModel;
use App\Models\OperationModel;
use App\Models\PrefixeModel;

class OperationController extends BaseController
{

    public function transactions()
    {
        $compteId = $this->getCompteConnecteId();

        if (! $compteId) {
            return redirect()->to('/client/login');
        }

        $operationModel = new OperationModel();
        $prefixeModel   = new PrefixeModel();

        return view('client/transaction', [
            'prefixes'    => $prefixeModel->findAll(),
            'soldeCompte' => $operationModel->getSolde($compteId),
            'recentes'    => $operationModel->getHistorique($compteId, 3),
            'compte'      => session()->get('compte'),
        ]);
    }

    public function depot()
    {
        return $this->handleOperation(
            fn (OperationModel $model, int $compteId, float $montant) => $model->depot($compteId, $montant)
        );
    }

    public function retrait()
    {
        return $this->handleOperation(
            fn (OperationModel $model, int $compteId, float $montant) => $model->retrait($compteId, $montant)
        );
    }

    public function transfert()
    {
        $compteId = $this->getCompteConnecteId();

        if (! $compteId) {
            return redirect()->to('/client/login');
        }

        $montant = $this->parseMontant($this->request->getPost('montant'));

        if ($montant === null) {
            return redirect()->back()->withInput()->with('error', 'Veuillez saisir un montant valide.');
        }

        $destinataire = $this->resolveDestinataireId(
            $this->request->getPost('prefixe'),
            $this->request->getPost('phone')
        );

        if (is_string($destinataire)) {
            return redirect()->back()->withInput()->with('error', $destinataire);
        }

        $result = (new OperationModel())->transfert($compteId, $destinataire, $montant);

        return redirect()->to('/client/dashboard')
            ->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    private function handleOperation(callable $operation)
    {
        $compteId = $this->getCompteConnecteId();

        if (! $compteId) {
            return redirect()->to('/client/login');
        }

        $montant = $this->parseMontant($this->request->getPost('montant'));

        if ($montant === null) {
            return redirect()->back()->withInput()->with('error', 'Veuillez saisir un montant valide.');
        }

        $result = $operation(new OperationModel(), $compteId, $montant);

        return redirect()->to('/client/dashboard')
            ->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    private function parseMontant($raw): ?float
    {
        if ($raw === null || $raw === '' || ! is_numeric($raw)) {
            return null;
        }

        $montant = (float) $raw;

        return $montant > 0 ? $montant : null;
    }

    private function getCompteConnecteId(): ?int
    {
        $compte = session()->get('compte');

        return isset($compte['id']) ? (int) $compte['id'] : null;
    }

    private function resolveDestinataireId(?string $prefix, ?string $phone)
    {
        $check = PhoneHelper::validate($prefix, $phone);

        if (! $check['valid']) {
            return implode(' ', $check['errors']);
        }

        $compteModel = new CompteModel();
        $destinataire = $compteModel->where('tel', $check['phone'])->first();

        if ($destinataire) {
            return (int) $destinataire['id'];
        }

        $newId = $compteModel->insert(['tel' => $check['phone']]);

        if (! $newId) {
            return "Impossible de créer le compte destinataire.";
        }

        return (int) $newId;
    }
}
