{{-- Main page shell: header, flash message, content slot, footer --}}
@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title . ' · ' : '' }}{{ config('app.name') }}</title>

    <style>
        [x-cloak] { display: none !important; }

        /* ---------- Design tokens (change these to re-theme everything) ---------- */
        :root {
            --ink: #10312b;        /* deep spruce: text, buttons, footer */
            --ink-soft: #1c4a40;   /* hover state for ink surfaces */
            --chalk: #f5f6f2;      /* page background */
            --surface: #ffffff;    /* cards, menus, panels */
            --deep: #10312b;       /* deep spruce: footer, mobile sheet, dark cards */
            --line: #dde1da;       /* hairlines and borders */
            --mark: #f2b632;       /* marigold accent */
            --muted: #5a6b66;      /* secondary text */
        }

        body { background: var(--chalk); color: var(--ink); font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; }
        .font-display { font-family: 'Bricolage Grotesque', 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; letter-spacing: -0.025em; }
        :focus-visible { outline: 2px solid var(--mark); outline-offset: 2px; }

        /* ---------- Header: wordmark left, segmented nav centered, actions right ---------- */
        .site-header { background: var(--chalk); border-bottom: 1px solid var(--line); }
        .header-row { display: flex; align-items: center; justify-content: space-between; }
        @media (min-width: 768px) { .header-row { display: grid; grid-template-columns: 1fr auto 1fr; } }

        .brand { display: inline-flex; align-items: center; gap: 0.6rem; color: var(--ink); }
        .brand-name { font-size: 1.15rem; font-weight: 700; line-height: 1; }

        .seg { display: inline-flex; gap: 0.25rem; border: 1px solid var(--line); background: var(--surface); border-radius: 0.75rem; padding: 0.25rem; }
        .seg-item { border-radius: 0.5rem; padding: 0.45rem 1rem; font-size: 0.9rem; font-weight: 500; color: var(--muted); transition: background .15s, color .15s; }
        .seg-item:hover { color: var(--ink); background: var(--chalk); }
        .seg-item.is-active { background: var(--ink); color: #fff; }

        .btn-ink { display: inline-flex; align-items: center; gap: 0.375rem; border-radius: 0.6rem; background: var(--mark); color: var(--ink); padding: 0.55rem 1rem; font-size: 0.9rem; font-weight: 700; transition: filter .15s, transform .15s; }
        .btn-ink:hover { filter: brightness(0.95); }
        .btn-ink:active { transform: translateY(1px); }
        .btn-ghost { display: inline-flex; align-items: center; gap: 0.5rem; border-radius: 0.6rem; border: 1px solid var(--line); background: var(--surface); color: var(--ink); padding: 0.5rem 0.85rem; font-size: 0.9rem; font-weight: 500; transition: border-color .15s; }
        .btn-ghost:hover { border-color: var(--ink); }

        .menu-panel { border: 1px solid var(--line); background: var(--surface); box-shadow: 0 12px 32px -12px rgba(16, 49, 43, 0.25); }
        .menu-link { display: block; width: 100%; text-align: left; padding: 0.55rem 1rem; font-size: 0.9rem; color: var(--ink); }
        .menu-link:hover { background: var(--chalk); }

        /* Mobile sheet: big stacked links */
        .sheet { background: var(--deep); color: #fff; }
        .sheet-link { display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 1rem 0; border-bottom: 1px solid #2f5a4f; font-size: 1.6rem; font-weight: 700; text-align: left; color: #fff; }
        .sheet-link.is-active { color: var(--mark); }

        /* ---------- Footer ---------- */
        .site-footer { background: var(--deep); color: #c3d0cb; overflow: hidden; }
        .ft-cta { display: flex; flex-direction: column; gap: 1.5rem; padding-bottom: 3rem; border-bottom: 1px solid #2f5a4f; }
        @media (min-width: 768px) { .ft-cta { flex-direction: row; align-items: flex-end; justify-content: space-between; } }
        .ft-cta h2 { margin: 0; max-width: 30rem; font-size: clamp(1.9rem, 4.5vw, 3rem); line-height: 1.05; font-weight: 800; color: #fff; }

        .footer-grid { display: grid; gap: 2.5rem; grid-template-columns: 1fr; padding-top: 3rem; }
        @media (min-width: 640px)  { .footer-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .footer-grid { grid-template-columns: 4fr 2fr 3fr 2fr; } }

        .ft-heading { margin: 0 0 1rem; font-size: 0.95rem; font-weight: 700; color: #fff; }
        .ft-text { margin: 1rem 0 0; max-width: 24rem; font-size: 0.9rem; line-height: 1.7; }
        .ft-list { list-style: none; margin: 0; padding: 0; display: grid; gap: 0.75rem; font-size: 0.9rem; }
        .ft-link { color: #c3d0cb; transition: color .15s; }
        .ft-link:hover { color: var(--mark); }
        .ft-icon { color: var(--mark); }
        .ft-social { display: inline-flex; align-items: center; gap: 0.6rem; }

        .footer-team { margin-top: 3rem; padding-top: 1.75rem; border-top: 1px solid #2f5a4f; display: flex; flex-wrap: wrap; align-items: baseline; gap: 0.5rem 1.75rem; font-size: 0.875rem; }
        .footer-team strong { color: #fff; font-weight: 700; margin-right: 0.25rem; }

        .footer-bottom { margin-top: 2rem; display: flex; flex-direction: column; align-items: center; justify-content: space-between; gap: 1rem; font-size: 0.85rem; color: #9db0a9; }
        @media (min-width: 640px) { .footer-bottom { flex-direction: row; } }
        .footer-legal { display: flex; flex-wrap: wrap; justify-content: center; gap: 0.5rem 1.5rem; list-style: none; margin: 0; padding: 0; }
        .footer-legal button { color: #9db0a9; transition: color .15s; }
        .footer-legal button:hover { color: var(--mark); }

        /* Oversized wordmark that sits along the bottom edge */
        .ft-giant { margin: 2.5rem 0 -0.6rem; white-space: nowrap; overflow: hidden; font-size: clamp(2rem, 8vw, 6.5rem); line-height: 0.9; font-weight: 800; color: var(--ink-soft); user-select: none; }

        .back-top { position: fixed; right: 1.25rem; bottom: 1.25rem; z-index: 30; display: flex; height: 2.75rem; width: 2.75rem; align-items: center; justify-content: center; border-radius: 0.6rem; background: var(--mark); color: var(--ink); box-shadow: 0 8px 20px -8px rgba(16, 49, 43, 0.5); }

        @media (prefers-reduced-motion: reduce) { * { transition: none !important; scroll-behavior: auto !important; } }
    </style>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=bricolage-grotesque:600,700,800|instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen antialiased">
<div class="flex min-h-screen flex-col">

    {{-- ================= HEADER ================= --}}
    <header x-data="{ open: false }" @keydown.escape.window="open = false" class="site-header sticky top-0 z-40">
        <nav class="header-row mx-auto max-w-6xl px-4 py-3 sm:px-6 lg:px-8" aria-label="Main navigation">

            {{-- Wordmark (no image: a small SVG mark plus the app name) --}}
            <a href="{{ route('home') }}" class="brand" aria-label="{{ config('app.name') }} home">
                <svg width="32" height="32" viewBox="0 0 32 32" aria-hidden="true">
                    <rect width="32" height="32" rx="8" fill="#10312b"/>
                    <rect x="8" y="8" width="9" height="16" rx="2" fill="#f2b632"/>
                    <rect x="19" y="8" width="5" height="7" rx="1.5" fill="#f5f6f2"/>
                    <rect x="19" y="17" width="5" height="7" rx="1.5" fill="#f5f6f2"/>
                </svg>
                <span class="brand-name font-display">{{ config('app.name') }}</span>
            </a>

            {{-- Centered segmented navigation (desktop) --}}
            <div class="seg hidden md:inline-flex">
                <a href="{{ route('home') }}" class="seg-item {{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
                <a href="{{ route('templates.index') }}" class="seg-item {{ request()->routeIs('templates.*') ? 'is-active' : '' }}">Templates</a>
                @auth
                    <a href="{{ route('portfolios.index') }}" class="seg-item {{ request()->routeIs('portfolios.index') ? 'is-active' : '' }}">My Portfolios</a>
                @endauth
            </div>

            {{-- Actions (desktop) --}}
            <div class="hidden items-center justify-end gap-2 md:flex">
                @auth
                    <a href="{{ route('portfolios.create') }}" class="btn-ink">
                        <x-icon name="plus" class="h-4 w-4" /> Create
                    </a>

                    {{-- Account dropdown --}}
                    <div x-data="{ menu: false }" @click.outside="menu = false" class="relative">
                        <button type="button" @click="menu = !menu" class="btn-ghost" :aria-expanded="menu">
                            {{ auth()->user()->name }}
                            <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/></svg>
                        </button>
                        <div x-show="menu" x-cloak x-transition class="menu-panel absolute right-0 mt-2 w-48 overflow-hidden rounded-lg py-1">
                            <a href="{{ route('profile.edit') }}" class="menu-link">Account settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="menu-link">Log out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-ghost">Log in</a>
                    <a href="{{ route('register') }}" class="btn-ink">Get started</a>
                @endauth
            </div>

            {{-- Mobile menu button --}}
            <button type="button" @click="open = !open" class="rounded-lg p-2 hover:bg-black/5 md:hidden" :aria-expanded="open" aria-label="Toggle menu">
                <x-icon name="x-mark" class="h-6 w-6" x-show="open" x-cloak />
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
            </button>
        </nav>

        {{-- Mobile sheet: large links on a dark panel --}}
        <div x-show="open" x-cloak x-transition class="sheet px-5 pb-6 pt-2 md:hidden">
            <a href="{{ route('home') }}" class="sheet-link font-display {{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
            <a href="{{ route('templates.index') }}" class="sheet-link font-display {{ request()->routeIs('templates.*') ? 'is-active' : '' }}">Templates</a>
            @auth
                <a href="{{ route('portfolios.index') }}" class="sheet-link font-display {{ request()->routeIs('portfolios.index') ? 'is-active' : '' }}">My Portfolios</a>
                <a href="{{ route('portfolios.create') }}" class="sheet-link font-display">Create Portfolio</a>
                <a href="{{ route('profile.edit') }}" class="sheet-link font-display">Account settings</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sheet-link font-display">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="sheet-link font-display">Log in</a>
                <a href="{{ route('register') }}" class="sheet-link font-display">Register</a>
            @endauth
        </div>
    </header>

    {{-- Flash message shown after saving, updating, or deleting --}}
    @if (session('status'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mx-auto mt-4 w-full max-w-6xl px-4 sm:px-6 lg:px-8" role="status">
            <div class="flex items-center justify-between gap-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
                <span>{{ session('status') }}</span>
                <button type="button" @click="show = false" class="text-emerald-700 hover:text-emerald-900" aria-label="Dismiss"><x-icon name="x-mark" class="h-4 w-4" /></button>
            </div>
        </div>
    @endif

    <main class="flex-1">{{ $slot }}</main>

    {{-- ================= FOOTER ================= --}}
    @php
        // Edit these values to change the footer details
        $footer = [
            'about'   => 'We are working together to improve and maintain the deployed website. We will continue adding features, fixing issues, and refining the design to make the website better and more user-friendly.',
            'email'   => 'shinjilecalvo@gmail.com',
            'phone'   => '+63 970 778 5469',
            'address' => 'Cebu City, Philippines',
            'social'  => [
                'Facebook'  => 'https://www.facebook.com/shinji201/',
                'Instagram' => 'https://www.instagram.com/ei.shxn/',
            ],
            // Group members shown in the footer (edit names here)
            'team'    => [
                'Calvo Shinji Lei',
                'Tudtud Daniel Kim A.',
                'Parba Zyra Mae P.',
                'Belandres Kate A.',
                'Nacua Tyron E.',
                'Manaba Eljun Nish L.',
                'Cudiera Angelo V.',
            ],
        ];

        // Icon paths for the contact list
        $contactIcons = [
            'email'   => 'M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75',
            'phone'   => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z',
            'address' => 'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z',
        ];
    @endphp
    <footer x-data="{ modal: null }" @keydown.escape.window="modal = null"
            x-effect="document.body.style.overflow = modal ? 'hidden' : ''; if (modal) { $nextTick(() => $refs.closeBtn && $refs.closeBtn.focus()) }"
            aria-labelledby="footer-heading" class="site-footer">
        <h2 id="footer-heading" class="sr-only">Footer</h2>

        <div class="mx-auto max-w-6xl px-4 pt-16 sm:px-6 lg:px-8">

            {{-- Call to action --}}
            <div class="ft-cta">
                <p class="font-display m-0" style="margin:0;max-width:30rem;font-size:clamp(1.9rem,4.5vw,3rem);line-height:1.05;font-weight:800;color:#fff;">Build a portfolio you can share.</p>
                @auth
                    <a href="{{ route('portfolios.create') }}" class="btn-ink self-start md:self-auto">Create a portfolio</a>
                @else
                    <a href="{{ route('register') }}" class="btn-ink self-start md:self-auto">Create your account</a>
                @endauth
            </div>

            <div class="footer-grid">

                {{-- Brand and about --}}
                <div id="about-us">
                    <a href="{{ route('home') }}" class="brand" style="color:#fff;" aria-label="{{ config('app.name') }} home">
                        <svg width="32" height="32" viewBox="0 0 32 32" aria-hidden="true">
                            <rect width="32" height="32" rx="8" fill="#1c4a40"/>
                            <rect x="8" y="8" width="9" height="16" rx="2" fill="#f2b632"/>
                            <rect x="19" y="8" width="5" height="7" rx="1.5" fill="#f5f6f2"/>
                            <rect x="19" y="17" width="5" height="7" rx="1.5" fill="#f5f6f2"/>
                        </svg>
                        <span class="brand-name font-display">{{ config('app.name') }}</span>
                    </a>
                    <p class="ft-text">{{ $footer['about'] }}</p>
                </div>

                {{-- Quick links --}}
                <nav aria-label="Quick links">
                    <h3 class="ft-heading font-display">Explore</h3>
                    <ul class="ft-list">
                        <li><a href="{{ route('home') }}" class="ft-link">Home</a></li>
                        <li><a href="#about-us" class="ft-link">About</a></li>
                        <li><a href="{{ route('templates.index') }}" class="ft-link">Templates</a></li>
                        <li><a href="#contact-info" class="ft-link">Contact</a></li>
                    </ul>
                </nav>

                {{-- Contact information --}}
                <div id="contact-info">
                    <h3 class="ft-heading font-display">Contact</h3>
                    <ul class="ft-list">
                        @foreach (['email' => $footer['email'], 'phone' => $footer['phone'], 'address' => $footer['address']] as $type => $value)
                            <li class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ft-icon mt-0.5 h-5 w-5 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $contactIcons[$type] }}" /></svg>
                                <span>
                                    <span class="sr-only">{{ ucfirst($type) }}: </span>
                                    @if ($type === 'email')
                                        <a href="mailto:{{ $value }}" class="ft-link break-all">{{ $value }}</a>
                                    @elseif ($type === 'phone')
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $value) }}" class="ft-link">{{ $value }}</a>
                                    @else
                                        {{ $value }}
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Social links, listed with their names --}}
                <div>
                    <h3 class="ft-heading font-display">Follow</h3>
                    <ul class="ft-list">
                        @foreach ($footer['social'] as $network => $url)
                            <li>
                                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="ft-link ft-social">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="ft-icon h-5 w-5" aria-hidden="true">
                                        @if ($network === 'Facebook')
                                            <path d="M7 10v4h3v7h4v-7h3l1-4h-4V8a1 1 0 0 1 1-1h3V3h-3a5 5 0 0 0-5 5v2H7" />
                                        @elseif ($network === 'Instagram')
                                            <rect x="4" y="4" width="16" height="16" rx="4" />
                                            <circle cx="12" cy="12" r="3" />
                                            <line x1="16.5" y1="7.5" x2="16.5" y2="7.501" />
                                        @elseif ($network === 'TikTok')
                                            <path d="M21 7.917v4.034a9.948 9.948 0 0 1-5-1.951v4.5a6.5 6.5 0 1 1-8-6.326v4.326a2.5 2.5 0 1 0 4 2v-11.5h4.083a6.005 6.005 0 0 0 4.917 4.917z" />
                                        @endif
                                    </svg>
                                    {{ $network }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Group members, in one running line --}}
            <div class="footer-team">
                <strong class="font-display">Built by</strong>
                @foreach ($footer['team'] as $member)
                    <span>{{ $member }}</span>
                @endforeach
            </div>

            {{-- Copyright and legal links --}}
            <div class="footer-bottom">
                <p style="margin:0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.</p>
                <ul class="footer-legal">
                    <li><button type="button" @click="modal = 'privacy'">Privacy Policy</button></li>
                    <li><button type="button" @click="modal = 'terms'">Terms &amp; Conditions</button></li>
                </ul>
            </div>

            <div class="ft-giant font-display" aria-hidden="true">{{ config('app.name') }}</div>
        </div>

        {{-- Pop-up window for the Privacy Policy and Terms & Conditions --}}
        <div x-show="modal" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-[#10312b]/70 p-4" @click.self="modal = null">
            <div role="dialog" aria-modal="true" :aria-label="modal === 'privacy' ? 'Privacy Policy' : 'Terms and Conditions'"
                 class="relative max-h-[85vh] w-full max-w-lg overflow-y-auto rounded-xl bg-white p-6 shadow-2xl sm:p-8">
                <button type="button" x-ref="closeBtn" @click="modal = null" aria-label="Close"
                        class="absolute right-4 top-4 flex h-11 w-11 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-slate-900">
                    <x-icon name="x-mark" class="h-5 w-5" />
                </button>

                <div x-show="modal === 'privacy'" class="space-y-4 text-sm leading-6 text-slate-600">
                    <h2 class="font-display pr-10 text-2xl font-bold text-[#10312b]">Privacy Policy</h2>
                    <p>This policy explains what information {{ config('app.name') }} collects and how it is used.</p>
                    <p><strong class="text-[#10312b]">What we collect.</strong> Your name, email address, and a securely hashed password when you register, plus everything you enter into your portfolios and any picture or resume you upload.</p>
                    <p><strong class="text-[#10312b]">How we use it.</strong> To run your account and to save and display your portfolios. We do not sell your personal information.</p>
                    <p><strong class="text-[#10312b]">Your control.</strong> Only you can view, edit, or delete your portfolios while signed in. You can delete a portfolio at any time from the Manage page.</p>
                </div>

                <div x-show="modal === 'terms'" class="space-y-4 text-sm leading-6 text-slate-600">
                    <h2 class="font-display pr-10 text-2xl font-bold text-[#10312b]">Terms &amp; Conditions</h2>
                    <p>By creating an account you agree to these terms for using {{ config('app.name') }}.</p>
                    <p><strong class="text-[#10312b]">Your account.</strong> Provide accurate information and keep your login details secure. You are responsible for the content you add.</p>
                    <p><strong class="text-[#10312b]">Your content.</strong> You keep ownership of everything you write or upload. You allow us to store it so we can provide the service.</p>
                    <p><strong class="text-[#10312b]">Acceptable use.</strong> Do not upload unlawful or infringing material, and do not try to access other people's accounts.</p>
                    <p><strong class="text-[#10312b]">Availability.</strong> The service is provided as is, and features may change without notice.</p>
                </div>
            </div>
        </div>
    </footer>
</div>

{{-- Back to top: appears after scrolling down --}}
<button type="button" x-data="{ show: false }" x-show="show" x-cloak x-transition.opacity
        @scroll.window="show = window.scrollY > 600" @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="back-top" aria-label="Back to top">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" /></svg>
</button>

@stack('scripts')
</body>
</html>