<?= $this->extend('operateur/modal') ?>
<?= $this->section('main') ?>
    <?php 
        $prefixList = $prefixes ?? []; 
        $opId = $operator['id'] ?? '';
        $opLabel = $operator['label'] ?? 'Opérateur';
        $opLogo = $operator['logo'] ?? '';
        $opCommission = $operator['commission'] ?? 0; // Récupération de la commission (ex: 2.5)
        $opCommission *= 100;
    ?>

    <main class="ml-[280px] min-h-screen p-container-padding">
        <!-- Fil d'Ariane & Contexte Opérateur -->
        <header class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-xl gap-md">
            <div>
                <div class="flex items-center gap-xs mb-xs text-sm">
                    <a href="<?= base_url('operateur') ?>" class="text-primary hover:underline font-label-md flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">arrow_back</span> Opérateurs
                    </a>
                    <span class="text-on-surface-variant">/</span>
                    <span class="text-on-surface-variant font-medium">Configuration des préfixes</span>
                </div>
                
                <div class="flex flex-wrap items-center gap-lg mt-2">
                    <div class="flex items-center gap-md">
                        <div class="w-12 h-12 bg-secondary-container rounded-xl flex items-center justify-center overflow-hidden shrink-0 shadow-sm border border-outline-variant">
                            <?php if(!empty($opLogo)): ?>
                                <img alt="<?= esc($opLabel) ?>" class="w-full h-full object-contain p-1" src="<?= esc($opLogo) ?>" />
                            <?php else: ?>
                                <span class="font-bold text-primary uppercase text-sm tracking-wider"><?= substr(esc($opLabel), 0, 2) ?></span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h2 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Préfixes : <?= esc($opLabel) ?></h2>
                            <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">Gérez les indicatifs téléphoniques affectés à ce partenaire réseau.</p>
                        </div>
                    </div>

                    <!-- Badge de la commission actuelle -->
                    <div class="bg-surface-container-high border border-outline-variant px-md py-sm rounded-xl flex items-center gap-sm shadow-sm">
                        <span class="material-symbols-outlined text-primary text-[20px]">percent</span>
                        <div>
                            <div class="text-[11px] uppercase tracking-wider text-on-surface-variant font-label-md">Commission</div>
                            <div class="font-headline-sm text-on-surface font-bold"><?= esc($opCommission) ?> %</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-sm shrink-0 w-full lg:w-auto justify-end">
                <button
                    class="flex items-center gap-sm bg-surface-container-highest text-on-surface border border-outline-variant px-lg py-sm rounded-lg font-label-md hover:bg-surface-container-high transition-all active:scale-95"
                    onclick="toggleCommissionModal(true)">
                    <span class="material-symbols-outlined text-[20px]">edit</span>
                    Commissions
                </button>
                <button
                    class="flex items-center gap-sm bg-primary text-on-primary px-lg py-sm rounded-lg font-label-md hover:shadow-lg transition-all active:scale-95"
                    onclick="togglePrefixModal(true)">
                    <span class="material-symbols-outlined">add</span>
                    Ajouter un préfixe
                </button>
            </div>
        </header>

        <!-- Tableau des données -->
        <section class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden custom-shadow">
            <div class="flex flex-wrap items-center justify-between gap-md border-b border-outline-variant bg-surface-container-low px-lg py-md">
                <div>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface">Liste des indicatifs</h3>
                    <p class="text-sm text-on-surface-variant mt-1">Préfixes actuellement configurés et actifs sur ce réseau.</p>
                </div>
                <div>
                    <span class="inline-flex items-center rounded-full bg-primary-container px-sm py-1 text-[12px] font-semibold text-on-primary-container">
                        <?= count($prefixList) ?> préfixe<?= count($prefixList) > 1 ? 's' : '' ?>
                    </span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-surface-container-low/70">
                        <tr>
                            <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant uppercase tracking-widest border-b border-outline-variant">Préfixe</th>
                            <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant uppercase tracking-widest border-b border-outline-variant">Statut</th>
                            <th class="px-lg py-md font-label-md text-label-md text-on-surface-variant uppercase tracking-widest border-b border-outline-variant">Ajouté le</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        <?php if (empty($prefixList)): ?>
                            <tr>
                                <td colspan="3" class="px-lg py-xl text-center text-sm text-on-surface-variant">
                                    Aucun préfixe enregistré pour cet opérateur.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($prefixList as $p): ?>
                                <tr class="group transition-all hover:bg-primary-container/10">
                                    <td class="px-lg py-md">
                                        <div class="flex items-center gap-sm">
                                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-primary-container text-sm font-bold text-primary">
                                                +<?= esc($p['label'] ?? '') ?>
                                            </div>
                                            <div>
                                                <div class="font-body-md font-semibold text-on-surface">+<?= esc($p['label'] ?? '') ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-lg py-md">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 border border-emerald-200">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Actif
                                        </span>
                                    </td>
                                    <?php
                                        $date = new DateTime($p['created_at'] ?? 'now');
                                        $formatter = new IntlDateFormatter(
                                            'fr_FR',
                                            IntlDateFormatter::FULL,
                                            IntlDateFormatter::NONE,
                                            'Europe/Paris',
                                            IntlDateFormatter::GREGORIAN,
                                        );
                                    ?>
                                    <td class="px-lg py-md">
                                        <span class="font-body-md text-on-surface-variant"><?= esc(ucfirst($formatter->format($date)) ?? '') ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Modal d'ajout de préfixe -->
    <div class="fixed inset-0 z-50 hidden flex items-center justify-center p-md bg-black/40 backdrop-blur-sm transition-all" id="prefixModal">
        <div class="bg-surface-container-lowest w-full max-w-md rounded-xl custom-shadow overflow-hidden transform scale-95 transition-transform duration-300" id="prefixModalCard">
            <div class="p-lg border-b border-outline-variant flex justify-between items-center">
                <div>
                    <h3 class="font-headline-md text-headline-md text-on-surface">Nouveau préfixe</h3>
                    <p class="text-xs text-on-surface-variant mt-0.5">Association directe avec <strong class="text-primary"><?= esc($opLabel) ?></strong></p>
                </div>
                <button class="text-on-surface-variant hover:bg-surface-container-high p-1 rounded-full transition-colors" onclick="togglePrefixModal(false)">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <form action="<?= base_url("/operateur/prefix/new") ?>" method="post">
                <input type="hidden" name="id_operateur" value="<?= esc($opId) ?>">

                <div class="p-lg space-y-lg">
                    <div class="space-y-sm">
                        <label class="block font-label-md text-on-surface-variant uppercase tracking-wider text-xs">Indicatif réseau</label>
                        <div class="relative rounded-md shadow-sm">
                            <input
                                name="label"
                                class="w-full border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none rounded-lg text-body-md h-11 pl-4 pr-3 transition-all <?= session('errors.label') ? 'border-red-600 focus:ring-red-200' : '' ?>"
                                placeholder="221" type="number"
                                value="<?= old('label') ?? '' ?>" required />
                        </div>
                        <?php if (session('errors')): ?>
                            <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">error</span> <?= esc(session('errors')) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="p-lg bg-surface-container-low flex justify-end gap-md border-t border-outline-variant">
                    <button type="button" class="px-lg py-sm font-label-md text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-lg text-sm" onclick="togglePrefixModal(false)">
                        Annuler
                    </button>
                    <button class="px-lg py-sm bg-primary text-on-primary font-label-md rounded-lg shadow-md hover:translate-y-[-1px] active:scale-95 transition-all text-sm">
                        Confirmer l'ajout
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de modification de la commission -->
    <div class="fixed inset-0 z-50 hidden flex items-center justify-center p-md bg-black/40 backdrop-blur-sm transition-all" id="commissionModal">
        <div class="bg-surface-container-lowest w-full max-w-md rounded-xl custom-shadow overflow-hidden transform scale-95 transition-transform duration-300" id="commissionModalCard">
            <div class="p-lg border-b border-outline-variant flex justify-between items-center">
                <div>
                    <h3 class="font-headline-md text-headline-md text-on-surface">Ajuster la commission</h3>
                    <p class="text-xs text-on-surface-variant mt-0.5">Mise à jour du taux pour <strong class="text-primary"><?= esc($opLabel) ?></strong></p>
                </div>
                <button class="text-on-surface-variant hover:bg-surface-container-high p-1 rounded-full transition-colors" onclick="toggleCommissionModal(false)">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <form action="<?= base_url("/operateur/commission/update") ?>" method="post">
                <input type="hidden" name="id_operateur" value="<?= esc($opId) ?>">

                <div class="p-lg space-y-lg">
                    <div class="space-y-sm">
                        <label class="block font-label-md text-on-surface-variant uppercase tracking-wider text-xs">Pourcentage de commission</label>
                        <div class="relative rounded-md shadow-sm flex items-center">
                            <input
                                name="perc"
                                class="w-full border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none rounded-lg text-body-md h-11 pl-4 pr-10 transition-all <?= session('errors.commission') ? 'border-red-600 focus:ring-red-200' : '' ?>"
                                placeholder="0.00" type="number" step="0.01"
                                value="<?= old('perc') ?? esc($opCommission) ?>" required />
                            <span class="absolute right-4 text-on-surface-variant font-semibold">%</span>
                        </div>
                        <?php if (session('errors_commission')): ?>
                            <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">error</span> <?= esc(session('errors_commission')['perc']) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="p-lg bg-surface-container-low flex justify-end gap-md border-t border-outline-variant">
                    <button type="button" class="px-lg py-sm font-label-md text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-lg text-sm" onclick="toggleCommissionModal(false)">
                        Annuler
                    </button>
                    <button class="px-lg py-sm bg-primary text-on-primary font-label-md rounded-lg shadow-md hover:translate-y-[-1px] active:scale-95 transition-all text-sm">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Fonctions pour le Modal de Préfixe
        function togglePrefixModal(show) {
            const modal = document.getElementById('prefixModal');
            const card = document.getElementById('prefixModalCard');
            if (show) {
                modal.classList.remove('hidden');
                setTimeout(() => { card.classList.replace('scale-95', 'scale-100'); }, 10);
            } else {
                card.classList.replace('scale-100', 'scale-95');
                setTimeout(() => { modal.classList.add('hidden'); }, 200);
            }
        }

        // Fonctions pour le Modal de Commission
        function toggleCommissionModal(show) {
            const modal = document.getElementById('commissionModal');
            const card = document.getElementById('commissionModalCard');
            if (show) {
                modal.classList.remove('hidden');
                setTimeout(() => { card.classList.replace('scale-95', 'scale-100'); }, 10);
            } else {
                card.classList.replace('scale-100', 'scale-95');
                setTimeout(() => { modal.classList.add('hidden'); }, 200);
            }
        }
        
        // Persistance des modals si erreurs de validation de session
        <?php if (session()->has('errors')): ?>
            <?php if (session('errors')): ?>
                togglePrefixModal(true);
        <?php endif; ?>
        <?php elseif (session('errors_commission')): ?>
            toggleCommissionModal(true);
        <?php endif; ?>

        // Fermeture au clic externe sur les overlays
        document.getElementById('prefixModal').addEventListener('click', (e) => {
            if (e.target.id === 'prefixModal') togglePrefixModal(false);
        });
        document.getElementById('commissionModal').addEventListener('click', (e) => {
            if (e.target.id === 'commissionModal') toggleCommissionModal(false);
        });
    </script>
<?= $this->endSection() ?>