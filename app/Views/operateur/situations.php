<?= $this->extend("operateur/modal") ?>
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
                    <div class="transaction-row grid grid-cols-12 gap-gutter px-lg py-md items-center">
                        <div class="col-span-5">
                            <p class="font-medium text-on-surface">Transfert d'argent de 0323203232 vers 0383803838</p>
                            <p class="text-xs text-on-surface-variant font-label-md">ID: TRX-98234-MAD • 14 Oct 2023,
                                09:41</p>
                        </div>
                        <div class="col-span-2 text-right font-label-md text-on-surface">500 000 Ar</div>
                        <div class="col-span-2 text-right font-label-md text-primary">5 000 Ar</div>
                        <div class="col-span-3 text-right font-label-md font-bold text-on-tertiary-container">505 000 Ar
                        </div>
                    </div>
                    <!-- Row 2 -->
                    <div class="transaction-row grid grid-cols-12 gap-gutter px-lg py-md items-center">
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
                    <!-- Row 3 -->
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
                    <!-- Row 4 -->
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
                    <!-- Row 5 -->
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
                    </div>
                </div>
                <!-- Pagination -->
                <div
                    class="px-lg py-md border-t border-outline-variant flex justify-between items-center bg-surface-container-lowest">
                    <p class="text-sm text-on-surface-variant">Affichage de 5 sur 124 transactions</p>
                    <div class="flex items-center gap-xs">
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg border border-outline-variant hover:bg-surface-container-high transition-colors">
                            <span class="material-symbols-outlined text-sm">chevron_left</span>
                        </button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-on-primary font-medium">1</button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-surface-container-high transition-colors">2</button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-surface-container-high transition-colors">3</button>
                        <span class="mx-xs text-on-surface-variant">...</span>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-surface-container-high transition-colors">25</button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-lg border border-outline-variant hover:bg-surface-container-high transition-colors">
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                        </button>
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
                    <p class="text-secondary-container opacity-90">Calculé sur la base des transactions filtrées du jour
                    </p>
                </div>
                <div class="text-right relative z-10">
                    <div class="font-label-md text-label-md text-secondary-container uppercase mb-xs">Montant total net
                    </div>
                    <div class="text-[32px] leading-tight font-display font-bold tracking-tight">2 964 250 Ar</div>
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