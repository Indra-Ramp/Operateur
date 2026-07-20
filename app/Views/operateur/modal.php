<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Mobile Money</title>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=JetBrains+Mono:wght@100..900&display=swap"
        rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                        "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500" }],
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "headline-lg": ["28px", { "lineHeight": "36px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "headline-md": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "display": ["36px", { "lineHeight": "44px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "headline-lg-mobile": ["24px", { "lineHeight": "32px", "fontWeight": "600" }]
                    }
                },
            },
        }
    </script>
    <style>
        body {
            background-color: #F9FAFB;
            font-family: 'Inter', sans-serif;
            color: #191c1d;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .custom-shadow {
            box-shadow: 0 4px 6px -1px rgba(6, 78, 59, 0.05);
        }

        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
        }
    </style>
    <?= $this->renderSection('custom_style') ?>
</head>

<body class="bg-background">
    <!-- Sidebar Navigation Shell -->
    <aside
        class="fixed left-0 top-0 h-full w-[280px] bg-surface-container-low border-r border-outline-variant flex flex-col p-md z-40">
        <!-- Brand / Header -->
        <div class="mb-xl px-sm">
            <h1 class="font-headline-md text-headline-md font-bold text-primary mb-xs">Console de l'operateur</h1>
            <p class="font-label-md text-label-md text-on-surface-variant opacity-70">Administrateur systeme</p>
        </div>
        <!-- Main Tabs -->
        <nav class="flex-grow space-y-1">
            <?php
                // Classes de base communes à tous les boutons
                $baseClass = "flex items-center gap-md rounded-lg px-md py-sm transition-transform duration-200 hover:translate-x-1";

                // Classes spécifiques selon l'état
                $activeClass = "bg-secondary-container text-on-secondary-container";
                $inactiveClass = "text-on-surface-variant hover:bg-surface-container-highest";

                // Valeur par défaut si non définie dans le contrôleur
                $activePage = $activePage ?? ''; 
                ?>

                <!-- Lien Dashboard -->
                <a class="<?= $baseClass ?> <?= ($activePage === 'dashboard') ? $activeClass : $inactiveClass ?>"
                href="<?= base_url('/dashboard') ?>">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' <?= ($activePage === 'dashboard') ? '1' : '0' ?>;">
                        dashboard
                    </span>
                    <span class="font-label-md text-label-md">Dashboard</span>
                </a>

                <!-- Lien Frais -->
                <a class="<?= $baseClass ?> <?= ($activePage === 'frais') ? $activeClass : $inactiveClass ?>"
                href="<?= base_url('/operateur/choose-operation') ?>">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' <?= ($activePage === 'frais') ? '1' : '0' ?>;">
                        swap_horiz
                    </span>
                    <span class="font-label-md text-label-md">Frais</span>
                </a>

                <!-- Lien Prefixes -->
                <a class="<?= $baseClass ?> <?= ($activePage === 'prefixes') ? $activeClass : $inactiveClass ?>"
                href="<?= base_url('/operateur/prefix') ?>">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' <?= ($activePage === 'prefixes') ? '1' : '0' ?>;">
                        person_pin_circle
                    </span>
                    <span class="font-label-md text-label-md">Prefixes</span>
                </a>
                <a class="<?= $baseClass ?> <?= ($activePage === 'other') ? $activeClass : $inactiveClass ?>"
                href="<?= base_url('/operateur/autres') ?>">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' <?= ($activePage === 'other') ? '1' : '0' ?>;">
                        person_pin_circle
                    </span>
                    <span class="font-label-md text-label-md">Autres operateurs</span>
                </a>
                <!-- Lien Statistiques -->
                <a class="<?= $baseClass ?> <?= ($activePage === 'stats') ? $activeClass : $inactiveClass ?>"
                href="<?= base_url('/operateur/stats') ?>">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' <?= ($activePage === 'stats') ? '1' : '0' ?>;">
                        bar_chart
                    </span>
                    <span class="font-label-md text-label-md">Statistiques</span>
                </a>
                <a class="<?= $baseClass ?> <?= ($activePage === 'situation') ? $activeClass : $inactiveClass ?>"
                href="<?= base_url('/operateur/autres/situation') ?>">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' <?= ($activePage === 'situation') ? '1' : '0' ?>;">
                        bar_chart
                    </span>
                    <span class="font-label-md text-label-md">Situation des montants</span>
                </a>
        </nav>
        <!-- Footer Tabs -->
        <div class="mt-auto pt-xl space-y-1">
            <a class="flex items-center gap-md text-on-surface-variant px-md py-sm hover:bg-surface-container-highest transition-transform duration-200 hover:translate-x-1 rounded-lg"
                href="#">
                <span class="material-symbols-outlined">settings</span>
                <span class="font-label-md text-label-md">Parametres</span>
            </a>
            <a class="flex items-center gap-md text-on-surface-variant px-md py-sm hover:bg-surface-container-highest transition-transform duration-200 hover:translate-x-1 rounded-lg"
                href="#">
                <span class="material-symbols-outlined">contact_support</span>
                <span class="font-label-md text-label-md">Support</span>
            </a>
        </div>
    </aside>
    <!-- Main Content Canvas -->
     <?= $this->renderSection('main'); ?>
</body>

</html>