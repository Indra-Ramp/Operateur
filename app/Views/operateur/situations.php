<?= $this->extend("operateur/modal") ?>
<?= $this->section('custom_style') ?>
    <style>
        body {
            background-color: #f8f9fa;
            color: #191c1d;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 24px;
        }

        .transaction-row:hover {
            background-color: #f3f4f5;
            transform: translateX(4px);
            transition: all 0.2s ease;
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
    <!-- Main Content Canvas -->
    <main class="ml-[280px] p-xl min-h-screen flex flex-col">
        <!-- Header Section -->
        <header class="mb-xl">
            <div class="flex justify-between items-end">
                <div>
                    <h2 class="font-headline-lg text-headline-lg text-on-surface">Récapitulatif des Situations</h2>
                    <p class="text-on-surface-variant mt-xs">Suivi détaillé des transactions et règlements opérateurs
                    </p>
                </div>
                <div class="flex gap-md">
                    <button
                        class="bg-white border border-outline px-md py-sm rounded-lg text-primary flex items-center gap-sm hover:shadow-sm transition-all">
                        <span class="material-symbols-outlined">filter_list</span>
                        Filtrer
                    </button>
                    <button
                        class="bg-primary text-on-primary px-lg py-sm rounded-lg font-medium shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all">
                        Exporter CSV
                    </button>
                </div>
            </div>
        </header>
        <!-- Transaction List Section -->
        <section class="flex-1">
            <div
                class="bg-white rounded-xl border border-outline-variant shadow-[0_4px_6px_-1px_rgba(6,78,59,0.05)] overflow-hidden">
                <!-- Table Header -->
                <div
                    class="grid grid-cols-12 gap-gutter px-lg py-md border-b border-outline-variant bg-surface-container-low">
                    <div class="col-span-5 font-label-md text-label-md text-on-surface-variant uppercase">Détails de la
                        Transaction</div>
                    <div class="col-span-2 font-label-md text-label-md text-on-surface-variant uppercase text-right">
                        Montant</div>
                    <div class="col-span-2 font-label-md text-label-md text-on-surface-variant uppercase text-right">
                        Commission</div>
                    <div class="col-span-3 font-label-md text-label-md text-on-surface-variant uppercase text-right">
                        Total à l'opérateur</div>
                </div>
                <!-- List Items -->
                <div class="divide-y divide-outline-variant">
                    <!-- Row 1 -->
                    <?php foreach($operations as $op): ?>
                        <div class="transaction-row grid grid-cols-12 gap-gutter px-lg py-md items-center">
                            <div class="col-span-5">
                                <p class="font-medium text-on-surface">Transfert d'argent de <?= $op['tel1'] ?> vers <?= $op['tel2'] ?></p>
                                <p class="text-xs text-on-surface-variant font-label-md"><?= $op['date_track'] ?>,
                                    09:41</p>
                            </div>
                            <div class="col-span-2 text-right font-label-md text-on-surface"><?= $op['montant'] ?> Ar</div>
                            <div class="col-span-2 text-right font-label-md text-primary"><?= $op['commission'] ?> Ar</div>
                            <div class="col-span-3 text-right font-label-md font-bold text-on-tertiary-container"><?= $op['total_operateur'] ?> Ar
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <!-- Row 2 -->
                    <!-- <div class="transaction-row grid grid-cols-12 gap-gutter px-lg py-md items-center">
                        <div class="col-span-5">
                            <p class="font-medium text-on-surface">Transfert d'argent de 0383803838 vers 0323203232</p>
                            <p class="text-xs text-on-surface-variant font-label-md">ID: TRX-98235-MAD • 14 Oct 2023,
                                10:15</p>
                        </div>
                        <div class="col-span-2 text-right font-label-md text-on-surface">1 200 000 Ar</div>
                        <div class="col-span-2 text-right font-label-md text-primary">12 000 Ar</div>
                        <div class="col-span-3 text-right font-label-md font-bold text-on-tertiary-container">1 212 000
                            Ar</div>
                    </div>
                    <div class="transaction-row grid grid-cols-12 gap-gutter px-lg py-md items-center">
                        <div class="col-span-5">
                            <p class="font-medium text-on-surface">Transfert d'argent de 0323203232 vers 0341234567</p>
                            <p class="text-xs text-on-surface-variant font-label-md">ID: TRX-98236-MAD • 14 Oct 2023,
                                11:02</p>
                        </div>
                        <div class="col-span-2 text-right font-label-md text-on-surface">75 000 Ar</div>
                        <div class="col-span-2 text-right font-label-md text-primary">750 Ar</div>
                        <div class="col-span-3 text-right font-label-md font-bold text-on-tertiary-container">75 750 Ar
                        </div>
                    </div>
                    <div class="transaction-row grid grid-cols-12 gap-gutter px-lg py-md items-center">
                        <div class="col-span-5">
                            <p class="font-medium text-on-surface">Transfert d'argent de 0345678901 vers 0383803838</p>
                            <p class="text-xs text-on-surface-variant font-label-md">ID: TRX-98237-MAD • 14 Oct 2023,
                                13:45</p>
                        </div>
                        <div class="col-span-2 text-right font-label-md text-on-surface">250 000 Ar</div>
                        <div class="col-span-2 text-right font-label-md text-primary">2 500 Ar</div>
                        <div class="col-span-3 text-right font-label-md font-bold text-on-tertiary-container">252 500 Ar
                        </div>
                    </div>
                    <div class="transaction-row grid grid-cols-12 gap-gutter px-lg py-md items-center">
                        <div class="col-span-5">
                            <p class="font-medium text-on-surface">Transfert d'argent de 0323203232 vers 0329988776</p>
                            <p class="text-xs text-on-surface-variant font-label-md">ID: TRX-98238-MAD • 14 Oct 2023,
                                15:20</p>
                        </div>
                        <div class="col-span-2 text-right font-label-md text-on-surface">900 000 Ar</div>
                        <div class="col-span-2 text-right font-label-md text-primary">9 000 Ar</div>
                        <div class="col-span-3 text-right font-label-md font-bold text-on-tertiary-container">909 000 Ar
                        </div>
                    </div> -->
                </div>
                <!-- Pagination -->
                <div
                    class="px-lg py-md border-t border-outline-variant flex flex-col gap-sm md:flex-row md:justify-between md:items-center bg-surface-container-lowest">
                    <?php
                        $firstItem = $totalOperations === 0 ? 0 : ($currentPage - 1) * $perPage + 1;
                        $lastItem = $totalOperations === 0 ? 0 : min($totalOperations, $currentPage * $perPage);
                        $baseUrl = "/operateur/situation/{$idOperateur}";
                    ?>
                    <p class="text-sm text-on-surface-variant">Affichage de <?= $firstItem ?> à <?= $lastItem ?> sur <?= number_format($totalOperations, 0, ',', ' ') ?> transactions</p>
                    <div class="flex flex-wrap items-center gap-xs">
                        <?php if ($currentPage > 1): ?>
                            <a href="<?= $baseUrl ?>?page=<?= $currentPage - 1 ?>"
                                class="w-8 h-8 flex items-center justify-center rounded-lg border border-outline-variant hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-sm">chevron_left</span>
                            </a>
                        <?php else: ?>
                            <button disabled
                                class="w-8 h-8 flex items-center justify-center rounded-lg border border-outline-variant text-on-surface-variant bg-surface-container-low transition-colors">
                                <span class="material-symbols-outlined text-sm">chevron_left</span>
                            </button>
                        <?php endif; ?>

                        <?php
                            $pagesToShow = [];
                            for ($p = 1; $p <= $totalPages; $p++) {
                                if ($p === 1 || $p === $totalPages || abs($p - $currentPage) <= 1) {
                                    $pagesToShow[] = $p;
                                }
                            }
                            $previousPage = 0;
                        ?>

                        <?php foreach ($pagesToShow as $p): ?>
                            <?php if ($p - $previousPage > 1): ?>
                                <span class="mx-xs text-on-surface-variant">...</span>
                            <?php endif; ?>

                            <?php if ($p === $currentPage): ?>
                                <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-on-primary font-medium"><?= $p ?></span>
                            <?php else: ?>
                                <a href="<?= $baseUrl ?>?page=<?= $p ?>"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg border border-outline-variant hover:bg-surface-container-high transition-colors"><?= $p ?></a>
                            <?php endif; ?>

                            <?php $previousPage = $p; ?>
                        <?php endforeach; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <a href="<?= $baseUrl ?>?page=<?= $currentPage + 1 ?>"
                                class="w-8 h-8 flex items-center justify-center rounded-lg border border-outline-variant hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-sm">chevron_right</span>
                            </a>
                        <?php else: ?>
                            <button disabled
                                class="w-8 h-8 flex items-center justify-center rounded-lg border border-outline-variant text-on-surface-variant bg-surface-container-low transition-colors">
                                <span class="material-symbols-outlined text-sm">chevron_right</span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer Summary Section -->
        <footer class="mt-xl">
            <div
                class="bg-on-tertiary-container text-white p-lg rounded-xl flex justify-between items-center shadow-lg relative overflow-hidden">
                <!-- Abstract visual decoration -->
                <div class="absolute right-0 top-0 w-64 h-full bg-primary opacity-10 skew-x-12 translate-x-20"></div>
                <div class="absolute right-10 top-0 w-32 h-full bg-secondary opacity-5 skew-x-12 translate-x-10"></div>
                <div class="relative z-10">
                    <h3 class="font-headline-md text-headline-md font-bold">Total de toutes les situations</h3>
                </div>
                <div class="text-right relative z-10">
                    <div class="font-label-md text-label-md text-secondary-container uppercase mb-xs">Montant total net
                    </div>
                    <div class="text-[32px] leading-tight font-display font-bold tracking-tight"><?= $sum ?> Ar</div>
                </div>
            </div>
        </footer>
    </main>
    <!-- Micro-interactions Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Simple hover effect for rows via JS for extra polish
            const rows = document.querySelectorAll('.transaction-row');
            rows.forEach(row => {
                row.addEventListener('mouseenter', () => {
                    row.style.boxShadow = '0 10px 15px -3px rgba(6, 78, 59, 0.05)';
                });
                row.addEventListener('mouseleave', () => {
                    row.style.boxShadow = 'none';
                });
            });
        });
    </script>
<?= $this->endSection() ?>