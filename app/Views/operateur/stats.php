<?= $this->extend('operateur/modal') ?>

<?= $this->section('custom_style'); ?>    
    <style>
        body {
            background-color: #F9FAFB;
            color: #1F2937;
            font-family: 'Inter', sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-card {
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
    <main class="flex-grow md:ml-[280px] p-6 transition-all duration-300 mb-16 md:mb-0">
        
        <!-- Navigation & Header Période -->
        <header class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 gap-4">
            <div class="space-y-1">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Tableau de Bord Analytique</h2>
                <p class="text-sm text-gray-500">Suivi détaillé des commissions collectées par type de flux réseau.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="inline-flex rounded-md shadow-sm bg-white p-1 border border-gray-200">
                    <a href="<?= base_url('operateur/stats') ?>" 
                       class="px-4 py-1.5 text-xs font-medium rounded-md transition-colors <?= $isGlobalMode ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-100' ?>">
                        Bilan Global
                    </a>
                </div>
            </div>
        </header>

        <!-- Navigation Temporelle Contextuelle -->
        <!-- Navigation Temporelle Contextuelle (Toujours active pour le changement de semaine) -->
        <!-- Sélecteur de Type de Vue -->
<div class="flex justify-end gap-2 mb-4">
    <a href="<?= base_url('operateur/stats?view_type=week&week_offset=0') ?>" 
       class="px-3 py-1.5 text-xs font-semibold rounded-lg border <?= $viewType === 'week' ? 'bg-gray-950 text-white border-gray-950' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' ?>">
        Vue Hebdomadaire
    </a>
    <a href="<?= base_url('operateur/stats?view_type=month&month_offset=0') ?>" 
       class="px-3 py-1.5 text-xs font-semibold rounded-lg border <?= $viewType === 'month' ? 'bg-gray-950 text-white border-gray-950' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' ?>">
        Vue Mensuelle
    </a>
</div>

<!-- Navigation Temporelle Dynamique -->
<div class="flex items-center justify-between bg-white border border-gray-200 rounded-xl p-4 mb-6 shadow-sm">
    <?php 
        // Génération dynamique des liens selon le mode choisi
        if ($viewType === 'month') {
            $prevUrl = base_url('operateur/stats?view_type=month&month_offset=' . ((int)($monthOffset ?? 0) - 1));
            $nextUrl = base_url('operateur/stats?view_type=month&month_offset=' . ((int)($monthOffset ?? 0) + 1));
            $periodLabel = $isGlobalMode ? "Mois en cours (Vue Globale)" : date('F Y', strtotime($startDate));
        } else {
            $prevUrl = base_url('operateur/stats?view_type=week&week_offset=' . ((int)($weekOffset ?? 0) - 1));
            $nextUrl = base_url('operateur/stats?view_type=week&week_offset=' . ((int)($weekOffset ?? 0) + 1));
            $periodLabel = $isGlobalMode ? "7 derniers jours (Vue Globale)" : date('d M Y', strtotime($startDate)) . ' — ' . date('d M Y', strtotime($endDate));
        }
    ?>
    <a href="<?= $prevUrl ?>" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-50 border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span> <?= $viewType === 'month' ? 'Mois précédent' : 'Semaine précédente' ?>
    </a>
    <div class="text-center">
        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">Période d'analyse</span>
        <span class="text-sm font-bold text-gray-800"><?= $periodLabel ?></span>
    </div>
    <a href="<?= $nextUrl ?>" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-50 border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
        <?= $viewType === 'month' ? 'Mois suivant' : 'Semaine suivante' ?> <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
    </a>
</div>

        <!-- Graphique Évolutif Multi-Passerelles -->
        <div class="glass-card rounded-xl p-6 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider">Comparatif des gains de commissions</h3>
                <!-- Légende customisée HTML -->
                <div class="flex items-center gap-4 text-xs font-medium">
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded bg-gray-900 inline-block"></span>
                        <span class="text-gray-600">Frais Internes (Retraits & Notre réseau)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded bg-emerald-500 inline-block"></span>
                        <span class="text-gray-600">Frais Externes (Autres Opérateurs)</span>
                    </div>
                </div>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="feesChart"></canvas>
            </div>
        </div>

        <!-- 5. Tableau Récapitulatif Structurel -->
        <div class="glass-card rounded-xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider">Répartition analytique par segment</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-xs font-semibold text-gray-500 uppercase tracking-wider bg-white">
                            <th class="px-6 py-3.5">Segment de Flux</th>
                            <th class="px-6 py-3.5 text-right">Volume Transactions</th>
                            <th class="px-6 py-3.5 text-right">Total Frais Générés</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        <?php foreach ($tableRows as $row): 
                            $isRowTotal = ($row['title'] === 'Total');
                        ?>
                            <tr class="<?= $isRowTotal ? 'bg-gray-50 font-semibold text-gray-900' : 'text-gray-700 hover:bg-gray-50/50' ?> transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm"><?= $row['title'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right"><?= number_format($row['transactions'], 0, ',', ' ') ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium <?= !$isRowTotal && strpos($row['title'], 'Retrait') === false ? 'text-gray-900' : '' ?> <?= $isRowTotal ? '' : 'text-emerald-600' ?>">
                                    <?= number_format($row['amount'], 0, ',', ' ') ?> Ar
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Inclusion de Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('feesChart').getContext('2d');
            
            const labels = <?= json_encode($dailyLabels) ?>;
            const internalData = <?= json_encode($dailyInternalValues) ?>;
            const externalData = <?= json_encode($dailyExternalValues) ?>;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Gains Internes (Ar)',
                            data: internalData,
                            backgroundColor: '#111827', // Noir/Gris Foncé
                            borderRadius: 4,
                            barPercentage: 1.0,
                            categoryPercentage: 0.7
                        },
                        {
                            label: 'Gains Externes (Ar)',
                            data: externalData,
                            backgroundColor: '#10B981', // Émeraude
                            borderRadius: 4,
                            barPercentage: 1.0,
                            categoryPercentage: 0.7
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }, // Géré via la légende HTML personnalisée au-dessus
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            padding: 12,
                            backgroundColor: '#1F2937',
                            titleFont: { size: 13, weight: 'bold' },
                            bodyFont: { size: 12 },
                            callbacks: {
                                label: function(context) {
                                    let value = context.raw.toLocaleString('fr-FR');
                                    return ` ${context.dataset.label.split(' (')[0]} : ${value} Ar`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: { 
                            grid: { display: false },
                            stacked: false // Colonnes côte à côte pour mieux comparer
                        },
                        y: {
                            beginAtZero: true,
                            stacked: false,
                            grid: { color: '#F3F4F6', drawBorder: false },
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('fr-FR') + ' Ar';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
<?= $this->endSection() ?>