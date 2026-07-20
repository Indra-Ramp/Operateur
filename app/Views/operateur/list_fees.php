<?php 

  $idType = service('request')->getUri()->getSegment(3);
  $errors = session()->get('add_errors');
  $errorsUpdate = session()->get('update_errors');

?>
<?= $this->extend('operateur/modal') ?>
<?= $this->section('main') ?>
  <!-- Top Navigation (Mobile Context & Brand) -->
  <header
    class="fixed top-0 left-0 w-full z-30 flex justify-between items-center px-container-padding h-16 bg-surface border-b border-outline-variant shadow-sm md:pl-[304px]">
    <div class="flex items-center gap-md">
      <button class="md:hidden p-sm hover:bg-surface-container-high rounded-full">
        <span class="material-symbols-outlined">menu</span>
      </button>
      <h2 class="font-headline-md text-headline-md font-bold text-primary">Configuration des frais</h2>
    </div>
    <div class="flex items-center gap-md">
      <button
        class="material-symbols-outlined p-sm text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-full">notifications</button>
      <button
        class="material-symbols-outlined p-sm text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-full">help</button>
      <button
        class="hidden lg:flex items-center gap-xs text-primary font-bold hover:bg-primary-container/10 px-md py-sm rounded-lg transition-colors">
        <span class="material-symbols-outlined">logout</span>
        <span class="font-label-md">Logout</span>
      </button>
    </div>
  </header>
  <!-- Main Content Canvas -->
  <main class="pt-16 h-full overflow-y-auto md:ml-[280px]">
    <div class="p-container-padding max-w-6xl mx-auto space-y-lg">
      <!-- Breadcrumbs & Header -->
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-md">
        <div class="space-y-xs">
          <button class="flex items-center gap-xs text-primary hover:underline transition-all">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span class="font-label-md text-label-md">Retour à la sélection</span>
          </button>
          <h3 class="font-display text-display text-on-surface">Transfert <span
              class="text-on-surface-variant font-normal">/ Orange Money</span></h3>
        </div>
        <button
          id="openAddBracketModalBtn"
          type="button"
          class="bg-primary hover:bg-primary/90 text-on-primary px-lg py-md rounded-lg shadow-lg hover:-translate-y-0.5 transition-all flex items-center gap-sm">
          <span class="material-symbols-outlined">add</span>
          <span class="font-label-md text-label-md uppercase tracking-widest">Ajouter une tranche</span>
        </button>
      </div>
      <!-- Bento Layout Container -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
        <!-- Main Fee Table (Left Col) -->
        <section
          class="lg:col-span-8 bg-surface-container-lowest rounded-xl border border-outline-variant smoky-shadow overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-surface-container-high/50 border-b border-outline-variant">
                  <th class="px-lg py-md font-label-md text-label-md uppercase tracking-wider text-on-surface-variant">
                    Montant Min</th>
                  <th class="px-lg py-md font-label-md text-label-md uppercase tracking-wider text-on-surface-variant">
                    Montant Max</th>
                  <th class="px-lg py-md font-label-md text-label-md uppercase tracking-wider text-on-surface-variant">
                    Frais (FCFA)</th>
                  <th
                    class="px-lg py-md font-label-md text-label-md uppercase tracking-wider text-on-surface-variant text-right">
                    Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-outline-variant">
                <?php 
                  // On récupère l'ID de la ligne qui a échoué à la validation
                  $errorId = session()->getFlashdata('error_id'); 
                  ?>

                  <?php foreach($list as $l): ?>
                      <?php 
                      $isCurrentErrorRow = ($errorId == $l['id']);
                      
                      // On ne récupère la valeur 'old' que si c'est la ligne qui vient d'être soumise
                      $valMontant1 = $isCurrentErrorRow ? (old('montant1') ?? $l['montant1']) : $l['montant1'];
                      $valMontant2 = $isCurrentErrorRow ? (old('montant2') ?? $l['montant2']) : $l['montant2'];
                      $valFrais    = $isCurrentErrorRow ? (old('frais')    ?? $l['frais'])    : $l['frais'];
                      ?>
                      <tr class="hover:bg-primary-container/5 transition-colors">
                          <form action="<?= base_url('/operateur/fee/update') ?>" method="post">
                              <input type="hidden" name="id_type" value="<?= $idType ?>">
                              <input type="hidden" name="id" value="<?= $l['id'] ?>">
                              
                              <!-- Montant 1 -->
                              <td class="px-lg py-md">
                                <!-- <?php echo $errorId ?> -->
                                  <input type="text" value="<?= esc($valMontant1) ?>" name="montant1"
                                      class="w-full bg-surface-container-low border <?= $isCurrentErrorRow && isset($errorsUpdate['montant1']) ? 'border-error focus:ring-error' : 'border-outline-variant focus:ring-primary' ?> rounded px-sm py-xs font-label-md text-label-md outline-none focus:ring-1">
                                  <?php if ($isCurrentErrorRow && isset($errorsUpdate['montant1'])): ?>
                                      <p class="text-error text-xs mt-1"><?= esc($errorsUpdate['montant1']) ?></p>
                                  <?php endif; ?>
                              </td>
                              
                              <!-- Montant 2 -->
                              <td class="px-lg py-md">
                                  <input type="text" value="<?= esc($valMontant2) ?>" name="montant2"
                                      class="w-full bg-surface-container-low border <?= $isCurrentErrorRow && isset($errorsUpdate['montant2']) ? 'border-error focus:ring-error' : 'border-outline-variant focus:ring-primary' ?> rounded px-sm py-xs font-label-md text-label-md outline-none focus:ring-1">
                                  <?php if ($isCurrentErrorRow && isset($errorsUpdate['montant2'])): ?>
                                      <p class="text-error text-xs mt-1"><?= esc($errorsUpdate['montant2']) ?></p>
                                  <?php endif; ?>
                              </td>
                              
                              <!-- Frais -->
                              <td class="px-lg py-md">
                                  <input type="text" value="<?= esc($valFrais) ?>" name="frais"
                                      class="w-full bg-surface-container-low border <?= $isCurrentErrorRow && isset($errorsUpdate['frais']) ? 'border-error focus:ring-error' : 'border-outline-variant' ?> rounded px-sm py-xs font-bold <?= $isCurrentErrorRow && isset($errorsUpdate['frais']) ? 'text-error' : 'text-primary' ?> outline-none focus:ring-1 focus:ring-primary">
                                  <?php if ($isCurrentErrorRow && isset($errorsUpdate['frais'])): ?>
                                      <p class="text-error text-xs mt-1"><?= esc($errorsUpdate['frais']) ?></p>
                                  <?php endif; ?>
                              </td>
                              
                              <!-- Actions -->
                              <td class="px-lg py-md text-right">
                                  <div class="flex items-center justify-end gap-sm">
                                      <button type="submit" name="action" value="update"
                                          class="flex items-center gap-xs bg-primary text-on-primary px-sm py-xs rounded text-label-md hover:bg-primary/90 transition-colors">
                                          <span class="material-symbols-outlined text-[18px]">save</span>
                                          <span>Enregistrer</span>
                                      </button>
                                  </div>
                              </td>
                          </form>
                      </tr>
                  <?php endforeach; ?>
                <!-- <tr class="hover:bg-primary-container/5 transition-colors">
                  <td class="px-lg py-md">
                    <input type="text" value="5 001 FCFA"
                      class="w-full bg-surface-container-low border border-outline-variant rounded px-sm py-xs font-label-md text-label-md focus:ring-1 focus:ring-primary outline-none">
                  </td>
                  <td class="px-lg py-md">
                    <input type="text" value="10 000 FCFA"
                      class="w-full bg-surface-container-low border border-outline-variant rounded px-sm py-xs font-label-md text-label-md focus:ring-1 focus:ring-primary outline-none">
                  </td>
                  <td class="px-lg py-md">
                    <input type="text" value="100"
                      class="w-full bg-surface-container-low border border-outline-variant rounded px-sm py-xs font-bold text-primary focus:ring-1 focus:ring-primary outline-none">
                  </td>
                  <td class="px-lg py-md text-right">
                    <div class="flex items-center justify-end gap-sm">
                      <button
                        class="flex items-center gap-xs bg-primary text-on-primary px-sm py-xs rounded text-label-md hover:bg-primary/90 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        <span class="">Enregistrer</span>
                      </button>
                      <button
                        class="flex items-center gap-xs bg-error text-on-error px-sm py-xs rounded text-label-md hover:bg-error/90 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                        <span class="">Supprimer</span>
                      </button>
                    </div>
                  </td>
                </tr>
                <tr class="hover:bg-primary-container/5 transition-colors">
                  <td class="px-lg py-md">
                    <input type="text" value="10 001 FCFA"
                      class="w-full bg-surface-container-low border border-outline-variant rounded px-sm py-xs font-label-md text-label-md focus:ring-1 focus:ring-primary outline-none">
                  </td>
                  <td class="px-lg py-md">
                    <input type="text" value="25 000 FCFA"
                      class="w-full bg-surface-container-low border border-outline-variant rounded px-sm py-xs font-label-md text-label-md focus:ring-1 focus:ring-primary outline-none">
                  </td>
                  <td class="px-lg py-md">
                    <input type="text" value="250"
                      class="w-full bg-surface-container-low border border-outline-variant rounded px-sm py-xs font-bold text-primary focus:ring-1 focus:ring-primary outline-none">
                  </td>
                  <td class="px-lg py-md text-right">
                    <div class="flex items-center justify-end gap-sm">
                      <button
                        class="flex items-center gap-xs bg-primary text-on-primary px-sm py-xs rounded text-label-md hover:bg-primary/90 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        <span class="">Enregistrer</span>
                      </button>
                      <button
                        class="flex items-center gap-xs bg-error text-on-error px-sm py-xs rounded text-label-md hover:bg-error/90 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                        <span class="">Supprimer</span>
                      </button>
                    </div>
                  </td>
                </tr> -->
              </tbody>
            </table>
          </div>
        </section>
        <!-- Configuration Summary (Right Col) -->
        <aside class="lg:col-span-4 space-y-lg">
          <!-- Preview Card -->
          <!-- Guidelines Card -->
          <div
            class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg smoky-shadow space-y-md">
            <h5 class="font-headline-md text-headline-md text-on-surface flex items-center gap-xs">
              <span class="material-symbols-outlined text-primary">info</span>
              Directives
            </h5>
            <ul class="space-y-sm">
              <li class="flex items-start gap-sm">
                <span class="material-symbols-outlined text-primary text-[18px] mt-1">check_circle</span>
                <p class="text-body-md font-body-md text-on-surface-variant">Assurez-vous que les tranches ne se
                  chevauchent pas.</p>
              </li>
              <li class="flex items-start gap-sm">
                <span class="material-symbols-outlined text-primary text-[18px] mt-1">check_circle</span>
                <p class="text-body-md font-body-md text-on-surface-variant">Le montant maximum de la dernière tranche
                  doit couvrir le plafond autorisé par la loi.</p>
              </li>
              <li class="flex items-start gap-sm">
                <span class="material-symbols-outlined text-primary text-[18px] mt-1">check_circle</span>
                <p class="text-body-md font-body-md text-on-surface-variant">Les modifications sont appliquées
                  instantanément sur le réseau.</p>
              </li>
            </ul>
          </div>
          <!-- Quick Action -->
          <div
            class="bg-surface-container border border-dashed border-outline rounded-xl p-lg flex flex-col items-center text-center space-y-md">
            <span class="material-symbols-outlined text-4xl text-on-surface-variant/30">file_upload</span>
            <div>
              <p class="font-label-md text-label-md font-bold">Importation en masse</p>
              <p class="text-body-md font-body-md text-on-surface-variant">Téléchargez un fichier CSV pour configurer
                tout le barème d'un coup.</p>
            </div>
            <button class="text-primary font-bold hover:underline transition-all">Télécharger le modèle CSV</button>
          </div>
        </aside>
      </div>
    </div>
  </main>
  <!-- Add Bracket Modal -->
  <div id="addBracketModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-md">
    <div class="w-full max-w-lg rounded-xl border border-outline-variant bg-surface-container-lowest p-lg shadow-xl">
      <div class="mb-lg flex items-start justify-between gap-md">
        <div>
          <h3 class="font-headline-md text-headline-md text-on-surface">Ajouter une nouvelle tranche</h3>
          <p class="mt-1 text-sm text-on-surface-variant">Définissez les bornes de montant et le nouveau frais à appliquer.</p>
        </div>
        <button id="closeAddBracketModalBtn" type="button" class="rounded-full p-sm text-on-surface-variant transition-colors hover:bg-surface-container-high">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>

      <form method="post" action="<?= base_url("/operateur/fee/add") ?>" id="addBracketForm" class="space-y-md">
        <input type="hidden" name="id_type" value="<?= $idType ?>">
        <div class="grid gap-md md:grid-cols-2">
          <div>
            <label class="mb-xs block font-label-md text-label-md text-on-surface-variant">Montant minimum</label>
            <input type="number" placeholder="0" name="montant1" value="<?= old('montant1') ?? '' ?>"
              class="w-full rounded-lg border border-outline-variant bg-surface-container-low px-sm py-xs text-body-md outline-none focus:ring-1 focus:ring-primary">
              <p class="text-sm font-medium text-red-600"><?= $errors['montant1'] ?? '' ?></p>
          </div>
          <div>
            <label class="mb-xs block font-label-md text-label-md text-on-surface-variant">Montant maximum</label>
            <input type="number" placeholder="5000" name="montant2" value="<?= old('montant2') ?? '' ?>"
              class="w-full rounded-lg border border-outline-variant bg-surface-container-low px-sm py-xs text-body-md outline-none focus:ring-1 focus:ring-primary">
            <p class="text-sm font-medium text-red-600"><?= $errors['montant2'] ?? '' ?></p>
          </div>
        </div>

        <div>
          <label class="mb-xs block font-label-md text-label-md text-on-surface-variant">Frais (FCFA)</label>
          <input type="number" step="1" placeholder="50" name="frais" value="<?= old('frais') ?? '' ?>"
            class="w-full rounded-lg border border-outline-variant bg-surface-container-low px-sm py-xs text-body-md outline-none focus:ring-1 focus:ring-primary">
          <p class="text-sm font-medium text-red-600"><?= $errors['frais'] ?? '' ?></p>
        </div>

        <div class="flex justify-end gap-sm pt-sm">
          <button id="cancelAddBracketBtn" type="button" class="rounded-lg px-lg py-sm font-label-md text-on-surface-variant transition-colors hover:bg-surface-container-high">
            Annuler
          </button>
          <button type="submit" class="rounded-lg bg-primary px-lg py-sm font-label-md text-on-primary shadow-md transition-all hover:bg-primary/90">
            Ajouter la tranche
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Success Feedback Overlay (Hidden by default) -->
  <div
    class="fixed bottom-lg right-lg bg-surface-container-lowest border-l-4 border-primary p-md rounded-lg modal-shadow flex items-center gap-md transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none"
    id="toast">
    <div class="w-8 h-8 bg-primary-container rounded-full flex items-center justify-center text-on-primary-container">
      <span class="material-symbols-outlined text-[18px]">done</span>
    </div>
    <div>
      <p class="font-label-md text-label-md font-bold">Configuration mise à jour</p>
      <p class="text-body-md text-on-surface-variant">La nouvelle tranche de frais a été enregistrée.</p>
    </div>
  </div>
  <!-- Micro-interactions Script -->
  <script>
    const openAddBracketModalBtn = document.getElementById('openAddBracketModalBtn');
    const modal = document.getElementById('addBracketModal');
    const closeAddBracketModalBtn = document.getElementById('closeAddBracketModalBtn');
    const cancelAddBracketBtn = document.getElementById('cancelAddBracketBtn');
    const addBracketForm = document.getElementById('addBracketForm');
    const toast = document.getElementById('toast');

    function toggleAddBracketModal(show) {
      if (show) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      } else {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
      }
    }

    toggleAddBracketModal(<?= session()->has('add_errors') ?>);

    openAddBracketModalBtn.addEventListener('click', () => toggleAddBracketModal(true));
    [closeAddBracketModalBtn, cancelAddBracketBtn].forEach(btn => {
      btn.addEventListener('click', () => toggleAddBracketModal(false));
    });

    modal.addEventListener('click', (event) => {
      if (event.target === modal) {
        toggleAddBracketModal(false);
      }
    });

    // addBracketForm.addEventListener('submit', (event) => {
    //   event.preventDefault();
    //   toggleAddBracketModal(false);
    //   toast.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');
    //   setTimeout(() => {
    //     toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
    //   }, 3000);
    // });

    // Add hover lift effect manually via JS for some elements
    document.querySelectorAll('.smoky-shadow').forEach(card => {
      card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-2px)';
        card.style.transition = 'transform 0.2s ease-out';
      });
      card.addEventListener('mouseleave', () => {
        card.style.transform = 'translateY(0)';
      });
    });
  </script>
  <?= $this->endSection() ?>
