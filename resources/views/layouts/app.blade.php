<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Chez Léon') — Plateforme Connectée</title>

    {{-- Google Fonts : Playfair Display (élégance) + DM Sans (lisibilité) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    
    <style>
        /* ── Variables de marque ── */
        :root {
            --leon-gold:    #C9A84C;
            --leon-dark:    #1A1A18;
            --leon-surface: #F7F5F0;
            --leon-border:  #E5E0D5;
            --leon-text:    #2C2C28;
            --leon-muted:   #8A8578;

            /* Niveau → couleur badge */
            --xp-beginner:     #6B9E78;
            --xp-intermediate: #4A90D9;
            --xp-advanced:     #9B59B6;
            --xp-expert:       #C9A84C;
        }

        /* ── Base typographique ── */
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--leon-surface);
            color: var(--leon-text);
        }

        .font-display { font-family: 'Playfair Display', serif; }

        /* ── Navbar ── */
        .navbar {
            background: var(--leon-dark);
            border-bottom: 2px solid var(--leon-gold);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: var(--leon-gold) !important;
            letter-spacing: 0.03em;
        }

        .navbar-brand span {
            color: #fff;
            font-style: italic;
        }

        .nav-link {
            color: rgba(255,255,255,0.75) !important;
            font-size: 0.875rem;
            font-weight: 500;
            letter-spacing: 0.02em;
            padding: 0.5rem 1rem !important;
            border-radius: 6px;
            transition: color 0.2s, background 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--leon-gold) !important;
            background: rgba(201,168,76,0.08);
        }

        /* ── Badge XP niveau ── */
        .badge-level {
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 20px;
        }
        .badge-level.beginner     { background: rgba(107,158,120,0.15); color: var(--xp-beginner);     border: 1px solid var(--xp-beginner); }
        .badge-level.intermediate { background: rgba(74,144,217,0.15);  color: var(--xp-intermediate);  border: 1px solid var(--xp-intermediate); }
        .badge-level.advanced     { background: rgba(155,89,182,0.15);  color: var(--xp-advanced);     border: 1px solid var(--xp-advanced); }
        .badge-level.expert       { background: rgba(201,168,76,0.15);  color: var(--xp-expert);       border: 1px solid var(--xp-expert); }

        /* ── XP Progress bar ── */
        .xp-bar-track {
            height: 3px;
            background: rgba(255,255,255,0.12);
            border-radius: 2px;
            overflow: hidden;
        }
        .xp-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--leon-gold), #E8C96A);
            border-radius: 2px;
            transition: width 0.6s ease;
        }

        /* ── Alerts flash ── */
        .flash-alert {
            border-left: 4px solid;
            border-radius: 0 8px 8px 0;
            padding: 12px 16px;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease;
        }
        .flash-success { border-color: #27AE60; background: #F0FBF4; color: #1A6E3A; }
        .flash-error   { border-color: #E74C3C; background: #FEF2F2; color: #7B1E1E; }
        .flash-info    { border-color: var(--leon-gold); background: #FDFAF2; color: #7A5C1A; }
        .flash-warning { border-color: #F39C12; background: #FFFBF0; color: #7A5010; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Main content ── */
        .main-content {
            min-height: calc(100vh - 68px);
        }

        /* ── Footer ── */
        .site-footer {
            background: var(--leon-dark);
            color: rgba(255,255,255,0.45);
            font-size: 0.8rem;
            padding: 1.5rem 0;
            border-top: 1px solid rgba(201,168,76,0.2);
        }

        /* ── Mobile menu overlay ── */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: #222220;
                padding: 1rem;
                border-top: 1px solid rgba(201,168,76,0.15);
                margin-top: 0.5rem;
                border-radius: 8px;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="h-full">

{{-- ════════════════════════════════════════════════════ --}}
{{-- BARRE DE NAVIGATION                                  --}}
{{-- ════════════════════════════════════════════════════ --}}
<nav class="navbar navbar-expand-lg">
    <div class="container">

        {{-- Logo / Marque --}}
        <a class="navbar-brand me-4" href="{{ route('public.home') }}">
            Chez <span>Léon</span>
        </a>

        {{-- Bouton hamburger (mobile) --}}
        <button class="navbar-toggler border-0 p-1" type="button"
                data-bs-toggle="collapse" data-bs-target="#navMain"
                aria-label="Menu">
            <span style="display:block;width:22px;height:2px;background:var(--leon-gold);margin:5px 0;"></span>
            <span style="display:block;width:22px;height:2px;background:var(--leon-gold);margin:5px 0;"></span>
            <span style="display:block;width:22px;height:2px;background:var(--leon-gold);margin:5px 0;"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">

            {{-- ── Navigation principale (selon rôle) ── --}}
            <ul class="navbar-nav me-auto gap-1">

                {{-- Toujours visible --}}
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('public.home')) active @endif"
                       href="{{ route('public.home') }}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('public.news.*')) active @endif"
                       href="{{ route('public.news.index') }}">Actualités</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('public.tour.*')) active @endif"
                       href="{{ route('public.tour.index') }}">Visite guidée</a>
                </li>

                @auth
                    @if(auth()->user()->is_approved)

                        {{-- MODULE VISUALISATION (simple+) --}}
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('simple.devices.*')) active @endif"
                               href="{{ route('simple.devices.index') }}">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1 mb-1"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                                Objets connectés
                            </a>
                        </li>

                        {{-- MODULE GESTION (complex + niveau advanced+) --}}
                        @if(auth()->user()->hasAccessToManagement())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle @if(request()->routeIs('complex.*')) active @endif"
                                   href="#" data-bs-toggle="dropdown">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1 mb-1"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77 5.82 21.02 7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    Gestion
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark border-0"
                                    style="background:#222220;border:1px solid rgba(201,168,76,0.2)!important;min-width:200px;">
                                    <li><a class="dropdown-item" href="{{ route('complex.devices.index') }}">Mes appareils</a></li>
                                    <li><a class="dropdown-item" href="{{ route('complex.devices.create') }}">Ajouter un appareil</a></li>
                                    <li><hr class="dropdown-divider" style="border-color:rgba(201,168,76,0.15)"></li>
                                    <li><a class="dropdown-item" href="{{ route('complex.reports.index') }}">Rapports</a></li>
                                    <li><a class="dropdown-item" href="{{ route('complex.zones.index') }}">Zones</a></li>
                                </ul>
                            </li>
                        @endif

                        {{-- MODULE ADMINISTRATION (admin + expert) --}}
                        @if(auth()->user()->hasAccessToAdmin())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle @if(request()->routeIs('admin.*')) active @endif"
                                   href="#" data-bs-toggle="dropdown"
                                   style="color: var(--leon-gold) !important;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1 mb-1"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                    Administration
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark border-0"
                                    style="background:#222220;border:1px solid rgba(201,168,76,0.2)!important;min-width:200px;">
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Tableau de bord</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Utilisateurs</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.users.pending') }}">
                                        En attente
                                        @php $pending = \App\Models\User::pendingApproval()->count(); @endphp
                                        @if($pending > 0)
                                            <span class="badge rounded-pill ms-1" style="background:var(--leon-gold);color:#000;font-size:0.65rem;">{{ $pending }}</span>
                                        @endif
                                    </a></li>
                                    <li><hr class="dropdown-divider" style="border-color:rgba(201,168,76,0.15)"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">Catégories</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.zones.index') }}">Zones</a></li>
                                    <li><hr class="dropdown-divider" style="border-color:rgba(201,168,76,0.15)"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.integrity.index') }}">Intégrité des données</a></li>
                                </ul>
                            </li>
                        @endif

                    @endif {{-- is_approved --}}
                @endauth

            </ul>

            {{-- ── Partie droite : Profil / Auth ── --}}
            <ul class="navbar-nav ms-auto align-items-center gap-2">

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.login') }}">Se connecter</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('public.register') }}"
                           class="btn btn-sm px-3 py-2"
                           style="background:var(--leon-gold);color:#000;font-weight:600;border-radius:6px;font-size:0.8rem;">
                            S'inscrire
                        </a>
                    </li>
                @endguest

                @auth
                    {{-- XP + Niveau (desktop uniquement) --}}
                    <li class="nav-item d-none d-lg-block" style="min-width:140px;">
                        @php
                            $user = auth()->user();
                            $thresholds = \App\Models\User::XP_THRESHOLDS;
                            $levels = array_keys($thresholds);
                            $currentIdx = array_search($user->level, $levels);
                            $nextXp = $thresholds[$levels[min($currentIdx + 1, count($levels)-1)]] ?? $thresholds['expert'];
                            $currentFloorXp = $thresholds[$user->level];
                            $progress = $currentIdx >= count($levels)-1 ? 100
                                : min(100, round(($user->experience_points - $currentFloorXp) / ($nextXp - $currentFloorXp) * 100));
                        @endphp
                        <div class="d-flex flex-column gap-1" style="padding: 4px 0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge-level {{ $user->level }}">{{ __('levels.'.$user->level ?? $user->level) }}</span>
                                <span style="color:rgba(255,255,255,0.5);font-size:0.7rem;">{{ $user->experience_points }} XP</span>
                            </div>
                            <div class="xp-bar-track">
                                <div class="xp-bar-fill" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>
                    </li>

                    {{-- Menu profil --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link d-flex align-items-center gap-2 p-1"
                           href="#" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}"
                                 alt="{{ auth()->user()->pseudo }}"
                                 width="34" height="34"
                                 style="border-radius:50%;border:2px solid var(--leon-gold);object-fit:cover;">
                            <span class="d-none d-lg-inline" style="font-size:0.875rem;color:rgba(255,255,255,0.85);">
                                {{ auth()->user()->pseudo ?? auth()->user()->name }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark border-0"
                            style="background:#222220;border:1px solid rgba(201,168,76,0.2)!important;min-width:180px;">
                            <li class="px-3 py-2" style="border-bottom:1px solid rgba(201,168,76,0.1);">
                                <div style="font-size:0.8rem;color:rgba(255,255,255,0.5);">Connecté en tant que</div>
                                <div style="font-size:0.875rem;color:#fff;font-weight:500;">{{ auth()->user()->name }}</div>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('simple.profile.show') }}">Mon profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('simple.xp.index') }}">Historique XP</a></li>
                            <li><hr class="dropdown-divider" style="border-color:rgba(201,168,76,0.15)"></li>
                            <li>
                                <form method="POST" action="{{ route('public.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="color:#E74C3C;">
                                        Se déconnecter
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

            </ul>
        </div>{{-- /.navbar-collapse --}}
    </div>{{-- /.container --}}
</nav>


{{-- ════════════════════════════════════════════════════ --}}
{{-- MESSAGES FLASH DE SESSION                           --}}
{{-- ════════════════════════════════════════════════════ --}}
@if(session()->hasAny(['success','error','info','warning']) || $errors->any())
<div class="container mt-3 px-3 px-md-0" id="flash-container">
    @foreach(['success','error','info','warning'] as $type)
        @if(session($type))
        <div class="flash-alert flash-{{ $type }} mb-2" role="alert">
            @if($type === 'success')
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0"><polyline points="20 6 9 17 4 12"/></svg>
            @elseif($type === 'error')
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            @elseif($type === 'info')
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            @else
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            @endif
            <span>{{ session($type) }}</span>
            <button onclick="this.closest('.flash-alert').remove()"
                    style="margin-left:auto;background:none;border:none;cursor:pointer;opacity:0.6;font-size:1.1rem;line-height:1;">×</button>
        </div>
        @endif
    @endforeach

    @if($errors->any())
    <div class="flash-alert flash-error mb-2" role="alert">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        <div>
            <strong>Erreurs de validation :</strong>
            <ul class="mb-0 mt-1 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>
@endif


{{-- ════════════════════════════════════════════════════ --}}
{{-- CONTENU PRINCIPAL                                    --}}
{{-- ════════════════════════════════════════════════════ --}}
<main class="main-content">
    @yield('content')
</main>


{{-- ════════════════════════════════════════════════════ --}}
{{-- FOOTER                                              --}}
{{-- ════════════════════════════════════════════════════ --}}
<footer class="site-footer">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
        <span class="font-display" style="color:rgba(201,168,76,0.6);font-size:0.9rem;">Chez Léon</span>
        <span>Plateforme IoT Restaurant © {{ date('Y') }}</span>
        <div class="d-flex gap-3">
            <a href="{{ route('public.home') }}" style="color:inherit;text-decoration:none;">Accueil</a>
            <a href="{{ route('public.tour.index') }}" style="color:inherit;text-decoration:none;">Visite</a>
        </div>
    </div>
</footer>

{{-- Bootstrap JS (CDN) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

{{-- Auto-hide des flash après 5 secondes --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            document.querySelectorAll('.flash-alert').forEach(function (el) {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 5000);
    });
</script>

@stack('scripts')
</body>
</html>