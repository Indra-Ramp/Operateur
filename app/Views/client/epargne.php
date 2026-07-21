<?= $this->extend('client/navbar') ?>
<?= $this->section('container') ?>

<main class="relative z-10 w-full max-w-md">
<!-- Center Card Layout -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg md:p-xl login-card transition-all duration-500">
<!-- Brand Identity -->
<div class="flex flex-col items-center mb-xl">
<div class="w-20 h-20 mb-md">
<img alt="MobileMoney Logo" class="w-full h-full object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCw-BYcdHzJowxiNj_aCC7g4NtB8HRtBtUMs9e57GU5sZwkYMVAuV6n19U3JGHbhHUl309LJWPsW87Gx_rt-oSRD26fRqxhJmreG3o2yOm2LUf2EiG7hEIg7ZjHlJYsC-1lBtw0Ltpo3hyuaf_iB65v3pJZVJMaU0SSfhEr4ly61WrX0-W3K3ed70wR1TGE_rt1AfYjWeWluntHIJs-hoDP8zGiAvXAZtEMqf2N2NCBTt1oMaQsGkinGcqjgzHbJzC1kRvriRjG3RU"/>
</div>
</div>
<!-- Login Form -->
<form class="space-y-md" method="post" action="/client/epargne">
<!-- Phone Number Group -->
<div class="space-y-sm">
<div class="flex justify-between items-center">
<label class="font-label-md text-label-md text-outline uppercase tracking-wider block" for="phone">Pourcentage epargne</label>
</div>
<div class="flex h-12 w-full rounded-lg border border-outline-variant bg-surface-container-lowest overflow-hidden transition-all duration-200 input-focus-ring">
<!-- Prefix Dropdown -->
<div class="relative group">
<span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[18px]">expand_more</span>
</div>
<!-- Number Input: seulement la suite (7 chiffres) qui vient après le préfixe -->
<input class="flex-1 px-md border-none focus:ring-0 text-on-surface placeholder:text-outline-variant font-body-lg bg-transparent" name="epargne" id="phone" placeholder="0" type="tel" inputmode="numeric" maxlength="7" value="<?= $compte['epargne'] ?>"/>
</div>
<p id="phoneHint" class="font-label-md text-label-md text-on-surface-variant">Saisissez votre pourcentage d'epargne.</p>
</div>
<!-- Password Input
<div class="space-y-sm">
<div class="flex justify-between items-center">
<label class="font-label-md text-label-md text-outline uppercase tracking-wider" for="pin">PIN Code</label>
<a class="font-label-md text-label-md text-primary hover:underline" href="#">Forgot PIN?</a>
</div>
<div class="relative">
<input class="w-full h-12 rounded-lg border border-outline-variant bg-surface-container-lowest px-md pr-12 focus:ring-2 focus:ring-primary-container focus:border-primary-container focus:outline-none text-on-surface placeholder:text-outline-variant transition-all font-label-md tracking-widest" id="pin" maxlength="4" placeholder="••••" type="password"/>
<button class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface transition-colors" type="button">
<span class="material-symbols-outlined">visibility</span>
</button>
</div>
</div> -->
<!-- Login Action -->
<button class="w-full h-12 bg-primary-container hover:bg-primary text-on-primary font-headline-md text-headline-md rounded-lg shadow-md hover:shadow-lg transform active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-sm mt-xl" type="submit">
<span>Modifier</span>
<span class="material-symbols-outlined">arrow_forward</span>
</button>
</form>
<!-- Quick Access / Security Notice -->
<div class="mt-xl pt-lg border-t border-outline-variant">
<div class="flex items-center gap-md text-on-surface-variant">
<div class="p-sm bg-surface-container rounded-full">
<span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">verified_user</span>
</div>
<div>
</div>
</div>
</div>
</div>
<!-- System Status Mini-Bar -->
<div class="mt-md flex justify-between items-center px-sm opacity-60">
<div class="flex items-center gap-xs">
<div class="w-1.5 h-1.5 rounded-full bg-[#10b981] animate-pulse"></div>
<span class="text-[11px] font-label-md">System Online</span>
</div>
<div class="flex gap-md">
<a class="text-[11px] font-label-md hover:text-primary transition-colors" href="#">Support</a>
<a class="text-[11px] font-label-md hover:text-primary transition-colors" href="#">Security Guide</a>
</div>
</div>
</main>
<?= $this->endSection() ?>
