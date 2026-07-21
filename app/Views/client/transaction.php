<?= $this->extend('client/navbar') ?>
<?= $this->section('container') ?>
<main class="pt-24 pb-12 px-container-padding max-w-4xl mx-auto">
<!-- Dashboard Header Context -->
<div class="mb-xl text-center md:text-left">
<h1 class="font-display text-display text-on-background mb-base">Execute Transaction</h1>
<p class="text-on-surface-variant font-body-lg">Move your money with enterprise-grade security.</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
<!-- Left: Transaction Form -->
<div class="lg:col-span-8">
<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant p-lg md:p-xl">
<form class="space-y-xl" id="transactionForm" action="/client/transfert" method="post">
<?php if (session()->getFlashdata('error')): ?>
    <div class="rounded-lg border border-error text-error bg-error/10 px-md py-sm font-medium flex items-start gap-xs">
        <span class="material-symbols-outlined text-base leading-none mt-[2px]">error</span>
        <span><?= esc(session()->getFlashdata('error')) ?></span>
    </div>
<?php elseif (session()->getFlashdata('success')): ?>
    <div class="rounded-lg border border-primary text-primary bg-primary/10 px-md py-sm font-medium flex items-start gap-xs">
        <span class="material-symbols-outlined text-base leading-none mt-[2px]">check_circle</span>
        <span><?= esc(session()->getFlashdata('success')) ?></span>
    </div>
<?php endif ?>
<input type="hidden" name="operation_type" id="operationType" value="transfer">
<!-- Step 1: Operation Type -->
<div class="space-y-md">
<label class="block font-headline-md text-on-surface">1. Select Operation</label>
<div class="grid grid-cols-3 gap-md">
<button class="flex flex-col items-center justify-center p-lg rounded-xl border-2 border-outline-variant hover:border-primary-container transition-all group" id="btn-transfer" onclick="setOperation('transfer')" type="button">
<span class="material-symbols-outlined text-primary mb-sm text-[32px] group-hover:scale-110 transition-transform" data-icon="swap_horiz">swap_horiz</span>
<span class="font-label-md">Transfer</span>
</button>
<button class="flex flex-col items-center justify-center p-lg rounded-xl border-2 border-outline-variant hover:border-primary-container transition-all group" id="btn-deposit" onclick="setOperation('deposit')" type="button">
<span class="material-symbols-outlined text-primary mb-sm text-[32px] group-hover:scale-110 transition-transform" data-icon="account_balance_wallet">account_balance_wallet</span>
<span class="font-label-md">Deposit</span>
</button>
<button class="flex flex-col items-center justify-center p-lg rounded-xl border-2 border-outline-variant hover:border-primary-container transition-all group" id="btn-withdrawal" onclick="setOperation('withdrawal')" type="button">
<span class="material-symbols-outlined text-primary mb-sm text-[32px] group-hover:scale-110 transition-transform" data-icon="atm">atm</span>
<span class="font-label-md">Retrait</span>
</button>
</div>
</div>
<!-- Step 2: Recipient (Conditional) -->
<div class="space-y-md hidden opacity-0 transition-opacity duration-300" id="recipientSection">
<div class="flex justify-between items-center">
<label class="block font-headline-md text-on-surface">2. Recipient Details</label>
<label class="flex items-center gap-xs cursor-pointer select-none">
    <input class="rounded border-outline-variant text-primary focus:ring-primary" id="multiToggle" type="checkbox"/>
    <span class="font-label-md text-on-surface-variant">Envoi multiple</span>
</label>
</div>

<!-- Single recipient (default) -->
<div id="singleRecipient">
<div class="flex gap-sm">
    <div class="relative group w-1/3">
        <select class="h-12 w-full bg-surface-container-low px-md pr-sm border border-outline-variant text-on-surface font-body-md focus:ring-0 focus:outline-none cursor-pointer appearance-none rounded-lg" name="prefixe">
            <?php foreach ($prefixes as $p): ?>
                <option value="<?= esc($p['label']) ?>"><?= esc($p['label']) ?></option>
            <?php endforeach ?>
        </select>
        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[18px]">expand_more</span>
    </div>
    <div class="relative flex-1">
        <div class="absolute inset-y-0 left-0 flex items-center pl-md pointer-events-none">
            <span class="material-symbols-outlined text-outline" data-icon="phone_iphone">phone_iphone</span>
        </div>
        <input class="w-full pl-xl pr-md py-md bg-surface-container-low border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" name="phone" id="destPhone" placeholder="0000000" type="tel" inputmode="numeric" maxlength="7" />
    </div>
</div>
<p class="font-label-md text-on-surface-variant flex items-center gap-xs">
<span class="material-symbols-outlined text-sm" data-icon="info">info</span>
Sélectionnez le préfixe puis saisissez les 7 chiffres suivants du destinataire (10 chiffres au total, pas 10 après le préfixe).
</p>
</div>

<!-- Multiple recipients -->
<div class="hidden space-y-sm" id="multiRecipients">
<div class="space-y-sm" id="multiRows"></div>
<button class="flex items-center gap-xs px-md py-sm rounded-lg border border-dashed border-outline-variant text-primary hover:bg-primary-container/20 transition-colors font-label-md" id="addRecipientBtn" type="button">
<span class="material-symbols-outlined text-[18px]">add</span>
Ajouter un destinataire
</button>
<p class="font-label-md text-on-surface-variant flex items-center gap-xs">
<span class="material-symbols-outlined text-sm" data-icon="info">info</span>
Le montant total saisi ci-dessous sera divisé équitablement entre tous les destinataires.
</p>
</div>
</div>
<!-- Step 3: Amount -->
<div class="space-y-md" id="amountSection">
<label class="block font-headline-md text-on-surface" id="amountLabel">2. Transaction Amount</label>
<div class="relative flex items-center">
<div class="flex items-center justify-center px-lg h-full bg-surface-container-high border border-outline-variant border-r-0 rounded-l-lg font-label-md text-on-surface-variant">
                                    Ar
                                </div>
<input class="w-full px-md py-md bg-surface-container-low border border-outline-variant rounded-r-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none font-label-md text-lg" name="montant" id="montantInput" placeholder="0" type="number" min="1" step="1"/>
</div>
<div class="flex flex-wrap gap-sm">
<button class="quick-amount px-md py-sm bg-surface-container-high rounded-full font-label-md text-on-surface-variant hover:bg-primary-container hover:text-on-primary-container transition-colors" type="button" data-amount="5000">5 000 Ar</button>
<button class="quick-amount px-md py-sm bg-surface-container-high rounded-full font-label-md text-on-surface-variant hover:bg-primary-container hover:text-on-primary-container transition-colors" type="button" data-amount="20000">20 000 Ar</button>
<button class="quick-amount px-md py-sm bg-surface-container-high rounded-full font-label-md text-on-surface-variant hover:bg-primary-container hover:text-on-primary-container transition-colors" type="button" data-amount="50000">50 000 Ar</button>
<button id="btn-max" class="px-md py-sm bg-surface-container-high rounded-full font-label-md text-on-surface-variant hover:bg-primary-container hover:text-on-primary-container transition-colors" type="button">Max</button>
</div>
<label class="flex items-start gap-sm pt-sm hidden" id="fraisOptionWrapper">
<input class="mt-[3px] rounded border-outline-variant text-primary focus:ring-primary" id="inclureFrais" name="inclure_frais" type="checkbox" value="1"/>
<span class="font-label-md text-on-surface-variant">
Inclure les frais de retrait dans le montant envoyé <span class="text-on-surface-variant/70">(le destinataire reçoit alors le montant saisi moins les frais, au lieu de payer le montant + frais en plus)</span>
</span>
</label>
</div>
<!-- Action -->
<div class="pt-lg border-t border-outline-variant">
<button class="w-full bg-primary hover:bg-on-primary-container text-white py-lg rounded-xl font-headline-md shadow-md hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-sm" type="submit">
                                Confirm Transaction
                                <span class="material-symbols-outlined" data-icon="lock">lock</span>
</button>
<p class="mt-md text-center text-on-surface-variant font-label-md">
                                Vérifiez les informations avant de valider
                            </p>
</div>
</form>
</div>
</div>
<!-- Right: Info & Summary Panel -->
<div class="lg:col-span-4 space-y-lg">
<!-- Balance Card -->
<div class="bg-primary text-on-primary p-lg rounded-xl shadow-md relative overflow-hidden">
<div class="relative z-10">
<p class="font-label-md opacity-80 mb-xs">Solde disponible</p>
<h2 class="font-display text-display"><?= number_format($soldeCompte, 0, ',', ' ') ?> <span class="text-xl font-normal">Ar</span></h2>
<div class="mt-lg flex items-center gap-xs">
<span class="material-symbols-outlined text-sm" data-icon="phone_iphone">phone_iphone</span>
<span class="font-label-md text-primary-fixed-dim"><?= esc($compte['tel'] ?? '') ?></span>
</div>
</div>
<!-- Decorative pattern -->
<div class="absolute -right-4 -bottom-4 opacity-10">
<span class="material-symbols-outlined text-[120px]" data-icon="account_balance">account_balance</span>
</div>
</div>
<!-- Recent Activity Bento -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md">
<div class="flex justify-between items-center mb-md">
<h3 class="font-headline-md text-on-surface">Recent</h3>
<a class="text-primary font-label-md hover:underline" href="/client/dashboard">View All</a>
</div>
<div class="space-y-md">
<?php if (! empty($recentes)): ?>
    <?php $idCompte = (int) ($compte['id'] ?? 0); ?>
    <?php foreach ($recentes as $op): ?>
        <?php
            $isOutgoing = ((int) $op['id_compte1'] === $idCompte);
            $credit = ($op['type_label'] === 'depot') || ($op['type_label'] === 'transfert' && ! $isOutgoing);
            $label = match ($op['type_label']) {
                'depot'     => 'Dépôt',
                'retrait'   => 'Retrait',
                'transfert' => $isOutgoing ? 'Vers ' . esc($op['tel_compte2'] ?? 'N/A') : 'De ' . esc($op['tel_compte1'] ?? 'N/A'),
                default     => esc($op['type_label']),
            };
        ?>
        <div class="flex items-center gap-md p-sm hover:bg-surface-container-low rounded-lg transition-colors">
            <div class="h-10 w-10 rounded-full <?= $credit ? 'bg-primary-container' : 'bg-secondary-container' ?> flex items-center justify-center">
                <span class="material-symbols-outlined <?= $credit ? 'text-on-primary-container' : 'text-on-secondary-container' ?>" data-icon="<?= $credit ? 'arrow_downward' : 'arrow_outward' ?>"><?= $credit ? 'arrow_downward' : 'arrow_outward' ?></span>
            </div>
            <div class="flex-1">
                <p class="font-body-md text-on-surface font-semibold"><?= $label ?></p>
                <p class="text-xs text-on-surface-variant"><?= esc($op['date_track']) ?></p>
            </div>
            <p class="font-label-md <?= $credit ? 'text-primary' : 'text-on-surface' ?>"><?= $credit ? '+' : '-' ?> <?= number_format($op['montant'], 0, ',', ' ') ?> Ar</p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-sm text-on-surface-variant">Aucune opération récente.</p>
<?php endif; ?>
</div>
</div>
<!-- Security Tip Card -->
<!-- <div class="bg-tertiary-container text-on-tertiary-container p-lg rounded-xl border border-tertiary">
<div class="flex items-start gap-md">
<span class="material-symbols-outlined mt-base" data-icon="verified_user">verified_user</span>
<div>
<h4 class="font-headline-md mb-xs">Security Check</h4>
<p class="text-sm opacity-90">Always verify the recipient's phone number before confirming. MobileMoney will never ask for your PIN via SMS.</p>
</div>
</div>
</div> -->
</div>
</div>
</main>
<script>
        const soldeDisponible = <?= (float) $soldeCompte ?>;
        const SUITE_LENGTH = 7; // longueur de la suite après le préfixe (préfixe 3 + suite 7 = 10)
        // Options du select préfixe, générées côté serveur, réutilisées pour
        // chaque ligne destinataire ajoutée dynamiquement en mode multiple.
        const prefixOptionsHtml = `<?= implode('', array_map(
            fn ($p) => '<option value="' . esc($p['label'], 'attr') . '">' . esc($p['label']) . '</option>',
            $prefixes
        )) ?>`;

        let currentOperation = 'transfer';

        function setOperation(type) {
            currentOperation = type;
            
            // UI Updates for buttons
            const buttons = ['transfer', 'deposit', 'withdrawal'];
            buttons.forEach(btn => {
                const el = document.getElementById(`btn-${btn}`);
                if (btn === type) {
                    el.classList.add('border-primary', 'bg-primary-container', 'text-on-primary-container');
                    el.classList.remove('border-outline-variant');
                } else {
                    el.classList.remove('border-primary', 'bg-primary-container', 'text-on-primary-container');
                    el.classList.add('border-outline-variant');
                }
            });

            // Handle step conditional visibility
            const recipientSection = document.getElementById('recipientSection');
            const destPhone = document.getElementById('destPhone');
            const amountLabel = document.getElementById('amountLabel');
            const form = document.getElementById('transactionForm');
            const operationType = document.getElementById('operationType');
            const fraisOptionWrapper = document.getElementById('fraisOptionWrapper');
            const multiToggle = document.getElementById('multiToggle');

            if (type === 'transfer') {
                recipientSection.classList.remove('hidden');
                setTimeout(() => recipientSection.classList.remove('opacity-0'), 10);
                destPhone.required = ! multiToggle.checked;
                amountLabel.innerText = multiToggle.checked ? '3. Montant total à répartir' : '3. Transaction Amount';
                form.action = multiToggle.checked ? '/client/transfert-multiple' : '/client/transfert';
                operationType.value = 'transfer';
                fraisOptionWrapper.classList.remove('hidden');
            } else if (type === 'deposit') {
                recipientSection.classList.add('opacity-0');
                setTimeout(() => recipientSection.classList.add('hidden'), 300);
                destPhone.required = false;
                amountLabel.innerText = '2. Transaction Amount';
                form.action = '/client/depot';
                operationType.value = 'depot';
                fraisOptionWrapper.classList.add('hidden');
            } else {
                recipientSection.classList.add('opacity-0');
                setTimeout(() => recipientSection.classList.add('hidden'), 300);
                destPhone.required = false;
                amountLabel.innerText = '2. Transaction Amount';
                form.action = '/client/retrait';
                operationType.value = 'retrait';
                // fraisOptionWrapper.classList.add('hidden');
            }
        }

        // --- Envoi multiple : gestion des lignes destinataires ---

        function buildRecipientRow() {
            const row = document.createElement('div');
            row.className = 'flex gap-sm items-center recipient-row';
            row.innerHTML = `
                <div class="relative group w-1/3">
                    <select class="h-12 w-full bg-surface-container-low px-md pr-sm border border-outline-variant text-on-surface font-body-md focus:ring-0 focus:outline-none cursor-pointer appearance-none rounded-lg" name="prefixe[]">
                        ${prefixOptionsHtml}
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[18px]">expand_more</span>
                </div>
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-md pointer-events-none">
                        <span class="material-symbols-outlined text-outline">phone_iphone</span>
                    </div>
                    <input class="w-full pl-xl pr-md py-md bg-surface-container-low border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none recipient-phone" name="phone[]" placeholder="0000000" type="tel" inputmode="numeric" maxlength="${SUITE_LENGTH}"/>
                </div>
                <button type="button" class="removeRecipientBtn p-sm text-error hover:bg-error/10 rounded-lg transition-colors" title="Retirer ce destinataire">
                    <span class="material-symbols-outlined">close</span>
                </button>
            `;

            row.querySelector('.recipient-phone').addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').slice(0, SUITE_LENGTH);
            });

            row.querySelector('.removeRecipientBtn').addEventListener('click', () => {
                const rows = document.querySelectorAll('#multiRows .recipient-row');
                // On garde toujours au moins deux destinataires pour un envoi multiple.
                if (rows.length > 2) {
                    row.remove();
                }
            });

            return row;
        }

        function addRecipientRow() {
            document.getElementById('multiRows').appendChild(buildRecipientRow());
        }

        document.getElementById('addRecipientBtn').addEventListener('click', addRecipientRow);

        document.getElementById('multiToggle').addEventListener('change', function () {
            const singleRecipient = document.getElementById('singleRecipient');
            const multiRecipients = document.getElementById('multiRecipients');
            const destPhone = document.getElementById('destPhone');
            const destPrefixe = singleRecipient.querySelector('select[name="prefixe"]');
            const multiRows = document.getElementById('multiRows');

            if (this.checked) {
                singleRecipient.classList.add('hidden');
                multiRecipients.classList.remove('hidden');
                destPhone.required = false;
                // On désactive les champs du mode simple pour qu'ils ne soient
                // pas envoyés en même temps que prefixe[]/phone[] (sinon les
                // deux jeux de champs entreraient en conflit côté serveur).
                destPhone.disabled = true;
                destPrefixe.disabled = true;

                if (multiRows.children.length === 0) {
                    addRecipientRow();
                    addRecipientRow();
                }

                multiRows.querySelectorAll('select, input').forEach(el => { el.disabled = false; });
            } else {
                singleRecipient.classList.remove('hidden');
                multiRecipients.classList.add('hidden');
                destPhone.required = (currentOperation === 'transfer');
                destPhone.disabled = false;
                destPrefixe.disabled = false;

                multiRows.querySelectorAll('select, input').forEach(el => { el.disabled = true; });
            }

            // Réapplique le libellé montant + l'action du formulaire pour l'état courant.
            if (currentOperation === 'transfer') {
                setOperation('transfer');
            }
        });

        // Initialize default state
        setOperation('transfer');

        // Quick-amount shortcuts.
        document.querySelectorAll('.quick-amount').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('montantInput').value = btn.dataset.amount;
            });
        });
        document.getElementById('btn-max').addEventListener('click', () => {
            document.getElementById('montantInput').value = Math.max(0, Math.floor(soldeDisponible));
        });

        // Chiffres uniquement, 7 chiffres pour la suite (le préfixe est choisi
        // séparément dans le select ; préfixe + suite = 10 chiffres au total,
        // jamais 10 chiffres après le préfixe).
        document.getElementById('destPhone').addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, SUITE_LENGTH);
        });

        // NOTE: the form submits normally to the server (depot/retrait/transfert
        // controllers), which validates the amount/solde and redirects back to
        // the dashboard with a flash message. There is no client-side fake
        // "success" animation here anymore: the previous version called
        // e.preventDefault() and only ever showed a fake success state without
        // ever sending the transaction to the server.
    </script>


<?= $this->endSection() ?>