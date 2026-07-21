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

        // public function stats() {
        //     $operationModel = new OperationModel();
        //     $weekOffsetParam = $this->request->getGet('week_offset');
        //     $isGlobalMode = ($weekOffsetParam === null);

        //     if (!$isGlobalMode) {
        //         $weekOffset = (int)$weekOffsetParam;
        //         $currentDate = new \DateTime();
        //         if ($weekOffset !== 0) {
        //             $currentDate->modify("$weekOffset weeks");
        //         }
        //         $monday = clone $currentDate->modify('monday this week');
        //         $sunday = clone $currentDate->modify('sunday this week');

        //         $startDate = $monday->format('Y-m-d');
        //         $endDate = $sunday->format('Y-m-d');
                
        //         $graphStartDate = $startDate;
        //         $graphEndDate   = $endDate;
        //     } else {
        //         $weekOffset = null;
        //         $graphEndDate   = date('Y-m-d');
        //         $graphStartDate = date('Y-m-d', strtotime('-6 days'));
                
        //         $startDate = 'Origine';
        //         $endDate   = 'Aujourd\'hui';
        //     }
        //     $globalStats = $operationModel->getStat($startDate, $endDate, $isGlobalMode);
        //     $wFees = (float)($globalStats['withdrawalFees'] ?? 0);
        //     $wCount = (int)($globalStats['withdrawalCount'] ?? 0);
            
        //     $tInternalFees = (float)($globalStats['transferInternalFees'] ?? 0);
        //     $tInternalCount = (int)($globalStats['transferInternalCount'] ?? 0);
            
        //     $tExternalFees = (float)($globalStats['transferExternalFees'] ?? 0);
        //     $tExternalCount = (int)($globalStats['transferExternalCount'] ?? 0);

        //     $totalTransferFees = $tInternalFees + $tExternalFees;
        //     $totalTransferCount = $tInternalCount + $tExternalCount;
            
        //     $totalFees = $wFees + $totalTransferFees;
        //     $transactionCount = $wCount + $totalTransferCount;
        //     $averageFee = $transactionCount > 0 ? round($totalFees / $transactionCount) : 0;
        //     $graphRows = $operationModel->getGraphStat($graphStartDate, $graphEndDate);
        //     $indexedGraph = [];
        //     foreach ($graphRows as $row) {
        //         $indexedGraph[$row['date_jour']] = $row;
        //     }
        //     $dailyLabels = [];
        //     $dailyInternalValues = [];
        //     $dailyExternalValues = [];
            
        //     $graphPeriod = new \DatePeriod(
        //         new \DateTime($graphStartDate), 
        //         new \DateInterval('P1D'), 
        //         (new \DateTime($graphEndDate))->modify('+1 day')
        //     );
        //     foreach ($graphPeriod as $date) {
        //         $dayKey = $date->format('Y-m-d');
        //         $dailyLabels[] = $date->format('d M');
        //         $dailyInternalValues[] = (float)($indexedGraph[$dayKey]['daily_internal'] ?? 0);
        //         $dailyExternalValues[] = (float)($indexedGraph[$dayKey]['daily_external'] ?? 0);
        //     }
        //     $data = [
        //         'activePage'          => 'stats',
        //         'isGlobalMode'        => $isGlobalMode,
        //         'startDate'           => $startDate,
        //         'endDate'             => $endDate,
        //         'weekOffset'          => $weekOffset,
        //         'summary'             => [
        //             'withdrawalFees'   => $wFees,
        //             'transferFees'     => $totalTransferFees,
        //             'totalFees'        => $totalFees,
        //             'averageFee'       => $averageFee,
        //             'transactionCount' => $transactionCount,
        //         ],
        //         'breakdown'           => [
        //             ['label' => 'Retrait', 'total' => $wFees, 'count' => $wCount, 'avg' => $wCount > 0 ? round($wFees / $wCount) : 0],
        //             ['label' => 'Transfert Interne', 'total' => $tInternalFees, 'count' => $tInternalCount, 'avg' => $tInternalCount > 0 ? round($tInternalFees / $tInternalCount) : 0],
        //             ['label' => 'Transfert Externe', 'total' => $tExternalFees, 'count' => $tExternalCount, 'avg' => $tExternalCount > 0 ? round($tExternalFees / $tExternalCount) : 0],
        //             ['label' => 'Total', 'total' => $totalFees, 'count' => $transactionCount, 'avg' => $averageFee],
        //         ],
        //         'dailyLabels'         => $dailyLabels,
        //         'dailyInternalValues' => $dailyInternalValues,
        //         'dailyExternalValues' => $dailyExternalValues,
        //         'tableRows'           => [
        //             ['title' => 'Retrait', 'amount' => $wFees, 'transactions' => $wCount],
        //             ['title' => 'Transfert (Notre Opérateur)', 'amount' => $tInternalFees, 'transactions' => $tInternalCount],
        //             ['title' => 'Transfert (Autres Opérateurs)', 'amount' => $tExternalFees, 'transactions' => $tExternalCount],
        //             ['title' => 'Total', 'amount' => $totalFees, 'transactions' => $transactionCount],
        //         ],
        //     ];
        //     return view('operateur/stats', $data);
        // }

        public function stats() {
            $operationModel = new OperationModel();
            $viewType = $this->request->getGet('view_type') ?? 'week';
            $weekOffsetParam = $this->request->getGet('week_offset');
            $monthOffsetParam = $this->request->getGet('month_offset');
            $isGlobalMode = ($weekOffsetParam === null && $monthOffsetParam === null);
            $idType = $this->request->getGet('id_type');

            if (!$isGlobalMode) {
                $currentDate = new \DateTime();

                if ($viewType === 'month') {
                    $monthOffset = (int)($monthOffsetParam ?? 0);
                    if ($monthOffset !== 0) {
                        $currentDate->modify("$monthOffset months");
                    }
                    
                    $startDate = (clone $currentDate)->modify('first day of this month')->setTime(0,0,0)->format('Y-m-d');
                    $endDate = (clone $currentDate)->modify('last day of this month')->setTime(23,59,59)->format('Y-m-d');
                    $weekOffset = null;
                } else {
                    $weekOffset = (int)($weekOffsetParam ?? 0);
                    if ($weekOffset !== 0) {
                        $currentDate->modify("$weekOffset weeks");
                    }
                    $monday = clone $currentDate;
                    $monday->modify('monday this week')->setTime(0,0,0);
                    $sunday = clone $currentDate;
                    $sunday->modify('sunday this week')->setTime(23,59,59);

                    $startDate = $monday->format('Y-m-d');
                    $endDate = $sunday->format('Y-m-d');
                    $monthOffset = null;
                }
                
                $graphStartDate = $startDate;
                $graphEndDate   = $endDate;
            } else {
                $weekOffset = null;
                $monthOffset = null;
                $graphEndDate   = date('Y-m-d');
                $graphStartDate = date('Y-m-d', strtotime('-6 days'));
                
                $startDate = 'Origine';
                $endDate   = 'Aujourd\'hui';
            }

            $globalStats = $operationModel->getStat($startDate, $endDate, $isGlobalMode, $idType);
            
            $wFees = (float)($globalStats['withdrawalFees'] ?? 0);
            $wCount = (int)($globalStats['withdrawalCount'] ?? 0);
            
            $tInternalFees = (float)($globalStats['transferInternalFees'] ?? 0);
            $tInternalCount = (int)($globalStats['transferInternalCount'] ?? 0);
            
            $tExternalFees = (float)($globalStats['transferExternalFees'] ?? 0);
            $tExternalCount = (int)($globalStats['transferExternalCount'] ?? 0);

            $totalTransferFees = $tInternalFees + $tExternalFees;
            $totalTransferCount = $tInternalCount + $tExternalCount;
            
            $totalFees = $wFees + $totalTransferFees;
            $transactionCount = $wCount + $totalTransferCount;
            $averageFee = $transactionCount > 0 ? round($totalFees / $transactionCount) : 0;
            
            $graphRows = $operationModel->getGraphStat($graphStartDate, $graphEndDate, $idType);
            $indexedGraph = [];
            foreach ($graphRows as $row) {
                $indexedGraph[$row['date_jour']] = $row;
            }
            
            $dailyLabels = [];
            $dailyInternalValues = [];
            $dailyExternalValues = [];
            
            $graphPeriod = new \DatePeriod(
                new \DateTime($graphStartDate), 
                new \DateInterval('P1D'), 
                (new \DateTime($graphEndDate))->modify('+1 day')
            );
            
            foreach ($graphPeriod as $date) {
                $dayKey = $date->format('Y-m-d');
                $dailyLabels[] = $viewType === 'month' ? $date->format('d') : $date->format('d M');
                $dailyInternalValues[] = (float)($indexedGraph[$dayKey]['daily_internal'] ?? 0);
                $dailyExternalValues[] = (float)($indexedGraph[$dayKey]['daily_external'] ?? 0);
            }
            
            $data = [
                'op' => $idType,
                'activePage'          => 'stats',
                'isGlobalMode'        => $isGlobalMode,
                'viewType'            => $viewType,
                'startDate'           => $startDate,
                'endDate'             => $endDate,
                'weekOffset'          => $weekOffset,
                'monthOffset'         => $monthOffset,
                'summary'             => [
                    'withdrawalFees'   => $wFees,
                    'transferFees'     => $totalTransferFees,
                    'totalFees'        => $totalFees,
                    'averageFee'       => $averageFee,
                    'transactionCount' => $transactionCount,
                ],
                'breakdown'           => [
                    ['label' => 'Retrait', 'total' => $wFees, 'count' => $wCount, 'avg' => $wCount > 0 ? round($wFees / $wCount) : 0],
                    ['label' => 'Transfert Interne', 'total' => $tInternalFees, 'count' => $tInternalCount, 'avg' => $tInternalCount > 0 ? round($tInternalFees / $tInternalCount) : 0],
                    ['label' => 'Transfert Externe', 'total' => $tExternalFees, 'count' => $tExternalCount, 'avg' => $tExternalCount > 0 ? round($tExternalFees / $tExternalCount) : 0],
                    ['label' => 'Total', 'total' => $totalFees, 'count' => $transactionCount, 'avg' => $averageFee],
                ],
                'dailyLabels'         => $dailyLabels,
                'dailyInternalValues' => $dailyInternalValues,
                'dailyExternalValues' => $dailyExternalValues,
                'tableRows'           => [
                    ['title' => 'Retrait', 'amount' => $wFees, 'transactions' => $wCount],
                    ['title' => 'Transfert (Notre Opérateur)', 'amount' => $tInternalFees, 'transactions' => $tInternalCount],
                    ['title' => 'Transfert (Autres Opérateurs)', 'amount' => $tExternalFees, 'transactions' => $tExternalCount],
                    ['title' => 'Total', 'amount' => $totalFees, 'transactions' => $transactionCount],
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