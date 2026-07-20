<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Login | MobileMoney</title>
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
        .login-card {
            box-shadow: 0 10px 15px -3px rgba(6, 78, 59, 0.1);
        }
        .input-focus-ring:focus-within {
            border-color: #10B981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md antialiased min-h-screen flex items-center justify-center p-md overflow-hidden relative">
<!-- Atmospheric Background Decoration -->
<div class="absolute inset-0 pointer-events-none overflow-hidden">
<div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-secondary-container opacity-20 rounded-full blur-[120px]"></div>
<div class="absolute -bottom-[10%] -right-[10%] w-[30%] h-[30%] bg-primary-fixed opacity-10 rounded-full blur-[100px]"></div>
</div>
<!-- Main Content Canvas -->
<main class="relative z-10 w-full max-w-md">
<!-- Center Card Layout -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg md:p-xl login-card transition-all duration-500">
<!-- Brand Identity -->
<div class="flex flex-col items-center mb-xl">
<div class="w-20 h-20 mb-md">
<img alt="MobileMoney Logo" class="w-full h-full object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCw-BYcdHzJowxiNj_aCC7g4NtB8HRtBtUMs9e57GU5sZwkYMVAuV6n19U3JGHbhHUl309LJWPsW87Gx_rt-oSRD26fRqxhJmreG3o2yOm2LUf2EiG7hEIg7ZjHlJYsC-1lBtw0Ltpo3hyuaf_iB65v3pJZVJMaU0SSfhEr4ly61WrX0-W3K3ed70wR1TGE_rt1AfYjWeWluntHIJs-hoDP8zGiAvXAZtEMqf2N2NCBTt1oMaQsGkinGcqjgzHbJzC1kRvriRjG3RU"/>
</div>
<h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight mb-xs">Welcome Back</h1>
<p class="font-body-md text-on-surface-variant text-center">Securely access your MobileMoney account</p>
</div>
<!-- Login Form -->
<?php $errors = session()->getFlashdata('errors') ?? []; ?>
<?php if (! empty($errors)): ?>
<div class="rounded-lg border border-error text-error bg-error/10 px-md py-sm font-medium space-y-1">
    <?php foreach ($errors as $error): ?>
        <p class="flex items-start gap-xs"><span class="material-symbols-outlined text-base leading-none mt-[2px]">error</span><span><?= esc($error) ?></span></p>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<form class="space-y-md" method="post" action="/client/dashboard">
<!-- Phone Number Group -->
<div class="space-y-sm">
<div class="flex justify-between items-center">
<label class="font-label-md text-label-md text-outline uppercase tracking-wider block" for="phone">Phone Number</label>
<span id="digitCounter" class="font-label-md text-label-md text-outline-variant">0/10</span>
</div>
<div class="flex h-12 w-full rounded-lg border border-outline-variant bg-surface-container-lowest overflow-hidden transition-all duration-200 input-focus-ring">
<!-- Prefix Dropdown -->
<div class="relative group">
<select class="h-full bg-surface-container-low px-md pr-sm border-r border-outline-variant text-on-surface font-body-md focus:ring-0 focus:outline-none cursor-pointer appearance-none" name="prefixe" id="prefixe">
<?php foreach ($prefixes as $p): ?>
    <option value="<?= esc($p['label']) ?>" <?= old('prefixe') === $p['label'] ? 'selected' : '' ?>><?= esc($p['label']) ?></option>
<?php endforeach ?>
</select>
<span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[18px]">expand_more</span>
</div>
<!-- Number Input: full 10-digit local number, prefix included -->
<input class="flex-1 px-md border-none focus:ring-0 text-on-surface placeholder:text-outline-variant font-body-lg bg-transparent" name="phone" id="phone" placeholder="XX XXX XXXX" type="tel" inputmode="numeric" maxlength="10" value="<?= esc(old('phone') ?? '') ?>"/>
</div>
<p id="phoneHint" class="font-label-md text-label-md text-on-surface-variant">Saisissez votre numéro complet (préfixe inclus), 10 chiffres au total.</p>
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
<span>Login</span>
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
<p class="font-label-md text-label-md text-on-surface font-bold">Secure Connection</p>
<p class="text-[11px] leading-tight">Your financial data is protected with bank-grade 256-bit encryption.</p>
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
<!-- Micro-interaction script -->
<script>
        document.addEventListener('DOMContentLoaded', () => {
            const pinInput = document.getElementById('pin');
            if (pinInput) {
                const toggleBtn = pinInput.nextElementSibling;
                toggleBtn.addEventListener('click', () => {
                    const isPassword = pinInput.type === 'password';
                    pinInput.type = isPassword ? 'text' : 'password';
                    toggleBtn.querySelector('.material-symbols-outlined').textContent = isPassword ? 'visibility_off' : 'visibility';
                });
            }

            // Live "X/10 chiffres" feedback so the user knows exactly how
            // many digits are still missing before they can submit.
            const phoneInput = document.getElementById('phone');
            const counter = document.getElementById('digitCounter');
            const hint = document.getElementById('phoneHint');

            const updateCounter = () => {
                const digits = phoneInput.value.replace(/\D/g, '');
                phoneInput.value = digits;
                counter.textContent = `${digits.length}/10`;

                if (digits.length === 10) {
                    counter.classList.remove('text-outline-variant', 'text-error');
                    counter.classList.add('text-primary');
                    hint.textContent = 'Numéro complet.';
                    hint.classList.remove('text-error');
                } else {
                    counter.classList.remove('text-primary');
                    counter.classList.add(digits.length > 10 ? 'text-error' : 'text-outline-variant');
                    hint.textContent = digits.length > 10
                        ? `Trop de chiffres (${digits.length - 10} en trop).`
                        : `Il manque ${10 - digits.length} chiffre(s).`;
                    hint.classList.toggle('text-error', digits.length > 10);
                }
            };

            phoneInput.addEventListener('input', updateCounter);
            updateCounter();

            // Card entrance animation
            const card = document.querySelector('.login-card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body></html>