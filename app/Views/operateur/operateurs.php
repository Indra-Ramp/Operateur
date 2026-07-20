<?= $this->extend('operateur/modal') ?>
<?= $this->section('custom_style'); ?>    
    <style>
        body {
            background-color: #F9FAFB;
            color: #191c1d;
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .operator-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

    <!-- Main Content Canvas -->
    <main class="flex-grow md:ml-[280px] p-container-padding transition-all duration-300">
        
        <!-- Header -->
        <header class="flex flex-col md:flex-row md:items-center justify-between mb-xl gap-md">
            <div class="space-y-base">
                <h2 class="font-headline-lg text-headline-lg text-primary tracking-tight">Gestion des Opérateurs</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Monitorez et gérez les flux de liquidités de vos partenaires réseaux.</p>
            </div>
            <div class="flex items-center gap-sm">
                <div class="relative w-full md:w-64">
                    <span class="absolute inset-y-0 left-3 flex items-center text-on-surface-variant pointer-events-none">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </span>
                    <input
                        class="pl-10 pr-md py-sm bg-surface-container rounded-lg border border-transparent focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none text-body-md w-full transition-all"
                        placeholder="Rechercher un opérateur..." type="text" id="operatorSearch" />
                </div>
                <button
                    class="p-sm rounded-lg bg-surface-container-high text-on-surface hover:bg-surface-container-highest transition-colors flex items-center justify-center"
                    title="Filtrer">
                    <span class="material-symbols-outlined">tune</span>
                </button>
            </div>
        </header>

        <!-- Grid Layout -->
        <div class="operator-grid mb-xl">
            <?php if(!empty($list)): ?>
                <?php foreach($list as $l): ?>
                    <a href="<?= base_url('operateur/prefix/' . ($l['id'] ?? '')) ?>" 
                       class="glass-card bg-white/80 backdrop-blur-md border border-gray-200 rounded-xl flex items-center gap-md p-md transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-primary/30 group cursor-pointer">
                        
                        <!-- Dynamic Logo / Initials Container -->
                        <div class="w-12 h-12 bg-secondary-container rounded-lg flex items-center justify-center overflow-hidden shrink-0 shadow-sm">
                            <?php if(!empty($l['logo'])): ?>
                                <img alt="<?= esc($l['label']) ?>" class="w-full h-full object-contain p-1" src="<?= esc($l['logo']) ?>" />
                            <?php else: ?>
                                <span class="font-bold text-primary tracking-wider uppercase text-sm">
                                    <?= substr(esc($l['label']), 0, 2) ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="flex flex-col min-w-0">
                            <h3 class="font-headline-md text-headline-md text-on-surface truncate group-hover:text-primary transition-colors">
                                <?= esc($l['label']) ?>
                            </h3>
                            <span class="text-xs text-on-surface-variant flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity text-primary font-medium">
                                Gérer l'opérateur <span class="material-symbols-outlined text-xs">arrow_forward</span>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full py-xl text-center text-on-surface-variant bg-surface-container rounded-xl border border-dashed border-gray-300">
                    <span class="material-symbols-outlined text-4xl mb-sm block">cloud_off</span>
                    Aucun opérateur disponible.
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Event Journal Table (Preserved) -->
    </main>

    <!-- Mobile Navigation -->
    <div class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-outline-variant flex justify-around py-sm z-50 shadow-lg">
        <button class="flex flex-col items-center text-primary">
            <span class="material-symbols-outlined">person_pin_circle</span>
            <span class="text-[10px] font-bold">Opérateurs</span>
        </button>
        <button class="flex flex-col items-center text-on-surface-variant hover:text-primary transition-colors">
            <span class="material-symbols-outlined">swap_horiz</span>
            <span class="text-[10px]">Transac</span>
        </button>
        <button class="flex flex-col items-center text-on-surface-variant hover:text-primary transition-colors">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-[10px]">Home</span>
        </button>
    </div>

    <!-- Live Client-side Search Interaction -->
    <script>
        document.getElementById('operatorSearch').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.glass-card');
            
            cards.forEach(card => {
                const name = card.querySelector('h3').textContent.toLowerCase();
                if(name.includes(query)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
<?= $this->endSection() ?>