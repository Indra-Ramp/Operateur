<?php

    namespace App\Controllers;

    use App\Models\TypeOperationModel;
    use App\Models\TrancheModel;
    use App\Models\OperationModel;

    class FraisController extends BaseController {
        function listOperation() {
            $typeOperationModel = new TypeOperationModel();
            $data['operations'] = $typeOperationModel->where('label !=', 'depot')->findAll();
            $data['activePage'] = 'frais';
            return view('operateur/list_operations', $data);
        }

        function list($idType) {
            $trancheModel = new TrancheModel();
            $data['list'] = $trancheModel->where("id_type", $idType)->findAll();
            $data['activePage'] = 'frais';
            return view('operateur/list_fees', $data);
        }

        public function stats() 
{
    $operationModel = new OperationModel();

    // 1. Détection du mode : Semaine spécifique OU Bilan Global
    $weekOffsetParam = $this->request->getGet('week_offset');
    $isGlobalMode = ($weekOffsetParam === null);

    if (!$isGlobalMode) {
        // --- MODE SEMAINE ---
        $weekOffset = (int)$weekOffsetParam;
        $currentDate = new \DateTime();
        if ($weekOffset !== 0) {
            $currentDate->modify("$weekOffset weeks");
        }
        
        $monday = clone $currentDate;
        $monday->modify('monday this week');
        $sunday = clone $currentDate;
        $sunday->modify('sunday this week');

        $startDate = $monday->format('Y-m-d');
        $endDate = $sunday->format('Y-m-d');

        // Récupération ciblée sur la semaine
        $withdrawalOps = $operationModel->where('date_track >=', $startDate)->where('date_track <=', $endDate)->where('id_type', 1)->orderBy('date_track', 'ASC')->findAll();
        $transferOps   = $operationModel->where('date_track >=', $startDate)->where('date_track <=', $endDate)->where('id_type', 2)->orderBy('date_track', 'ASC')->findAll();
        
        $graphStartDate = $startDate;
        $graphEndDate   = $endDate;
    } else {
        // --- MODE BILAN GLOBAL ---
        $weekOffset = null;
        
        // Récupération de l'intégralité absolue des opérations
        $withdrawalOps = $operationModel->where('id_type', 1)->orderBy('date_track', 'ASC')->findAll();
        $transferOps   = $operationModel->where('id_type', 2)->orderBy('date_track', 'ASC')->findAll();

        // Détermination de la période du graphique (7 derniers jours par rapport à aujourd'hui)
        $graphEndDate   = date('Y-m-d');
        $graphStartDate = date('Y-m-d', strtotime('-6 days'));
        
        $startDate = 'Origine';
        $endDate   = 'Aujourd\'hui';
    }

    // 2. Initialisation de la structure fixe du graphique (Toujours 7 jours bien définis)
    $dailyFeesStructure = [];
    $graphPeriod = new \DatePeriod(
        new \DateTime($graphStartDate), 
        new \DateInterval('P1D'), 
        (new \DateTime($graphEndDate))->modify('+1 day')
    );
    
    foreach ($graphPeriod as $date) {
        $dailyFeesStructure[$date->format('Y-m-d')] = 0;
    }

    // 3. Cumul des Retraits (Globaux + Ventilation graphique si dans la zone du graphe)
    $withdrawalFees = 0;
    $withdrawalCount = count($withdrawalOps);
    foreach ($withdrawalOps as $operation) {
        $fee = $operationModel->getFraisForMontant($operation['montant'], 1);
        $withdrawalFees += $fee;

        $dateRaw = isset($operation['date_track']) ? trim($operation['date_track']) : null;
        if ($dateRaw) {
            $dayKey = substr($dateRaw, 0, 10);
            if (array_key_exists($dayKey, $dailyFeesStructure)) {
                $dailyFeesStructure[$dayKey] += $fee;
            }
        }
    }

    // 4. Cumul des Transferts (Globaux + Ventilation graphique si dans la zone du graphe)
    $transferFees = 0;
    $transferCount = count($transferOps);
    foreach ($transferOps as $operation) {
        $fee = $operationModel->getFraisForMontant($operation['montant'], 2);
        $transferFees += $fee;

        $dateRaw = isset($operation['date_track']) ? trim($operation['date_track']) : null;
        if ($dateRaw) {
            $dayKey = substr($dateRaw, 0, 10);
            if (array_key_exists($dayKey, $dailyFeesStructure)) {
                $dailyFeesStructure[$dayKey] += $fee;
            }
        }
    }

    // 5. Indicateurs globaux ou hebdomadaires de synthèse
    $totalFees = $transferFees + $withdrawalFees;
    $transactionCount = $withdrawalCount + $transferCount;
    $averageFee = $transactionCount > 0 ? round($totalFees / $transactionCount) : 0;

    // 6. Extraction pour Chart.js
    $dailyLabels = [];
    $dailyValues = [];
    foreach ($dailyFeesStructure as $dateStr => $totalDayFee) {
        $dailyLabels[] = date('d M', strtotime($dateStr));
        $dailyValues[] = $totalDayFee;
    }

    // 7. Envoi à la vue
    $data = [
        'activePage'   => 'stats',
        'isGlobalMode' => $isGlobalMode,
        'startDate'    => $startDate,
        'endDate'      => $endDate,
        'weekOffset'   => $weekOffset,
        'summary'      => [
            'withdrawalFees'   => $withdrawalFees,
            'transferFees'     => $transferFees,
            'totalFees'        => $totalFees,
            'averageFee'       => $averageFee,
            'transactionCount' => $transactionCount,
        ],
        'breakdown'    => [
            ['label' => 'Retrait', 'total' => $withdrawalFees, 'count' => $withdrawalCount, 'avg' => $withdrawalCount > 0 ? round($withdrawalFees / $withdrawalCount) : 0],
            ['label' => 'Transfert', 'total' => $transferFees, 'count' => $transferCount, 'avg' => $transferCount > 0 ? round($transferFees / $transferCount) : 0],
            ['label' => 'Total', 'total' => $totalFees, 'count' => $transactionCount, 'avg' => $averageFee],
        ],
        'dailyLabels'  => $dailyLabels,
        'dailyValues'  => $dailyValues,
        'tableRows'    => [
            ['title' => 'Retrait', 'amount' => $withdrawalFees, 'transactions' => $withdrawalCount, 'margin' => $withdrawalCount > 0 ? '18,4 %' : '0 %'],
            ['title' => 'Transfert', 'amount' => $transferFees, 'transactions' => $transferCount, 'margin' => $transferCount > 0 ? '14,2 %' : '0 %'],
            ['title' => 'Total', 'amount' => $totalFees, 'transactions' => $transactionCount, 'margin' => '16,5 %'],
        ],
    ];

    return view('operateur/stats', $data);
}

        protected function calculateWithdrawalFeeStats(array $withdrawalOps, OperationModel $operationModel): array
        {
            $dailyFees = [];
            $groups = [];

            foreach ($withdrawalOps as $operation) {
                $key = $operation['id_compte1'] . '|' . $operation['date_track'];
                $groups[$key][] = $operation;
            }

            $withdrawalCount = 0;
            $withdrawalFees = 0;
            $withdrawalAmount = 0;

            foreach ($groups as $group) {
                usort($group, fn($a, $b) => $b['montant'] <=> $a['montant']);
                $matchedFeeIds = [];

                foreach ($group as $operation) {
                    if (isset($matchedFeeIds[$operation['id']])) {
                        continue;
                    }

                    $amount = $operation['montant'];
                    $expectedFee = $operationModel->getFraisForMontant($amount, 1);
                    $feeMatch = null;

                    if ($expectedFee > 0) {
                        foreach ($group as $candidate) {
                            if ($candidate['id'] !== $operation['id'] && ! isset($matchedFeeIds[$candidate['id']]) && $candidate['montant'] == $expectedFee) {
                                $feeMatch = $candidate;
                                break;
                            }
                        }
                    }

                    $withdrawalCount++;
                    $withdrawalAmount += $amount;

                    if ($feeMatch !== null) {
                        $withdrawalFees += $expectedFee;
                        $matchedFeeIds[$feeMatch['id']] = true;
                        $day = $operation['date_track'];
                        $dailyFees[$day] = ($dailyFees[$day] ?? 0) + $expectedFee;
                    }
                }
            }

            return [$withdrawalFees, $withdrawalCount, $withdrawalAmount, $dailyFees];
        }

        function addFee() {
            $trancheModel = new TrancheModel();
            $post = $this->request->getPost();
            if(!empty($post['montant1']) && !empty($post['montant2'])) {
                if($post['montant2'] <= $post['montant1']) {
                    $error['montant2'] = "Le montant maximum doit etre superieur au montant minimum.";
                    return redirect()->back()->withInput()->with('add_errors', $error);
                }
                if(!empty($post['id_type'])) {
                    if($trancheModel->isIntervalOverlapping($post['montant1'], $post['montant2'], $post['id_type'])) {
                        $error['montant2'] = "L'intervalle se chevauche avec une autre.";
                        $error['montant1'] = "L'intervalle se chevauche avec une autre.";
                        return redirect()->back()->withInput()->with('add_errors', $error);
                    }
                } 
            }
            if(!$trancheModel->save($post)) {
                return redirect()->back()->withInput()->with('add_errors', $trancheModel->errors());
            }
            return redirect()->back();
        }

        function updateFee() {
            $trancheModel = new TrancheModel();
            $post = $this->request->getPost();
            if($post['montant1'] !== '' && ['montant2'] !== '') {
                if($post['montant2'] <= $post['montant1']) {
                    $error['montant2'] = "Le montant maximum doit etre superieur au montant minimum.";
                    return redirect()->back()->withInput()->with('update_errors', $error)->with('error_id', $post['id']);
                }
                if(!empty($post['id_type'])) {
                    if($trancheModel->isIntervalOverlapping($post['montant1'], $post['montant2'], $post['id_type'], $post['id'])) {
                        $error['montant2'] = "L'intervalle se chevauche avec une autre.";
                        $error['montant1'] = "L'intervalle se chevauche avec une autre.";
                        return redirect()->back()->withInput()->with('update_errors', $error)->with('error_id', $post['id']);
                    }
                } 
            }
            if(!$trancheModel->save($post)) {
                return redirect()->back()->withInput()->with('update_errors', $trancheModel->errors())->with('error_id', $post['id']);
            }
            return redirect()->back();
            // var_dump($post['montant1']);
        }

    }

?>