<?php

namespace App\Controllers;

use App\Models\CompteModel;
use App\Models\OperationModel;
use App\Models\PrefixeModel;

class OperationController extends BaseController
{
    protected $operationModel;

    public function transactions(){
        $prefixeModel = new PrefixeModel();
        $data['prefixes'] = $prefixeModel->findAll();

        return view('client/transaction', $data);
    }

    protected function getCompteConnecteId(): ?int
    {
        $session = session();
        $compte = $session->get('compte');

        return isset($compte['id']) ? (int) $compte['id'] : null;
    }

    protected function normalizePrefix(?string $prefix): string
    {
        return preg_replace('/[^0-9]/', '', trim((string) $prefix));
    }

    protected function resolveDestinataireId(?int $compte2Id, ?string $prefix, ?string $phone)
    {
        if ($compte2Id !== null && $compte2Id > 0) {
            return $compte2Id;
        }

        $prefix = $this->normalizePrefix($prefix);
        $phone = preg_replace('/\D/', '', (string) $phone);

        if (empty($prefix) || empty($phone)) {
            return 'Le préfixe et le numéro destinataire sont requis.';
        }

        if (strlen($phone) !== 10) {
            return 'Le numéro destinataire doit contenir exactement 10 chiffres.';
        }

        $prefixeModel = new PrefixeModel();
        $prefixe = $prefixeModel->where('label', $prefix)->first();

        if (! $prefixe) {
            $prefixeId = $prefixeModel->insert(['label' => $prefix]);
            if (! $prefixeId) {
                return 'Impossible d\'enregistrer le préfixe destinataire.';
            }
        }

        $compteModel = new CompteModel();
        $destinataire = $compteModel->where('tel', $phone)->first();

        if ($destinataire) {
            return (int) $destinataire['id'];
        }

        $newId = $compteModel->insert(['tel' => $phone]);

        if (! $newId) {
            return 'Impossible de créer le compte destinataire.';
        }

        return (int) $newId;
    }

    public function depot($montant = null, $compteId = null){
        $operationModel = new OperationModel();
        if ($montant === null) {
            $montant = $this->request->getPost('montant') ?? $this->request->getPost('amount');
        }

        $compteId = $compteId ?: $this->getCompteConnecteId();

        return $operationModel->depot((int) $compteId, (float) $montant);
    }

    public function retrait($montant = null, $compteId = null)
    {
        $operationModel = new OperationModel();
        if ($montant === null) {
            $montant = $this->request->getPost('montant') ?? $this->request->getPost('amount');
        }

        $compteId = $compteId ?: $this->getCompteConnecteId();

        return $operationModel->retrait((int) $compteId, (float) $montant);
    }

    public function transfert($compte2Id = null, $montant = null, $compte1Id = null)
    {
        $operationModel = new OperationModel();

        if ($compte2Id == null) {
            $compte2Id = $this->request->getPost('compte2') ?? $this->request->getPost('id_compte2');
        }

        $prefix = $this->request->getPost('prefixe') ?? $this->request->getPost('prefix');
        $phone = $this->request->getPost('phone') ?? $this->request->getPost('numero');

        if ($montant == null) {
            $montant = $this->request->getPost('montant') ?? $this->request->getPost('amount');
        }

        $compte1Id = $compte1Id ?: $this->getCompteConnecteId();

        $resolved = $this->resolveDestinataireId($compte2Id ? (int) $compte2Id : null, $prefix, $phone);

        if (is_string($resolved)) {
            return redirect()->back()->withInput()->with('error', $resolved);
        }

        $compte2Id = $resolved;

        $result = $operationModel->transfert((int) $compte1Id, (int) $compte2Id, (float) $montant);

        if ($result === false) {
            return redirect()->back()->withInput()->with('error', 'La transaction de transfert a échoué.');
        }

        return redirect()->to('/client/dashboard')->with('success', 'Transfert effectué avec succès.');
    }
}
