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

  .sparkline {
    display: grid;
    grid-template-columns: repeat(7, minmax(0, 1fr));
    gap: 0.65rem;
    align-items: end;
    min-height: 120px;
  }

  .sparkline div {
    border-radius: 999px;
    background: #2563eb;
    transition: transform 0.2s ease;
  }

  .sparkline div:hover {
    transform: scaleY(1.1);
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
            <?php $maxDailyValue = ! empty($dailyValues) ? max($dailyValues) : 1; ?>
            <div class="sparkline">
              <?php foreach ($dailyValues as $value): ?>
                <?php $height = min(100, 10 + ($value / max(1, $maxDailyValue) * 90)); ?>
                <div style="height:<?= esc($height) ?>%"></div>
              <?php endforeach ?>
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
<?= $this->endSection() ?>