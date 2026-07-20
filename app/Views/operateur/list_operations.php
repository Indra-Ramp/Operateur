<?= $this->extend("operateur/modal") ?>
<?= $this->section('custom_style') ?>
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(229, 231, 235, 0.6);
    }
    /* Correction du layout Bento avec CSS Grid propre */
    .bento-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }
    @media (min-width: 640px) {
        .bento-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (min-width: 1280px) {
        .bento-grid {
            grid-template-columns: repeat(3, 1fr);
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
                        <a class="hover:text-primary transition-colors" href="#">Opérateurs</a>
                        <span class="material-symbols-outlined text-xs">chevron_right</span>
                        <span class="text-on-surface font-medium">Gestion des frais</span>
                    </nav>
                    <h2 class="font-display text-display text-on-surface tracking-tight">Configuration des frais</h2>
                    <p class="text-on-surface-variant mt-sm max-w-2xl font-body-lg text-body-lg">
                        Sélectionnez le type d'opération pour définir les frais de transaction par niveau, les structures de commission et les marges des opérateurs.
                    </p>
                </div>
            </div>
        </header>

        <!-- Grid of Operation Types -->
        <section class="bento-grid">
            <?php 
            foreach($operations as $op):
                $id = $op['id'];
                $label = esc($op['label']);
                
                // Configuration dynamique des visuels selon l'opération
                $icon = 'atm';
                $bg_icon = 'bg-primary-container text-on-primary-container';
                $desc = $op['description'];
                $badge = "Général";

                
            ?>
                <div class="glass-card rounded-2xl p-lg flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300 shadow-[0_4px_6px_-1px_rgba(0,0,0,0.02)] hover:shadow-[0_20px_25px_-5px_rgba(0,0,0,0.05)] border border-gray-100">
                    <div class="mb-lg">
                        <!-- Icon & Badge Container -->
                        <div class="flex items-center justify-between mb-md">
                            <div class="w-12 h-12 <?= $bg_icon ?> rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <span class="material-symbols-outlined text-2xl"><?= $icon ?></span>
                            </div>
                            <span class="bg-gray-100 text-gray-600 text-[10px] uppercase font-bold tracking-wider px-2.5 py-1 rounded-full">
                                <?= $badge ?>
                            </span>
                        </div>
                        
                        <!-- Content -->
                        <h3 class="font-headline-md text-xl font-bold text-on-surface mb-sm group-hover:text-primary transition-colors">
                            <?= strtoupper($label) ?>
                        </h3>
                        <p class="text-on-surface-variant text-sm leading-relaxed text-gray-500 line-clamp-3">
                            <?= $desc ?>
                        </p>
                    </div>

                    <!-- Action Button -->
                    <a href="<?= base_url("/operateur/list-fees/$id") ?>"
                        class="w-full bg-primary text-on-primary py-3 rounded-xl font-semibold text-center text-sm hover:bg-opacity-95 active:scale-[0.98] transition-all flex items-center justify-center gap-xs group/btn">
                        <span>Configurer les frais</span>
                        <span class="material-symbols-outlined text-sm group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            <?php endforeach; ?>
        </section>

        <!-- Bottom Stats / Recent Adjustments -->
    </div>
</main>

<div class="fixed inset-0 pointer-events-none z-[-1] opacity-20">
    <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-primary blur-[120px]"></div>
    <div class="absolute bottom-[-5%] left-[10%] w-[30%] h-[30%] rounded-full bg-secondary blur-[100px]"></div>
</div>

<script>
    // Optimisation des interactions en JS natif (évite les conflits CSS/JS pour le hover)
    document.querySelectorAll('.glass-card').forEach(card => {
        card.addEventListener('mousedown', () => {
            const btn = card.querySelector('a');
            if(btn) btn.classList.add('scale-[0.98]');
        });
        card.addEventListener('mouseup', () => {
            const btn = card.querySelector('a');
            if(btn) btn.classList.remove('scale-[0.98]');
        });
    });
</script>
<?= $this->endSection() ?>