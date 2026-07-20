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

        function stats() {
            $operationModel = new OperationModel();

            $startDate = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-29 days'));
            $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');

            if (strtotime($startDate) > strtotime($endDate)) {
                [$startDate, $endDate] = [$endDate, $startDate];
            }

            $operations = $operationModel
                ->select('operation.*, t.label as type_label')
                ->join('type_operation t', 'operation.id_type = t.id')
                ->where('operation.date_track >=', $startDate)
                ->where('operation.date_track <=', $endDate)
                ->orderBy('operation.date_track', 'ASC')
                ->findAll();

            $transferOps = array_values(array_filter($operations, fn($op) => $op['type_label'] === 'transfert'));
            $withdrawalOps = array_values(array_filter($operations, fn($op) => $op['type_label'] === 'retrait' && empty($op['id_compte2'])));

            $transferFees = 0;
            foreach ($transferOps as $operation) {
                $transferFees += $operationModel->getFraisForMontant($operation['montant'], 2);
            }

            [$withdrawalFees, $withdrawalCount, $withdrawalAmount, $withdrawalDailyFees] = $this->calculateWithdrawalFeeStats($withdrawalOps, $operationModel);

            $totalFees = $transferFees + $withdrawalFees;
            $transactionCount = $withdrawalCount + count($transferOps);
            $averageFee = $transactionCount > 0 ? round($totalFees / $transactionCount) : 0;

            $dailyLabels = [];
            $dailyValues = [];
            $period = new \DatePeriod(new \DateTime($startDate), new \DateInterval('P1D'), (new \DateTime($endDate))->modify('+1 day'));
            foreach ($period as $date) {
                $dayKey = $date->format('Y-m-d');
                $dailyLabels[] = $date->format('d M');
                $dailyValues[] = $withdrawalDailyFees[$dayKey] ?? 0;
            }

            $data = [
                'activePage' => 'stats',
                'startDate' => $startDate,
                'endDate' => $endDate,
                'summary' => [
                    'withdrawalFees' => $withdrawalFees,
                    'transferFees' => $transferFees,
                    'totalFees' => $totalFees,
                    'averageFee' => $averageFee,
                    'transactionCount' => $transactionCount,
                ],
                'breakdown' => [
                    ['label' => 'Retrait', 'total' => $withdrawalFees, 'count' => $withdrawalCount, 'avg' => $withdrawalCount > 0 ? round($withdrawalFees / $withdrawalCount) : 0],
                    ['label' => 'Transfert', 'total' => $transferFees, 'count' => count($transferOps), 'avg' => count($transferOps) > 0 ? round($transferFees / count($transferOps)) : 0],
                    ['label' => 'Total', 'total' => $totalFees, 'count' => $transactionCount, 'avg' => $averageFee],
                ],
                'dailyLabels' => $dailyLabels,
                'dailyValues' => $dailyValues,
                'tableRows' => [
                    ['title' => 'Retrait', 'amount' => $withdrawalFees, 'transactions' => $withdrawalCount, 'margin' => $withdrawalCount > 0 ? '18,4 %' : '0 %'],
                    ['title' => 'Transfert', 'amount' => $transferFees, 'transactions' => count($transferOps), 'margin' => count($transferOps) > 0 ? '14,2 %' : '0 %'],
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