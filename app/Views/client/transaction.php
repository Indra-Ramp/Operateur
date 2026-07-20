<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>MobileMoney - Transaction</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .step-transition {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(229, 231, 235, 0.5);
    }
</style>
</head>
<body class="bg-surface text-on-surface font-body-md min-h-screen">
<header class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-container-padding h-16 bg-surface dark:bg-inverse-surface border-b border-outline-variant dark:border-outline shadow-sm">
    <div class="flex items-center gap-sm">
        <span class="material-symbols-outlined text-primary font-bold text-headline-md">account_balance_wallet</span>
        <span class="font-headline-md text-headline-md font-bold text-primary dark:text-primary-fixed-dim">MobileMoney</span>
    </div>
    <div class="flex items-center gap-md">
        <a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="/client/dashboard">Dashboard</a>
        <a class="text-primary font-label-md hover:underline" href="/client/logout">Logout</a>
    </div>
</header>
<main class="pt-24 pb-12 px-container-padding max-w-4xl mx-auto">
    <div class="mb-xl text-center md:text-left">
        <h1 class="font-display text-display text-on-background mb-base">Transactions</h1>
        <p class="text-on-surface-variant font-body-lg">Envoyez, déposez ou retirez de l'argent en toute simplicité.</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
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
                    <div class="space-y-md">
                        <label class="block font-headline-md text-on-surface">1. Select Operation</label>
                        <div class="grid grid-cols-3 gap-md">
                            <button class="flex flex-col items-center justify-center p-lg rounded-xl border-2 border-outline-variant hover:border-primary-container transition-all group" id="btn-transfer" onclick="setOperation('transfer')" type="button">
                                <span class="material-symbols-outlined text-primary mb-sm text-[32px]">swap_horiz</span>
                                <span class="font-label-md">Transfer</span>
                            </button>
                            <button class="flex flex-col items-center justify-center p-lg rounded-xl border-2 border-outline-variant hover:border-primary-container transition-all group" id="btn-deposit" onclick="setOperation('deposit')" type="button">
                                <span class="material-symbols-outlined text-primary mb-sm text-[32px]">account_balance_wallet</span>
                                <span class="font-label-md">Deposit</span>
                            </button>
                            <button class="flex flex-col items-center justify-center p-lg rounded-xl border-2 border-outline-variant hover:border-primary-container transition-all group" id="btn-withdrawal" onclick="setOperation('withdrawal')" type="button">
                                <span class="material-symbols-outlined text-primary mb-sm text-[32px]">atm</span>
                                <span class="font-label-md">Retrait</span>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-md hidden opacity-0 transition-opacity duration-300" id="recipientSection">
                        <div class="flex justify-between items-center">
                            <label class="block font-headline-md text-on-surface">2. Recipient Details</label>
                            <label class="flex items-center gap-xs cursor-pointer select-none">
                                <input class="rounded border-outline-variant text-primary focus:ring-primary" id="multiToggle" type="checkbox"/>
                                <span class="font-label-md text-on-surface-variant">Envoi multiple</span>
                            </label>
                        </div>
                        <div id="singleRecipient">
                            <div class="flex gap-sm">
                                <div class="relative group w-1/3">
                                    <select class="h-12 w-full bg-surface-container-low px-md pr-sm border border-outline-variant text-on-surface font-body-md focus:ring-0 focus:outline-none cursor-pointer appearance-none rounded-lg" name="prefixe">
                                        <?php foreach ($prefixes as $p): ?>
                                            <option value="<?= esc($p['label']) ?>">+<?= esc($p['label']) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[18px]">expand_more</span>
                                </div>
                                <div class="relative flex-1">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-md pointer-events-none">
                                        <span class="material-symbols-outlined text-outline">phone_iphone</span>
                                    </div>
                                    <input class="w-full pl-xl pr-md py-md bg-surface-container-low border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" name="phone" id="destPhone" placeholder="0000000" type="tel" inputmode="numeric" maxlength="7" />
                                </div>
                            </div>
                            <p class="font-label-md text-on-surface-variant flex items-center gap-xs">
                                <span class="material-symbols-outlined text-sm">info</span>
                                Sélectionnez le préfixe puis saisissez les 7 chiffres suivants du destinataire (10 chiffres au total, pas 10 après le préfixe).
                            </p>
                        </div>
                        <div class="hidden space-y-sm" id="multiRecipients">
                            <div class="space-y-sm" id="multiRows"></div>
                            <button class="flex items-center gap-xs px-md py-sm rounded-lg border border-dashed border-outline-variant text-primary hover:bg-primary-container/20 transition-colors font-label-md" id="addRecipientBtn" type="button">
                                <span class="material-symbols-outlined text-[18px]">add</span>
                                Ajouter un destinataire
                            </button>
                            <p class="font-label-md text-on-surface-variant flex items-center gap-xs">
                                <span class="material-symbols-outlined text-sm">info</span>
                                Le montant total saisi ci-dessous sera divisé équitablement entre tous les destinataires.
                            </p>
                        </div>
                    </div>
                    <div class="space-y-md" id="amountSection">
                        <label class="block font-headline-md text-on-surface" id="amountLabel">2. Transaction Amount</label>
                        <div class="relative flex items-center">
                            <div class="flex items-center justify-center px-lg h-full bg-surface-container-high border border-outline-variant border-r-0 rounded-l-lg font-label-md text-on-surface-variant">Ar</div>
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
                            <span class="font-label-md text-on-surface-variant">Inclure les frais de retrait dans le montant envoyé <span class="text-on-surface-variant/70">(le destinataire reçoit alors le montant saisi moins les frais, au lieu de payer le montant + frais en plus)</span></span>
                        </label>
                    </div>
                    <div class="pt-lg border-t border-outline-variant">
                        <button class="w-full bg-primary hover:bg-on-primary-container text-white py-lg rounded-xl font-headline-md shadow-md hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-sm" type="submit">
                            Confirm Transaction
                            <span class="material-symbols-outlined">lock</span>
                        </button>
                        <p class="mt-md text-center text-on-surface-variant font-label-md">Vérifiez les informations avant de valider</p>
                    </div>
                </form>
            </div>
        </div>
        <div class="lg:col-span-4 space-y-lg">
            <div class="bg-primary text-on-primary p-lg rounded-xl shadow-md relative overflow-hidden">
                <div class="relative z-10">
                    <p class="font-label-md opacity-80 mb-xs">Solde disponible</p>
                    <h2 class="font-display text-display"><?= number_format($soldeCompte, 0, ',', ' ') ?> <span class="text-xl font-normal">Ar</span></h2>
                    <div class="mt-lg flex items-center gap-xs">
                        <span class="material-symbols-outlined text-sm">phone_iphone</span>
                        <span class="font-label-md text-primary-fixed-dim"><?= esc($compte['tel'] ?? '') ?></span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-10">
                    <span class="material-symbols-outlined text-[120px]">account_balance</span>
                </div>
            </div>
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
                                    <span class="material-symbols-outlined <?= $credit ? 'text-on-primary-container' : 'text-on-secondary-container' ?>"><?= $credit ? 'arrow_downward' : 'arrow_outward' ?></span>
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
            <div class="bg-tertiary-container text-on-tertiary-container p-lg rounded-xl border border-tertiary">
                <div class="flex items-start gap-md">
                    <span class="material-symbols-outlined mt-base">verified_user</span>
                    <div>
                        <h4 class="font-headline-md mb-xs">Security Check</h4>
                        <p class="text-sm opacity-90">Always verify the recipient's phone number before confirming. MobileMoney will never ask for your PIN via SMS.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    const soldeDisponible = <?= (float) $soldeCompte ?>;
    const SUITE_LENGTH = 7;
    const prefixOptionsHtml = `<?= implode('', array_map(
        fn ($p) => '<option value="' . esc($p['label'], 'attr') . '">+' . esc($p['label']) . '</option>',
        $prefixes
    )) ?>`;

    let currentOperation = 'transfer';

    function setOperation(type) {
        currentOperation = type;
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
            destPhone.required = !multiToggle.checked;
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
            fraisOptionWrapper.classList.add('hidden');
        }
    }

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

        if (currentOperation === 'transfer') {
            setOperation('transfer');
        }
    });

    setOperation('transfer');

    document.querySelectorAll('.quick-amount').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('montantInput').value = btn.dataset.amount;
        });
    });

    document.getElementById('btn-max').addEventListener('click', () => {
        document.getElementById('montantInput').value = Math.max(0, Math.floor(soldeDisponible));
    });

    document.getElementById('destPhone').addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, SUITE_LENGTH);
    });
</script>
</body>
</html>


Consulté un fichier, fichier modifié
Consulté un fichier, fichier modifié
Bien vu — même problème potentiel dans OperationController. Vérifions.


Relire OperationController final
Relire OperationController final
Même bug ici aux lignes 182 et 188 — je corrige.


Fichier modifié, consulté un fichier
Fichier modifié, consulté un fichier
Bien structuré, syntaxe cohérente. Vérifions maintenant Routes.php et les deux vues complètes.


Vérifier les routes finales
Vérifier les routes finales
Vérifions le fichier login.php complet pour être sûr qu'il est cohérent, puis balançage des accolades/PHP-tags dans transaction.php via un script Python simple.


A exécuté une commande, consulté un fichier
A exécuté une commande, consulté un fichier
Bien structuré. Vérifions maintenant le script JS complet final.


Identified form submission conflict and reconsidered implementation approach
Identified form submission conflict and reconsidered implementation approach
Petit souci important : les champs prefixe/phone (mode simple) resteraient soumis en même temps que prefixe[]/phone[] (mode multiple), ce qui casserait le POST. Je corrige avec disabled pour exclure les champs inactifs du formulaire.


Fichier modifié, a exécuté une commande
Fichier modifié, a exécuté une commande
Parfait, tout est propre. Voici un récapitulatif de ce qui a été fait, uniquement côté client.

Bug bloquant corrigé
App\Libraries\PhoneHelper était référencé dans AuthController et OperationController mais n'existait pas du tout dans le zip → le login plantait. Comme demandé, je ne l'ai pas recréé comme classe séparée : j'ai mis la validation directement dans BaseController::validatePhone(), partagée par les deux contrôleurs.

Règle de validation du téléphone (comme décrit)
Préfixe : exactement 3 chiffres (ex : 032), doit être un préfixe connu (table prefixe).
Suite : exactement 7 chiffres (pas 10 après le préfixe).
Numéro complet = préfixe + suite = 10 chiffres au total.
Messages d'erreur clairs en français, affichés via session()->getFlashdata('errors') (login) / 'error' (transaction).
Le champ téléphone du login et du transfert n'accepte plus que 7 chiffres maintenant (compteur, maxlength, hint texte tous corrigés — avant il y avait une incohérence : préfixe en dropdown + champ à 10 chiffres en plus).

Nouvelles fonctionnalités
Frais inclus dans l'envoi — case à cocher sur le transfert : si cochée, l'expéditeur est débité exactement du montant saisi et le destinataire reçoit montant - frais ; sinon (comportement par défaut, inchangé), l'expéditeur paie montant + frais et le destinataire reçoit le montant plein.
Envoi multiple — toggle "Envoi multiple" qui affiche une liste de destinataires (ajout/suppression de lignes), le montant total saisi étant réparti équitablement (à l'Ariary près, sans perte d'arrondi) entre eux. Chaque part est traitée comme un transfert individuel (avec ses propres frais), le tout dans une transaction DB (tout ou rien).
Fichiers modifiés (côté client uniquement)
app/Controllers/BaseController.php — ajout de validatePhone()
app/Controllers/AuthController.php — retrait de PhoneHelper
app/Controllers/OperationController.php — retrait de PhoneHelper, option frais, nouvelle action transfertMultiple()
app/Models/OperationModel.php — transfert() avec option frais, nouvelle méthode transfertMultiple()
app/Config/Routes.php — route POST client/transfert-multiple
app/Views/client/login.php — champ téléphone à 7 chiffres
app/Views/client/transaction.php — UI envoi multiple + case frais inclus
⚠️ Je n'ai pas pu exécuter PHP dans ce conteneur (pas de réseau pour l'installer), donc je n'ai pas pu lancer de test réel de l'app — j'ai relu le code ligne par ligne et vérifié l'équilibre des balises/accolades, mais teste-le de ton côté avant de committer.

donne moi les fichiers corriges


Orchestrated file organization pour téléchargement direct
Orchestrated file organization pour téléchargement direct
Les 7 fichiers modifiés (arborescence identique à ton projet, à remplacer directement) :

app/Controllers/BaseController.php
app/Controllers/AuthController.php
app/Controllers/OperationController.php
app/Models/OperationModel.php
app/Config/Routes.php
app/Views/client/login.php
app/Views/client/transaction.php

Basecontroller
Code · PHP 

Authcontroller
Code · PHP 

Operationcontroller
Code · PHP 

Operationmodel
Code · PHP 

Routes
Code · PHP 

Login
Code · PHP 

Transaction
Code · PHP 
n'utilise pas validate phone, enleve ca dans base controller ne complique pas les choses, juste un code court , n'utilise pas baseController


Décidé de simplifier en supprimant validation partagée, code local uniquement
Décidé de simplifier en supprimant validation partagée, code local uniquement
Maintenant OperationController :


Utiliser une validation locale courte dans OperationController
Utiliser une validation locale courte dans OperationController
Vérification finale et re-livraison des fichiers.


Exécuté 2 commandes, lu un fichier
Exécuté 2 commandes, lu un fichier
BaseController est revenu à sa version d'origine (aucune modif). La validation (préfixe 3 chiffres + suite 7 chiffres) est maintenant une petite méthode privée checkPhone() dupliquée directement dans AuthController et OperationController — plus courte, sans passer par une classe partagée. Les autres fichiers déjà livrés (OperationModel.php, Routes.php, login.php, transaction.php) restent inchangés et valables.


Basecontroller
Code · PHP 

Authcontroller
Code · PHP 

Operationcontroller
Code · PHP 
pour chaque arguments des fonctions, ne les instancier pas(exemple $idcompte mais pas int $idcompte), et assure toi que les frais sorties sont sorties du compte 1 du table operateur et stock le frais temporairement

Et faites moins de fonctions, c'est un travail pour 2 heures


Revoir AuthController avant réécriture
Revoir AuthController avant réécriture


Vous n’avez plus de messages gratuits jusqu’à 19:30.




Claude est une IA et peut faire des erreurs. Veuillez vérifier les réponses.
Transaction · PHP
<!DOCTYPE html>
 
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>MobileMoney - New Transaction</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=JetBrains+Mono:wght@100..900&display=swap" rel="stylesheet"/>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .step-transition {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(229, 231, 235, 0.5);
        }
    </style>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "primary-fixed-dim": "#4edea3",
                      "on-tertiary": "#ffffff",
                      "tertiary": "#2b6954",
                      "on-primary-fixed": "#002113",
                      "surface-container-highest": "#e1e3e4",
                      "on-primary-container": "#00422b",
                      "surface-container-high": "#e7e8e9",
                      "on-surface-variant": "#3c4a42",
                      "surface-container": "#edeeef",
                      "inverse-on-surface": "#f0f1f2",
                      "on-secondary-fixed-variant": "#005137",
                      "tertiary-fixed-dim": "#95d3ba",
                      "inverse-primary": "#4edea3",
                      "on-secondary": "#ffffff",
                      "on-error-container": "#93000a",
                      "outline-variant": "#bbcabf",
                      "on-background": "#191c1d",
                      "on-tertiary-fixed": "#002117",
                      "surface-variant": "#e1e3e4",
                      "surface-dim": "#d9dadb",
                      "error": "#ba1a1a",
                      "inverse-surface": "#2e3132",
                      "surface": "#f8f9fa",
                      "primary": "#006c49",
                      "primary-container": "#10b981",
                      "surface-container-low": "#f3f4f5",
                      "tertiary-fixed": "#b0f0d6",
                      "on-error": "#ffffff",
                      "on-primary-fixed-variant": "#005236",
                      "secondary": "#006c4a",
                      "secondary-fixed": "#85f8c4",
                      "on-surface": "#191c1d",
                      "secondary-fixed-dim": "#68dba9",
                      "tertiary-container": "#71af97",
                      "on-tertiary-fixed-variant": "#0b513d",
                      "secondary-container": "#82f5c1",
                      "on-primary": "#ffffff",
                      "primary-fixed": "#6ffbbe",
                      "on-tertiary-container": "#004231",
                      "error-container": "#ffdad6",
                      "background": "#f8f9fa",
                      "surface-tint": "#006c49",
                      "outline": "#6c7a71",
                      "surface-bright": "#f8f9fa",
                      "on-secondary-fixed": "#002114",
                      "surface-container-lowest": "#ffffff",
                      "on-secondary-container": "#00714e"
              },
              "borderRadius": {
                      "DEFAULT": "0.25rem",
                      "lg": "0.5rem",
                      "xl": "0.75rem",
                      "full": "9999px"
              },
              "spacing": {
                      "container-padding": "24px",
                      "gutter": "16px",
                      "base": "4px",
                      "lg": "24px",
                      "xs": "4px",
                      "sm": "8px",
                      "xl": "40px",
                      "md": "16px"
              },
              "fontFamily": {
                      "label-md": ["JetBrains Mono"],
                      "body-md": ["Inter"],
                      "headline-lg": ["Inter"],
                      "body-lg": ["Inter"],
                      "headline-md": ["Inter"],
                      "display": ["Inter"],
                      "headline-lg-mobile": ["Inter"]
              },
              "fontSize": {
                      "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                      "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                      "headline-lg": ["28px", {"lineHeight": "36px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                      "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                      "headline-md": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                      "display": ["36px", {"lineHeight": "44px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                      "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "600"}]
              }
            },
          },
        }
    </script>
</head>
<body class="bg-surface text-on-surface font-body-md min-h-screen">
<!-- TopNavBar -->
<header class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-container-padding h-16 bg-surface dark:bg-inverse-surface border-b border-outline-variant dark:border-outline shadow-sm">
<div class="flex items-center gap-sm">
<span class="material-symbols-outlined text-primary font-bold text-headline-md" data-icon="account_balance_wallet">account_balance_wallet</span>
<span class="font-headline-md text-headline-md font-bold text-primary dark:text-primary-fixed-dim">MobileMoney</span>
</div>
<div class="flex items-center gap-md">
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="/client/dashboard">Dashboard</a>
<a class="text-primary font-label-md hover:underline" href="/client/logout">Logout</a>
</div>
</header>
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
                <option value="<?= esc($p['label']) ?>">+<?= esc($p['label']) ?></option>
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
<div class="bg-tertiary-container text-on-tertiary-container p-lg rounded-xl border border-tertiary">
<div class="flex items-start gap-md">
<span class="material-symbols-outlined mt-base" data-icon="verified_user">verified_user</span>
<div>
<h4 class="font-headline-md mb-xs">Security Check</h4>
<p class="text-sm opacity-90">Always verify the recipient's phone number before confirming. MobileMoney will never ask for your PIN via SMS.</p>
</div>
</div>
</div>
</div>
</div>
</main>
<script>
        const soldeDisponible = <?= (float) $soldeCompte ?>;
        const SUITE_LENGTH = 7; // longueur de la suite après le préfixe (préfixe 3 + suite 7 = 10)
        // Options du select préfixe, générées côté serveur, réutilisées pour
        // chaque ligne destinataire ajoutée dynamiquement en mode multiple.
        const prefixOptionsHtml = `<?= implode('', array_map(
            fn ($p) => '<option value="' . esc($p['label'], 'attr') . '">+' . esc($p['label']) . '</option>',
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
                fraisOptionWrapper.classList.add('hidden');
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
</body></html>

