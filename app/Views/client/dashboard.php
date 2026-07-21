<?= $this->extend('client/navbar') ?>
<?= $this->section('container') ?>

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
<div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-lg">
<div class="bg-primary-container p-lg rounded-xl smoky-emerald-shadow flex flex-col justify-between text-white min-h-[220px] relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
<div class="absolute -right-12 -top-12 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
<div>
<div class="flex justify-between items-start mb-sm">
<p class="font-label-md text-label-md opacity-80 uppercase tracking-wider">Current Epargne</p>
<span class="material-symbols-outlined text-white/50" data-icon="account_balance_wallet">account_balance_wallet</span>
</div>
<h2 class="font-display text-[42px] leading-tight font-bold"><?= number_format($epargne, 2, ',', ' '); ?> <span class="text-xl font-normal">Ar</span></h2>
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
<span class="font-bold text-on-surface">Transaction</span>
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
<!-- <div class="relative">
<input class="bg-surface border border-outline-variant rounded-lg px-md py-sm text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none" type="date"/>
</div> -->
<!-- Operation Type Dropdown -->
<!-- <div class="relative">
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
                        </button> -->
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
<!-- <th class="px-md py-md font-label-md text-label-md text-on-surface-variant uppercase border-b border-outline-variant text-right">Actions</th> -->
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/30">
<?php if (! empty($operations)): ?>
    <?php $idCompte = (int) $compte['id']; ?>
    <?php foreach ($operations as $operation): ?>
        <?php
            $type = $operation['type_label'] ?? '';
            $isOutgoing = ((int) $operation['id_compte1'] === $idCompte);
            $amount = number_format(($operation['montant'] + ($operation['frais'] ?? 0) + ($operation['commission'] ?? 0)), 0, ',', ' ');
        
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
            <!-- <td class="px-md py-md text-right">
                <button class="text-on-surface-variant hover:text-primary"><span class="material-symbols-outlined" data-icon="more_vert">more_vert</span></button>
            </td> -->
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
<?= $this->endSection() ?>