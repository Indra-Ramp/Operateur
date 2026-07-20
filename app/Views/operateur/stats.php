<?= $this->extend('operateur/modal') ?>

<?= $this->section('custom_style') ?>
<style>
  .chart-bar {
    position: relative;
    width: 100%;
    background: linear-gradient(180deg, rgba(79, 70, 229, 0.12), transparent 70%);
    border-radius: 999px;
    overflow: hidden;
  }

  .chart-bar span {
    display: block;
    height: 100%;
    border-radius: 999px;
    background: linear-gradient(90deg, #2563eb, #38bdf8);
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<main class="lg:ml-[280px] min-h-screen p-container-padding bg-background pt-20 pb-12">
  <div class="max-w-7xl mx-auto space-y-lg">
    <header class="rounded-3xl bg-surface-container-lowest border border-outline-variant p-lg shadow-sm">
      <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-md">
        <div>
          <p class="text-sm font-medium uppercase tracking-[0.25em] text-on-surface-variant">Statistiques opérateur</p>
          <h1 class="font-display text-display text-on-surface mt-2">Situation des gains via les frais</h1>
          <p class="mt-3 max-w-2xl text-body-md text-on-surface-variant">Analyse des revenus générés par les frais de retrait et de transfert, avec des filtres par période.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-sm w-full max-w-xl">
          <form class="grid grid-cols-1 sm:grid-cols-3 gap-sm w-full" action="<?= site_url('operateur/stats') ?>" method="get">
            <label class="flex flex-col gap-2 text-sm text-on-surface-variant">
              Date de début
              <input name="start_date" type="date" value="<?= esc($startDate ?? '') ?>" class="rounded-lg border border-outline-variant bg-surface-container-low px-sm py-xs text-body-md outline-none focus:ring-1 focus:ring-primary">
            </label>
            <label class="flex flex-col gap-2 text-sm text-on-surface-variant">
              Date de fin
              <input name="end_date" type="date" value="<?= esc($endDate ?? '') ?>" class="rounded-lg border border-outline-variant bg-surface-container-low px-sm py-xs text-body-md outline-none focus:ring-1 focus:ring-primary">
            </label>
            <button type="submit" class="h-fit mt-2 rounded-lg bg-primary px-lg py-sm text-on-primary font-bold hover:bg-primary/90 transition-all">Appliquer</button>
          </form>
        </div>
      </div>
    </header>

    <section class="grid grid-cols-1 xl:grid-cols-4 gap-lg">
      <article class="rounded-3xl bg-surface-container-lowest border border-outline-variant p-lg shadow-sm">
        <p class="text-sm uppercase tracking-[0.25em] text-on-surface-variant">Gains retrait</p>
        <p class="mt-4 text-headline-lg font-bold text-on-surface"><?= number_format($summary['withdrawalFees'] ?? 0, 0, ',', ' ') ?> FCFA</p>
        <p class="mt-2 text-sm text-on-surface-variant">Basé sur les retraits enregistrés</p>
      </article>
      <article class="rounded-3xl bg-surface-container-lowest border border-outline-variant p-lg shadow-sm">
        <p class="text-sm uppercase tracking-[0.25em] text-on-surface-variant">Gains transfert</p>
        <p class="mt-4 text-headline-lg font-bold text-on-surface"><?= number_format($summary['transferFees'] ?? 0, 0, ',', ' ') ?> FCFA</p>
        <p class="mt-2 text-sm text-on-surface-variant">Basé sur les transferts enregistrés</p>
      </article>
      <article class="rounded-3xl bg-surface-container-lowest border border-outline-variant p-lg shadow-sm">
        <p class="text-sm uppercase tracking-[0.25em] text-on-surface-variant">Total des gains</p>
        <p class="mt-4 text-headline-lg font-bold text-on-surface"><?= number_format($summary['totalFees'] ?? 0, 0, ',', ' ') ?> FCFA</p>
        <p class="mt-2 text-sm text-on-surface-variant">Sur la période sélectionnée</p>
      </article>
      <article class="rounded-3xl bg-surface-container-lowest border border-outline-variant p-lg shadow-sm">
        <p class="text-sm uppercase tracking-[0.25em] text-on-surface-variant">Transaction moyenne</p>
        <p class="mt-4 text-headline-lg font-bold text-on-surface"><?= number_format($summary['averageFee'] ?? 0, 0, ',', ' ') ?> FCFA</p>
        <p class="mt-2 text-sm text-on-surface-variant">Moyenne par transaction</p>
      </article>
    </section>

    <section class="grid grid-cols-1 xl:grid-cols-3 gap-lg">
      <article class="xl:col-span-2 rounded-3xl bg-surface-container-lowest border border-outline-variant p-lg shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-md mb-lg">
          <div>
            <p class="text-sm uppercase tracking-[0.25em] text-on-surface-variant">Volume des gains</p>
            <h2 class="mt-3 font-headline-md text-headline-md text-on-surface">Retrait vs Transfert</h2>
          </div>
          <div class="flex gap-sm">
            <span class="rounded-full bg-primary-container px-sm py-1 text-xs font-semibold text-on-primary-container">Retrait</span>
            <span class="rounded-full bg-secondary-container px-sm py-1 text-xs font-semibold text-on-secondary-container">Transfert</span>
          </div>
        </div>

        <div class="space-y-lg">
          <div>
            <div class="flex items-center justify-between text-sm text-on-surface-variant mb-3">
              <span>Derniers 7 jours</span>
              <span>Valeur en FCFA</span>
            </div>
            <div class="flex items-center justify-between mb-4">
    <div class="flex gap-2">
        <!-- Bouton Retour au Bilan Global -->
        <a href="<?= base_url('operateur/stats') ?>" 
           class="px-4 py-2 <?= $isGlobalMode ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?> rounded text-sm font-medium">
            Vue Globale
        </a>

        <!-- Bouton Semaine Précédente (Bascule sur la semaine en cours si on était en global) -->
        <a href="<?= base_url('operateur/stats?week_offset=' . ($isGlobalMode ? 0 : $weekOffset - 1)) ?>" 
           class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-sm font-medium">
            ← Semaine précédente
        </a>
    </div>

    <!-- Affichage dynamique de la période -->
    <span class="text-lg font-semibold text-gray-700">
        <?php if ($isGlobalMode): ?>
            Bilan Historique Global (Graphique : 7 derniers jours)
        <?php else: ?>
            Période du : <?= date('d/m/Y', strtotime($startDate)) ?> au <?= date('d/m/Y', strtotime($endDate)) ?>
        <?php endif; ?>
    </span>

    <!-- Bouton Semaine Suivante -->
    <?php if (!$isGlobalMode && $weekOffset < 0): ?>
        <a href="<?= base_url('operateur/stats?week_offset=' . ($weekOffset + 1)) ?>" 
           class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-sm font-medium">
            Semaine suivante →
        </a>
    <?php else: ?>
        <span class="px-4 py-2 bg-gray-100 text-gray-400 rounded text-sm cursor-not-allowed">
            Semaine actuelle
        </span>
    <?php endif; ?>
</div>
            <div class="relative h-[250px] w-full">
              <canvas id="revenueChart"></canvas>
            </div>
            
            <div class="mt-4 grid grid-cols-2 gap-sm text-sm text-on-surface-variant">
              <div class="rounded-3xl bg-surface-container-highest p-sm">
                <p class="font-medium text-on-surface">Retrait</p>
                <p class="mt-1 text-headline-sm font-bold text-on-surface"><?= number_format($summary['withdrawalFees'] ?? 0, 0, ',', ' ') ?></p>
              </div>
              <div class="rounded-3xl bg-surface-container-highest p-sm">
                <p class="font-medium text-on-surface">Transfert</p>
                <p class="mt-1 text-headline-sm font-bold text-on-surface"><?= number_format($summary['transferFees'] ?? 0, 0, ',', ' ') ?></p>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-sm">
            <div>
              <p class="text-sm uppercase tracking-[0.25em] text-on-surface-variant mb-3">Répartition</p>
              <div class="space-y-sm">
                <div>
                  <div class="flex items-center justify-between text-sm text-on-surface-variant mb-2">
                    <span>Retrait</span>
                    <strong class="text-on-surface"><?= $summary['totalFees'] > 0 ? round(($summary['withdrawalFees'] / $summary['totalFees']) * 100) : 0 ?> %</strong>
                  </div>
                  <div class="chart-bar h-3"><span style="width:<?= $summary['totalFees'] > 0 ? round(($summary['withdrawalFees'] / $summary['totalFees']) * 100) : 0 ?>%"></span></div>
                </div>
                <div>
                  <div class="flex items-center justify-between text-sm text-on-surface-variant mb-2">
                    <span>Transfert</span>
                    <strong class="text-on-surface"><?= $summary['totalFees'] > 0 ? round(($summary['transferFees'] / $summary['totalFees']) * 100) : 0 ?> %</strong>
                  </div>
                  <div class="chart-bar h-3"><span style="width:<?= $summary['totalFees'] > 0 ? round(($summary['transferFees'] / $summary['totalFees']) * 100) : 0 ?>%"></span></div>
                </div>
              </div>
            </div>
            <div class="rounded-3xl bg-surface-container-highest p-lg">
              <p class="text-sm uppercase tracking-[0.25em] text-on-surface-variant">Croissance</p>
              <p class="mt-4 text-headline-lg font-bold text-primary">+11%</p>
              <p class="mt-2 text-sm text-on-surface-variant">Comparée au mois précédent</p>
            </div>
          </div>
        </div>
      </article>

      <aside class="rounded-3xl bg-surface-container-lowest border border-outline-variant p-lg shadow-sm">
        <h2 class="font-headline-sm text-headline-sm text-on-surface">Filtre rapide</h2>
        <div class="mt-lg space-y-lg">
          <div class="rounded-3xl bg-surface-container-highest p-lg">
            <p class="text-sm uppercase tracking-[0.25em] text-on-surface-variant">Type de frais</p>
            <p class="mt-3 text-body-md text-on-surface">Retrait</p>
            <p class="mt-1 text-headline-md font-bold text-on-surface"><?= number_format($summary['withdrawalFees'] ?? 0, 0, ',', ' ') ?> FCFA</p>
          </div>
          <div class="rounded-3xl bg-surface-container-highest p-lg">
            <p class="text-sm uppercase tracking-[0.25em] text-on-surface-variant">Type de frais</p>
            <p class="mt-3 text-body-md text-on-surface">Transfert</p>
            <p class="mt-1 text-headline-md font-bold text-on-surface"><?= number_format($summary['transferFees'] ?? 0, 0, ',', ' ') ?> FCFA</p>
          </div>
          <button class="w-full rounded-3xl bg-primary px-lg py-sm text-on-primary font-bold hover:bg-primary/90 transition-all">Télécharger le rapport</button>
        </div>
      </aside>
    </section>

    <section class="rounded-3xl bg-surface-container-lowest border border-outline-variant p-lg shadow-sm">
      <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-md mb-lg">
        <div>
          <p class="text-sm uppercase tracking-[0.25em] text-on-surface-variant">Détail des frais</p>
          <h2 class="font-headline-md text-headline-md text-on-surface mt-2">Vue par canal</h2>
        </div>
        <button class="rounded-lg bg-secondary-container px-lg py-sm text-on-secondary-container font-semibold hover:bg-secondary-container/90 transition-all">Voir tout</button>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead class="bg-surface-container-high/50 border-b border-outline-variant">
            <tr>
              <th class="px-lg py-md text-sm uppercase tracking-[0.25em] text-on-surface-variant">Frais</th>
              <th class="px-lg py-md text-sm uppercase tracking-[0.25em] text-on-surface-variant">Montant total</th>
              <th class="px-lg py-md text-sm uppercase tracking-[0.25em] text-on-surface-variant">Transactions</th>
              <th class="px-lg py-md text-sm uppercase tracking-[0.25em] text-on-surface-variant">Marge moyenne</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-outline-variant">
            <?php foreach ($tableRows as $row): ?>
            <tr class="hover:bg-surface-container-highest transition-colors">
              <td class="px-lg py-md"><?= esc($row['title']) ?></td>
              <td class="px-lg py-md font-semibold text-on-surface"><?= number_format($row['amount'], 0, ',', ' ') ?> FCFA</td>
              <td class="px-lg py-md text-on-surface-variant"><?= number_format($row['transactions'], 0, ',', ' ') ?></td>
              <td class="px-lg py-md text-on-surface-variant"><?= esc($row['margin']) ?></td>
            </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </section>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = <?= json_encode(array_values($dailyValues ?? [0,0,0,0,0,0,0])) ?>;
    const chartLabels = ['J-6', 'J-5', 'J-4', 'J-3', 'J-2', 'Hier', 'Aujourd\'hui'];

    const ctx = document.getElementById('revenueChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Volume (FCFA)',
                data: chartData,
                backgroundColor: '#2563eb',
                hoverBackgroundColor: '#38bdf8',
                borderRadius: 8,
                borderSkipped: false,
                barThickness: 24
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 13 },
                    bodyFont: { size: 14, weight: 'bold' },
                    callbacks: {
                        label: function(context) {
                            let value = context.parsed.y;
                            return value.toLocaleString('fr-FR') + ' FCFA';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9',
                        drawBorder: false,
                    },
                    border: { display: false },
                    ticks: {
                        color: '#64748b',
                        font: { size: 11 },
                        callback: function(value) {
                            return value >= 1000 ? (value/1000) + 'k' : value;
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false,
                    },
                    border: { display: false },
                    ticks: {
                        color: '#64748b',
                        font: { size: 12 }
                    }
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>