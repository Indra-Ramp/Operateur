<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>MobileMoney | Client Dashboard</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=JetBrains+Mono:wght@100..900&display=swap" rel="stylesheet"/>
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
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .smoky-emerald-shadow {
            box-shadow: 0 4px 6px -1px rgba(6, 78, 59, 0.05);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #10b981;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-surface font-body-md text-on-surface overflow-x-hidden">
<!-- TopNavBar -->
<header class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-container-padding h-16 bg-surface dark:bg-inverse-surface border-b border-outline-variant dark:border-outline shadow-sm">
<div class="flex items-center gap-md">
<img alt="MobileMoney Logo" class="h-8 w-8 object-contain rounded-md" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCw-BYcdHzJowxiNj_aCC7g4NtB8HRtBtUMs9e57GU5sZwkYMVAuV6n19U3JGHbhHUl309LJWPsW87Gx_rt-oSRD26fRqxhJmreG3o2yOm2LUf2EiG7hEIg7ZjHlJYsC-1lBtw0Ltpo3hyuaf_iB65v3pJZVJMaU0SSfhEr4ly61WrX0-W3K3ed70wR1TGE_rt1AfYjWeWluntHIJs-hoDP8zGiAvXAZtEMqf2N2NCBTt1oMaQsGkinGcqjgzHbJzC1kRvriRjG3RU"/>
<span class="font-headline-md text-headline-md font-bold text-primary dark:text-primary-fixed-dim">MobileMoney</span>
</div>
<nav class="hidden md:flex gap-xl h-full">
<a class="flex items-center h-full text-primary dark:text-primary-fixed-dim font-bold border-b-2 border-primary transition-colors" href="/client/dashboard">Dashboard</a>
<a class="flex items-center h-full text-on-surface-variant dark:text-on-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant transition-colors px-sm" href="/client/transactions">Transactions</a>
<a class="flex items-center h-full text-on-surface-variant dark:text-on-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant transition-colors px-sm" href="#">Cards</a>
<a class="flex items-center h-full text-on-surface-variant dark:text-on-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant transition-colors px-sm" href="#">Settings</a>
</nav>
<div class="flex items-center gap-md">
<button class="p-base rounded-full hover:bg-surface-container-high transition-colors">
<span class="material-symbols-outlined text-on-surface-variant" data-icon="notifications">notifications</span>
</button>
<button class="p-base rounded-full hover:bg-surface-container-high transition-colors">
<span class="material-symbols-outlined text-on-surface-variant" data-icon="help">help</span>
</button>
<div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-white font-bold text-xs">
                <?= esc(strtoupper(substr($compte['tel'], -2))) ?>
            </div>
<a class="text-on-surface-variant font-medium text-body-md hover:text-primary transition-colors" href="/client/logout">Logout</a>
</div>
</header>
<main class="pt-24 pb-12 px-container-padding max-w-7xl mx-auto">
<?php if (session()->getFlashdata('success')): ?>
<div class="mb-lg rounded-lg border border-primary text-primary bg-primary/10 px-md py-sm font-medium"><?= esc(session()->getFlashdata('success')) ?></div>
<?php elseif (session()->getFlashdata('error')): ?>
<div class="mb-lg rounded-lg border border-error text-error bg-error/10 px-md py-sm font-medium"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif ?>
<!-- Welcome Header -->
<div class="mb-lg">
<h1 class="font-display text-display text-on-surface">Bienvenue, <?= esc($compte['tel']) ?></h1>
<p class="text-on-surface-variant font-body-lg">Voici un aperçu de votre compte aujourd'hui.</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-lg items-start">
<!-- Account Summary Card (Bento Row 1) -->
<div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-lg">
<div class="bg-primary-container p-lg rounded-xl smoky-emerald-shadow flex flex-col justify-between text-white min-h-[220px] relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
<div class="absolute -right-12 -top-12 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
<div>
<div class="flex justify-between items-start mb-sm">
<p class="font-label-md text-label-md opacity-80 uppercase tracking-wider">Current Balance</p>
<span class="material-symbols-outlined text-white/50" data-icon="account_balance_wallet">account_balance_wallet</span>
</div>
<h2 class="font-display text-[42px] leading-tight font-bold"><?= number_format($soldeCompte, 2, ',', ' '); ?> <span class="text-xl font-normal">Ar</span></h2>
</div>
<div class="flex justify-between items-end border-t border-white/20 pt-md">
<div>
<p class="text-xs opacity-70">Numéro de compte</p>
<p class="font-bold text-body-lg">#<?= esc($compte['id']) ?></p>
</div>
<div class="text-right">
<p class="text-xs opacity-70">Phone Number</p>
<p class="font-bold text-body-lg"><?= esc($compte['tel']) ?></p>
</div>
</div>
</div>
<!-- Action Cards -->
<div class="grid grid-cols-2 gap-md">
<a href="/client/transactions" class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl smoky-emerald-shadow flex flex-col items-center justify-center gap-sm hover:border-primary transition-all group">
<div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-on-secondary-container" data-icon="send">send</span>
</div>
<span class="font-bold text-on-surface">Transfer</span>
</a>
<a href="/client/transactions" class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl smoky-emerald-shadow flex flex-col items-center justify-center gap-sm hover:border-primary transition-all group">
<div class="w-12 h-12 rounded-full bg-tertiary-container/30 flex items-center justify-center group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-tertiary" data-icon="add_card">add_card</span>
</div>
<span class="font-bold text-on-surface">Deposit</span>
</a>
<a href="/client/transactions" class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl smoky-emerald-shadow flex flex-col items-center justify-center gap-sm hover:border-primary transition-all group">
<div class="w-12 h-12 rounded-full bg-error-container/30 flex items-center justify-center group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-error" data-icon="outbox">outbox</span>
</div>
<span class="font-bold text-on-surface">Withdraw</span>
</a>
<!-- <button class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl smoky-emerald-shadow flex flex-col items-center justify-center gap-sm hover:border-primary transition-all group">
<div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-on-surface-variant" data-icon="receipt_long">receipt_long</span>
</div>
<span class="font-bold text-on-surface">Bills</span>
</button> -->
</div> 

</div>
<!-- Quick Stats / Promotions (Bento Sidebar) -->
<!-- <div class="lg:col-span-4 bg-surface-container-low p-lg rounded-xl border border-outline-variant min-h-[220px]">
<h3 class="font-headline-md text-headline-md mb-md">Insights</h3>
<div class="space-y-md">
<div class="flex items-center justify-between p-sm bg-surface-container-lowest rounded-lg border border-outline-variant/30">
<div class="flex items-center gap-sm">
<span class="material-symbols-outlined text-primary" data-icon="trending_up">trending_up</span>
<span class="font-medium">Total Savings</span>
</div>
<span class="font-bold text-primary">+12.5%</span>
</div>
<div class="flex items-center justify-between p-sm bg-surface-container-lowest rounded-lg border border-outline-variant/30">
<div class="flex items-center gap-sm">
<span class="material-symbols-outlined text-on-surface-variant" data-icon="history_edu">history_edu</span>
<span class="font-medium">Pending Approvals</span>
</div>
<span class="font-bold text-on-surface-variant">2</span>
</div>
</div>
<div class="mt-lg p-md bg-tertiary-fixed rounded-xl border border-tertiary/20 flex flex-col gap-sm">
<p class="font-bold text-on-tertiary-fixed-variant">Earn 5% Cashback</p>
<p class="text-xs text-on-tertiary-fixed opacity-80 leading-relaxed">Refer a friend today and get an instant reward in your wallet.</p>
<button class="mt-sm bg-tertiary text-white py-sm px-md rounded-lg font-bold text-sm hover:brightness-110 transition-all">Invite Friend</button>
</div>
</div> -->
<!-- Transaction History Table -->
<div class="lg:col-span-12 mt-lg bg-surface-container-lowest p-lg rounded-xl border border-outline-variant smoky-emerald-shadow overflow-hidden">
<div class="flex flex-col md:flex-row md:items-center justify-between gap-md mb-lg">
<h3 class="font-headline-md text-headline-md">Transaction History</h3>
<div class="flex flex-wrap items-center gap-sm">
<!-- Date Range Filter -->
<div class="relative">
<input class="bg-surface border border-outline-variant rounded-lg px-md py-sm text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none" type="date"/>
</div>
<!-- Operation Type Dropdown -->
<div class="relative">
<select class="bg-surface border border-outline-variant rounded-lg pl-md pr-xl py-sm text-sm appearance-none focus:ring-2 focus:ring-primary focus:border-primary outline-none cursor-pointer">
<option value="">All Operations</option>
<option value="Transfer">Transfer</option>
<option value="Deposit">Deposit</option>
<option value="Withdrawal">Withdrawal</option>
</select>
<span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant" data-icon="expand_more">expand_more</span>
</div>
<button class="bg-primary text-white px-md py-sm rounded-lg font-bold text-sm flex items-center gap-xs hover:scale-95 duration-150">
<span class="material-symbols-outlined text-sm" data-icon="download">download</span>
                            Export
                        </button>
</div>
</div>
<div class="overflow-x-auto custom-scrollbar">
<table class="w-full text-left border-collapse">
<thead class="bg-surface-container-low">
<tr>
<th class="px-md py-md font-label-md text-label-md text-on-surface-variant uppercase border-b border-outline-variant">Date</th>
<th class="px-md py-md font-label-md text-label-md text-on-surface-variant uppercase border-b border-outline-variant">Type</th>
<th class="px-md py-md font-label-md text-label-md text-on-surface-variant uppercase border-b border-outline-variant">Recipient / Sender</th>
<th class="px-md py-md font-label-md text-label-md text-on-surface-variant uppercase border-b border-outline-variant">Amount</th>
<th class="px-md py-md font-label-md text-label-md text-on-surface-variant uppercase border-b border-outline-variant">Status</th>
<th class="px-md py-md font-label-md text-label-md text-on-surface-variant uppercase border-b border-outline-variant text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/30">
<?php if (! empty($operations)): ?>
    <?php $idCompte = (int) $compte['id']; ?>
    <?php foreach ($operations as $operation): ?>
        <?php
            $type = $operation['type_label'] ?? '';
            $isOutgoing = ((int) $operation['id_compte1'] === $idCompte);
            $amount = number_format($operation['montant'], 0, ',', ' ');

            switch ($type) {
                case 'depot':
                    $icon = 'add_card';
                    $participant = 'Dépôt sur votre compte';
                    $credit = true;
                    break;
                case 'retrait':
                    $icon = 'outbox';
                    $participant = 'Retrait (agent)';
                    $credit = false;
                    break;
                case 'transfert':
                    $icon = $isOutgoing ? 'arrow_outward' : 'arrow_downward';
                    $participant = $isOutgoing
                        ? 'Vers ' . esc($operation['tel_compte2'] ?? 'N/A')
                        : 'De ' . esc($operation['tel_compte1'] ?? 'N/A');
                    $credit = ! $isOutgoing;
                    break;
                default:
                    $icon = 'swap_horiz';
                    $participant = 'N/A';
                    $credit = ! $isOutgoing;
            }

            $amountLabel = ($credit ? '+ ' : '- ') . $amount . ' Ar';
            $statusClass = $credit ? 'bg-primary/10 text-primary' : 'bg-error-container text-error';
            $statusText  = $credit ? 'Crédit' : 'Débit';
        ?>
        <tr class="hover:bg-surface-container-low transition-colors">
            <td class="px-md py-md text-body-md whitespace-nowrap"><?= esc($operation['date_track']); ?></td>
            <td class="px-md py-md text-body-md">
                <span class="flex items-center gap-sm">
                    <span class="material-symbols-outlined text-primary" data-icon="<?= $icon ?>"><?= $icon ?></span>
                    <?= esc(ucfirst($type)) ?>
                </span>
            </td>
            <td class="px-md py-md text-body-md"><?= $participant ?></td>
            <td class="px-md py-md font-bold <?= $credit ? 'text-primary' : 'text-on-surface' ?>"><?= $amountLabel ?></td>
            <td class="px-md py-md">
                <span class="<?= $statusClass ?> px-sm py-1 rounded-full text-xs font-bold uppercase"><?= $statusText ?></span>
            </td>
            <td class="px-md py-md text-right">
                <button class="text-on-surface-variant hover:text-primary"><span class="material-symbols-outlined" data-icon="more_vert">more_vert</span></button>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td class="px-md py-md text-body-md text-on-surface-variant" colspan="6">Aucune opération trouvée pour ce compte.</td>
    </tr>
<?php endif; ?>
</tbody>
</table>
</div>
<!-- Pagination -->
<?php if ($totalOperations > 0): ?>
<div class="flex flex-col md:flex-row md:items-center justify-between gap-md mt-lg pt-md border-t border-outline-variant">
<?php
    $firstItem = ($currentPage - 1) * $perPage + 1;
    $lastItem  = min($totalOperations, $currentPage * $perPage);
?>
<p class="text-sm text-on-surface-variant">Affichage de <span class="font-bold"><?= $firstItem ?>-<?= $lastItem ?></span> sur <span class="font-bold"><?= $totalOperations ?></span> transactions</p>
<div class="flex items-center gap-sm">
<?php if ($currentPage > 1): ?>
<a href="?page=<?= $currentPage - 1 ?>" class="p-sm rounded-lg border border-outline-variant hover:bg-surface-container-high transition-colors">
<span class="material-symbols-outlined text-on-surface-variant" data-icon="chevron_left">chevron_left</span>
</a>
<?php else: ?>
<span class="p-sm rounded-lg border border-outline-variant opacity-50">
<span class="material-symbols-outlined text-on-surface-variant" data-icon="chevron_left">chevron_left</span>
</span>
<?php endif; ?>
<div class="flex items-center gap-1">
<?php
    // Build a compact page list: always show first, last, current and its
    // neighbours, and collapse the rest behind an ellipsis.
    $pagesToShow = [];
    for ($p = 1; $p <= $totalPages; $p++) {
        if ($p === 1 || $p === $totalPages || abs($p - $currentPage) <= 1) {
            $pagesToShow[] = $p;
        }
    }
?>
<?php $previousPage = 0; ?>
<?php foreach ($pagesToShow as $p): ?>
    <?php if ($p - $previousPage > 1): ?>
        <span class="px-sm text-on-surface-variant">...</span>
    <?php endif; ?>
    <?php if ($p === $currentPage): ?>
        <span class="w-10 h-10 flex items-center justify-center rounded-full bg-primary text-white font-bold text-sm shadow-md"><?= $p ?></span>
    <?php else: ?>
        <a href="?page=<?= $p ?>" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container-high font-bold text-sm transition-colors"><?= $p ?></a>
    <?php endif; ?>
    <?php $previousPage = $p; ?>
<?php endforeach; ?>
</div>
<?php if ($currentPage < $totalPages): ?>
<a href="?page=<?= $currentPage + 1 ?>" class="p-sm rounded-lg border border-outline-variant hover:bg-surface-container-high transition-colors">
<span class="material-symbols-outlined text-on-surface-variant" data-icon="chevron_right">chevron_right</span>
</a>
<?php else: ?>
<span class="p-sm rounded-lg border border-outline-variant opacity-50">
<span class="material-symbols-outlined text-on-surface-variant" data-icon="chevron_right">chevron_right</span>
</span>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
</div>
</div>
</main>
<!-- Floating Action Button (Only on Mobile-ish context) -->
<a href="/client/transactions" class="fixed bottom-lg right-lg bg-primary text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center hover:scale-110 active:scale-95 transition-all lg:hidden">
<span class="material-symbols-outlined" data-icon="add">add</span>
</a>
<script>
        // Simple micro-interactions for the filter dropdowns and interactive elements
        document.querySelectorAll('select, input[type="date"]').forEach(el => {
            el.addEventListener('change', () => {
                console.log('Filtering logic would execute here...');
                // Visual feedback only for demo
                const tbody = document.querySelector('tbody');
                tbody.style.opacity = '0.5';
                setTimeout(() => {
                    tbody.style.opacity = '1';
                }, 300);
            });
        });
    </script>
</body></html>