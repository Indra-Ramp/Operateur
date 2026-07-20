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
    <div class="rounded-lg border border-error text-error bg-error/10 px-md py-sm font-medium">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php elseif (session()->getFlashdata('success')): ?>
    <div class="rounded-lg border border-primary text-primary bg-primary/10 px-md py-sm font-medium">
        <?= session()->getFlashdata('success') ?>
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
<label class="block font-headline-md text-on-surface">2. Recipient Details</label>
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
        <input class="w-full pl-xl pr-md py-md bg-surface-container-low border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" name="phone" id="destPhone" placeholder="0000000000" type="tel" inputmode="numeric" maxlength="10" />
    </div>
</div>
<p class="font-label-md text-on-surface-variant flex items-center gap-xs">
<span class="material-symbols-outlined text-sm" data-icon="info">info</span>
Saisissez le préfixe et le numéro complet du destinataire (10 chiffres au total).
</p>
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

            if (type === 'transfer') {
                recipientSection.classList.remove('hidden');
                setTimeout(() => recipientSection.classList.remove('opacity-0'), 10);
                destPhone.required = true;
                amountLabel.innerText = '3. Transaction Amount';
                form.action = '/client/transfert';
                operationType.value = 'transfer';
            } else if (type === 'deposit') {
                recipientSection.classList.add('opacity-0');
                setTimeout(() => recipientSection.classList.add('hidden'), 300);
                destPhone.required = false;
                amountLabel.innerText = '2. Transaction Amount';
                form.action = '/client/depot';
                operationType.value = 'depot';
            } else {
                recipientSection.classList.add('opacity-0');
                setTimeout(() => recipientSection.classList.add('hidden'), 300);
                destPhone.required = false;
                amountLabel.innerText = '2. Transaction Amount';
                form.action = '/client/retrait';
                operationType.value = 'retrait';
            }
        }

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

        // Digits-only, 10-digit recipient phone (matches PhoneHelper server-side).
        document.getElementById('destPhone').addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 10);
        });

        // NOTE: the form submits normally to the server (depot/retrait/transfert
        // controllers), which validates the amount/solde and redirects back to
        // the dashboard with a flash message. There is no client-side fake
        // "success" animation here anymore: the previous version called
        // e.preventDefault() and only ever showed a fake success state without
        // ever sending the transaction to the server.
    </script>
</body></html>