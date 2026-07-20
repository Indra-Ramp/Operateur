

<?= $this->extend('operateur/modal') ?>
<?= $this->section('main') ?>
    <main class="ml-[280px] min-h-screen p-container-padding">
        <!-- Header Section -->
        <header class="flex justify-between items-center mb-xl">
            <div>
                <h2 class="font-headline-lg text-headline-lg text-on-surface">Configuration des préfixes</h2>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">Gérez les indicatifs et les
                    associations avec les opérateurs réseau.</p>
            </div>
            <button
                class="flex items-center gap-sm bg-primary text-on-primary px-lg py-sm rounded-lg font-label-md hover:shadow-lg transition-all active:scale-95"
                onclick="toggleModal(true)">
                <span class="material-symbols-outlined">add</span>
                Ajouter un nouveau préfixe
            </button>
        </header>
        <!-- Stats Bento Grid (Mini) -->
        <!-- Main Data Table Container -->
        <?php $prefixList = $prefixes ?? []; ?>
        <section
            class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden custom-shadow">
            <div class="flex flex-wrap items-center justify-between gap-md border-b border-outline-variant bg-surface-container-low px-lg py-md">
                <div>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface">Liste des préfixes</h3>
                    <p class="text-sm text-on-surface-variant mt-1">Consultez rapidement les préfixes enregistrés.</p>
                </div>
                <div class="flex flex-wrap items-center gap-sm">
                    <span class="inline-flex items-center rounded-full bg-primary-container px-sm py-1 text-[12px] font-semibold text-on-primary-container">
                        <?= count($prefixList) ?> préfixes
                    </span>
                    <span class="inline-flex items-center rounded-full bg-secondary-container px-sm py-1 text-[12px] font-semibold text-on-secondary-container">
                        Ajoutés récemment
                    </span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-surface-container-low/70">
                        <tr>
                            <th
                                class="px-lg py-md font-label-md text-label-md text-on-surface-variant uppercase tracking-widest border-b border-outline-variant">
                                Préfixe</th>
                            <th
                                class="px-lg py-md font-label-md text-label-md text-on-surface-variant uppercase tracking-widest border-b border-outline-variant">
                                Ajouté le</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        <?php if (empty($prefixList)): ?>
                            <tr>
                                <td colspan="2" class="px-lg py-xl text-center text-sm text-on-surface-variant">
                                    Aucun préfixe enregistré pour le moment.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($prefixList as $p): ?>
                                <tr class="group transition-all hover:bg-primary-container/15">
                                    <td class="px-lg py-md">
                                        <div class="flex items-center gap-sm">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-container text-sm font-semibold text-primary">
                                                <?= esc(substr((string) ($p['label'] ?? ''), 0, 1)) ?>
                                            </div>
                                            <div>
                                                <div class="font-body-md font-semibold text-on-surface"><?= esc($p['label'] ?? '') ?></div>
                                                <div class="text-sm text-on-surface-variant">Préfixe actif</div>
                                            </div>
                                        </div>
                                    </td>
                                    <?php
                                    
                                        $date = new DateTime($p['created_at']);

                                        $formatter = new IntlDateFormatter(
                                            'fr_FR',
                                            IntlDateFormatter::FULL,
                                            IntlDateFormatter::NONE,
                                            'Europe/Paris',
                                            IntlDateFormatter::GREGORIAN,
                                        );

                                        
                                    
                                    ?>
                                    <td class="px-lg py-md">
                                        <div class="flex items-center justify-between gap-md">
                                            <span class="font-body-md text-on-surface-variant"><?= esc(ucfirst($formatter->format($date)) ?? '') ?></span>
                                            
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <!-- Modal Backdrop -->
    <div class="fixed inset-0 z-50 modal-overlay hidden flex items-center justify-center p-md" id="prefixModal">
        <!-- Modal Card -->
        <div class="bg-surface-container-lowest w-full max-w-lg rounded-xl custom-shadow overflow-hidden transform scale-95 transition-transform duration-300"
            id="modalCard">
            <div class="p-lg border-b border-outline-variant flex justify-between items-center">
                <h3 class="font-headline-md text-headline-md text-on-surface">Ajouter un nouveau préfixe</h3>
                <button
                    class="text-on-surface-variant hover:bg-surface-container-high p-1 rounded-full transition-colors"
                    onclick="toggleModal(false)">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form action="<?= base_url("/operateur/prefix/new") ?>" method="post">
                <div class="p-lg space-y-lg">
                <!-- Form Group -->
                    <div class="flex gap-lg">
                        <div class="flex-1 space-y-sm">
                            <label class="block font-label-md text-on-surface-variant uppercase tracking-wider">Indicatif
                                téléphonique</label>
                            <div>
                                <input
                                    name='label'
                                    class="w-full border-outline-variant focus:border-primary focus:ring-primary rounded-r-lg text-body-md h-11"
                                    placeholder="033" type="number"
                                    value="<?= old('label') ?? '' ?>" />
                                <p class="text-sm text-red-600 mt-1"><?= esc(session('errors')['label'] ?? '') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-lg bg-surface-container-low flex justify-end gap-md">
                    <button
                        type="button"
                        role="button"
                        class="px-lg py-sm font-label-md text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-lg"
                        onclick="toggleModal(false)">
                        Annuler
                    </button>
                    <button
                        class="px-lg py-sm bg-primary text-on-primary font-label-md rounded-lg shadow-md hover:translate-y-[-1px] active:scale-95 transition-all">
                        Créer la configuration
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function toggleModal(show) {
            const modal = document.getElementById('prefixModal');
            const card = document.getElementById('modalCard');
            if (show) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    card.classList.remove('scale-95');
                    card.classList.add('scale-100');
                }, 10);
            } else {
                card.classList.remove('scale-100');
                card.classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 200);
            }
        }
        toggleModal(<?= session()->has('errors') ?>);

        // Close modal on background click
        document.getElementById('prefixModal').addEventListener('click', (e) => {
            if (e.target.id === 'prefixModal') toggleModal(false);
        });

        // Simple table interactions
        document.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('click', () => {
                // Mock selection visual
                console.log('Row clicked');
            });
        });
    </script>
    <?= $this->endSection() ?>