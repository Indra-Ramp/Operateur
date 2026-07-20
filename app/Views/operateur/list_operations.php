<?= $this->extend("operateur/modal") ?>
<?= $this->section('custom_style') ?>
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(8px);
        border: 1px solid #E5E7EB;
    }
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
    }
    @media (min-width: 1024px) {
        .bento-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (min-width: 1280px) {
        .bento-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('main') ?>
<main class="lg:ml-[280px] min-h-screen pt-20 lg:pt-0 p-container-padding bg-background">
        <div class="max-w-7xl mx-auto py-lg">
            <!-- Header Section -->
            <header class="mb-xl">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-md">
                    <div>
                        <nav class="flex items-center gap-xs text-on-surface-variant mb-xs">
                            <a class="hover:text-primary transition-colors" href="#">Operators</a>
                            <span class="material-symbols-outlined text-xs">chevron_right</span>
                            <span class="text-on-surface font-medium">Fee Management</span>
                        </nav>
                        <h2 class="font-display text-display text-on-surface tracking-tight">Configuration des Frais
                        </h2>
                        <p class="text-on-surface-variant mt-sm max-w-2xl font-body-lg text-body-lg">
                            Select the operation type to define tiered transaction fees, commission structures, and
                            operator margins.
                        </p>
                    </div>
                    <div class="flex gap-sm">
                        <button
                            class="bg-surface-container-low border border-outline text-on-surface px-md py-sm rounded-lg font-medium flex items-center gap-xs hover:bg-surface-container-high transition-colors">
                            <span class="material-symbols-outlined text-md">history</span>
                            Audit Log
                        </button>
                    </div>
                </div>
            </header>
            <!-- Grid of Operation Types -->
            <section class="bento-grid">
                <!-- Transfer Card -->
                <div
                    class="glass-card rounded-xl p-lg flex flex-col justify-between group hover:-translate-y-1 transition-all shadow-[0_4px_6px_-1px_rgba(6,78,59,0.05)] hover:shadow-[0_10px_15px_-3px_rgba(6,78,59,0.1)]">
                    <div>
                        <div
                            class="w-14 h-14 bg-secondary-container rounded-lg flex items-center justify-center mb-md group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-on-secondary-container text-3xl">send</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-xs">Transfer</h3>
                        <p class="text-on-surface-variant text-body-md mb-md leading-relaxed">
                            P2P money transfers between wallets. Configure domestic and international corridor pricing.
                        </p>
                        <div class="flex flex-wrap gap-xs mb-lg">
                            <span
                                class="bg-surface-container text-on-surface-variant text-[10px] uppercase font-bold px-sm py-1 rounded">Wallet-to-Wallet</span>
                            <span
                                class="bg-surface-container text-on-surface-variant text-[10px] uppercase font-bold px-sm py-1 rounded">Cross-Border</span>
                        </div>
                    </div>
                    <button
                        class="w-full bg-primary text-on-primary py-sm rounded-lg font-bold hover:bg-opacity-90 active:scale-95 transition-all">
                        Configure Fees
                    </button>
                </div>
                <!-- Withdrawal Card -->
                <div
                    class="glass-card rounded-xl p-lg flex flex-col justify-between group hover:-translate-y-1 transition-all shadow-[0_4px_6px_-1px_rgba(6,78,59,0.05)] hover:shadow-[0_10px_15px_-3px_rgba(6,78,59,0.1)]">
                    <div>
                        <div
                            class="w-14 h-14 bg-primary-container rounded-lg flex items-center justify-center mb-md group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-on-primary-container text-3xl">payments</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-xs">Withdrawal</h3>
                        <p class="text-on-surface-variant text-body-md mb-md leading-relaxed">
                            Cash-out operations via agents or ATMs. Set percentage-based or flat rate cash-out fees.
                        </p>
                        <div class="flex flex-wrap gap-xs mb-lg">
                            <span
                                class="bg-surface-container text-on-surface-variant text-[10px] uppercase font-bold px-sm py-1 rounded">Agent
                                Cash-Out</span>
                            <span
                                class="bg-surface-container text-on-surface-variant text-[10px] uppercase font-bold px-sm py-1 rounded">ATM
                                Exit</span>
                        </div>
                    </div>
                    <button
                        class="w-full bg-primary text-on-primary py-sm rounded-lg font-bold hover:bg-opacity-90 active:scale-95 transition-all">
                        Configure Fees
                    </button>
                </div>
                <!-- Deposit Card -->
                <div
                    class="glass-card rounded-xl p-lg flex flex-col justify-between group hover:-translate-y-1 transition-all shadow-[0_4px_6px_-1px_rgba(6,78,59,0.05)] hover:shadow-[0_10px_15px_-3px_rgba(6,78,59,0.1)]">
                    <div>
                        <div
                            class="w-14 h-14 bg-secondary-container rounded-lg flex items-center justify-center mb-md group-hover:scale-110 transition-transform">
                            <span
                                class="material-symbols-outlined text-on-secondary-container text-3xl">account_balance</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-xs">Deposit</h3>
                        <p class="text-on-surface-variant text-body-md mb-md leading-relaxed">
                            Cash-in transactions. Manage operator commissions and limits for incoming liquidity.
                        </p>
                        <div class="flex flex-wrap gap-xs mb-lg">
                            <span
                                class="bg-surface-container text-on-surface-variant text-[10px] uppercase font-bold px-sm py-1 rounded">Agent
                                Cash-In</span>
                            <span
                                class="bg-surface-container text-on-surface-variant text-[10px] uppercase font-bold px-sm py-1 rounded">Card
                                Top-up</span>
                        </div>
                    </div>
                    <button
                        class="w-full bg-primary text-on-primary py-sm rounded-lg font-bold hover:bg-opacity-90 active:scale-95 transition-all">
                        Configure Fees
                    </button>
                </div>
                <!-- Bill Pay Card -->
                <div
                    class="glass-card rounded-xl p-lg flex flex-col justify-between group hover:-translate-y-1 transition-all shadow-[0_4px_6px_-1px_rgba(6,78,59,0.05)] hover:shadow-[0_10px_15px_-3px_rgba(6,78,59,0.1)]">
                    <div>
                        <div
                            class="w-14 h-14 bg-tertiary-container rounded-lg flex items-center justify-center mb-md group-hover:scale-110 transition-transform">
                            <span
                                class="material-symbols-outlined text-on-tertiary-container text-3xl">receipt_long</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-xs">Bill Pay</h3>
                        <p class="text-on-surface-variant text-body-md mb-md leading-relaxed">
                            Utility payments, airtime, and merchant settlements. Define service provider surcharges.
                        </p>
                        <div class="flex flex-wrap gap-xs mb-lg">
                            <span
                                class="bg-surface-container text-on-surface-variant text-[10px] uppercase font-bold px-sm py-1 rounded">Utility
                                Bills</span>
                            <span
                                class="bg-surface-container text-on-surface-variant text-[10px] uppercase font-bold px-sm py-1 rounded">Airtime</span>
                        </div>
                    </div>
                    <button
                        class="w-full bg-primary text-on-primary py-sm rounded-lg font-bold hover:bg-opacity-90 active:scale-95 transition-all">
                        Configure Fees
                    </button>
                </div>
            </section>
            <!-- Bottom Stats / Recent Adjustments -->
            <section class="mt-xl grid grid-cols-1 md:grid-cols-3 gap-lg">
                <div class="glass-card rounded-xl p-md border-l-4 border-primary">
                    <p class="text-xs font-bold uppercase text-on-surface-variant tracking-wider">Active Fee Profiles
                    </p>
                    <div class="flex items-center justify-between mt-sm">
                        <span class="text-headline-lg font-bold text-on-surface">12</span>
                        <span class="text-primary bg-primary-container/20 text-xs px-2 py-1 rounded-full">+2 this
                            month</span>
                    </div>
                </div>
                <div class="glass-card rounded-xl p-md border-l-4 border-secondary">
                    <p class="text-xs font-bold uppercase text-on-surface-variant tracking-wider">Avg. Commission</p>
                    <div class="flex items-center justify-between mt-sm">
                        <span class="text-headline-lg font-bold text-on-surface">2.4%</span>
                        <span class="text-on-surface-variant text-xs italic">Standard tier</span>
                    </div>
                </div>
                <div class="glass-card rounded-xl p-md border-l-4 border-tertiary">
                    <p class="text-xs font-bold uppercase text-on-surface-variant tracking-wider">Last Sync</p>
                    <div class="flex items-center justify-between mt-sm">
                        <span class="text-headline-lg font-bold text-on-surface">14m ago</span>
                        <span class="material-symbols-outlined text-tertiary">sync</span>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <!-- Subtle atmospheric background effect -->
    <div class="fixed inset-0 pointer-events-none z-[-1] opacity-20">
        <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-primary blur-[120px]"></div>
        <div class="absolute bottom-[-5%] left-[10%] w-[30%] h-[30%] rounded-full bg-secondary blur-[100px]"></div>
    </div>
    <script>
        // Micro-interactions for buttons
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('mousedown', () => {
                button.classList.add('scale-95');
            });
            button.addEventListener('mouseup', () => {
                button.classList.remove('scale-95');
            });
            button.addEventListener('mouseleave', () => {
                button.classList.remove('scale-95');
            });
        });

        // Hover lift effect logic via Tailwind transitions
        const cards = document.querySelectorAll('.glass-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-4px)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });
    </script>
<?= $this->endSection() ?>