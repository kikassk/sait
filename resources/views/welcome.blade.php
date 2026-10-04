<!DOCTYPE html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ОРБИТА — Творческий кластер & Бар-трансформер от Вани Дмитриенко</title>
    <meta name="description" content="Исторический особняк на Яузской 1/15. Модернистский фэнси-бар, гастрономия и актуальный звук.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts: Unbounded (Headings) & Space Grotesk / Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Unbounded:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Three.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    @vite(['resources/css/app.css'])

    <style>
        :root {
            --bg-obsidian: #050507;
            --card-bg: rgba(13, 14, 20, 0.75);
            --gold-primary: #d4af37;
            --gold-light: #f3e5ab;
            --gold-dark: #997a15;
            --gold-glow: rgba(212, 175, 55, 0.15);
            --border-hairline: rgba(212, 175, 55, 0.18);
            --border-hover: rgba(212, 175, 55, 0.5);
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: var(--bg-obsidian);
            color: #f8fafc;
            overflow-x: hidden;
            transition: background-color 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .font-heading {
            font-family: 'Unbounded', sans-serif;
        }

        /* 3D WebGL Canvas Background */
        #moon-canvas-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 0;
            pointer-events: none;
        }

        .content-layer {
            position: relative;
            z-index: 10;
        }

        /* Architectural Modernist Cards (Cut Corners) */
        .architectural-card {
            background: var(--card-bg);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid var(--border-hairline);
            clip-path: polygon(
                0 0,
                calc(100% - 16px) 0,
                100% 16px,
                100% 100%,
                16px 100%,
                0 calc(100% - 16px)
            );
            position: relative;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .architectural-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 16px;
            width: 1px;
            height: 16px;
            background: var(--gold-primary);
            opacity: 0.4;
        }

        .architectural-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 16px;
            width: 1px;
            height: 16px;
            background: var(--gold-primary);
            opacity: 0.4;
        }

        .architectural-card:hover {
            border-color: var(--border-hover);
            box-shadow: 0 0 40px var(--gold-glow);
            transform: translateY(-4px);
        }

        /* Header Navigation Glass */
        .modern-nav {
            background: rgba(5, 5, 7, 0.85);
            backdrop-filter: blur(32px);
            border-bottom: 1px solid var(--border-hairline);
        }

        /* Day / Night Theme Variations */
        body.theme-day {
            --bg-obsidian: #0b0d14;
            --card-bg: rgba(20, 24, 38, 0.8);
            --gold-primary: #e5c158;
            --gold-glow: rgba(229, 193, 88, 0.2);
        }

        /* Modernist Seating Map Buttons */
        .seating-btn {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-hairline);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 8px, 100% 100%, 8px 100%, 0 calc(100% - 8px));
        }

        .seating-btn:hover {
            background: rgba(212, 175, 55, 0.12);
            border-color: var(--gold-primary);
            transform: scale(1.04);
            box-shadow: 0 0 25px var(--gold-glow);
        }

        /* Guest Selection Pills */
        .guest-pill {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-hairline);
            color: #94a3b8;
            transition: all 0.25s ease;
            clip-path: polygon(0 0, calc(100% - 6px) 0, 100% 6px, 100% 100%, 6px 100%, 0 calc(100% - 6px));
        }

        .guest-pill.active, .guest-pill:hover {
            background: rgba(212, 175, 55, 0.2);
            border-color: var(--gold-primary);
            color: #ffffff;
            box-shadow: 0 0 20px var(--gold-glow);
        }

        /* Keyframe Marquee */
        @keyframes marqueeScroll {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: flex;
            width: 200%;
            animation: marqueeScroll 30s linear infinite;
        }

        /* Champagne Gold Gradient Text */
        .text-gold-gradient {
            background: linear-gradient(135deg, #fff7d6 0%, #d4af37 50%, #997a15 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #050507;
        }
        ::-webkit-scrollbar-thumb {
            background: #1f2230;
            border-radius: 2px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #d4af37;
        }
    </style>
</head>
<body class="bg-[#050507] text-slate-100 antialiased selection:bg-amber-400 selection:text-black">

    <!-- 3D WebGL Canvas Container for Photorealistic Shader Moon -->
    <div id="moon-canvas-container"></div>

    <div class="content-layer">

        <!-- Modernist Header / Navigation Bar -->
        <header class="fixed top-0 left-0 right-0 z-50 modern-nav transition-all duration-300" id="navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">

                <!-- Brand Logo -->
                <a href="#hero" class="flex items-center gap-4 group">
                    <div class="w-10 h-10 bg-black border border-amber-500/30 flex items-center justify-center relative group-hover:border-amber-400 transition-colors" style="clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 8px, 100% 100%, 8px 100%, 0 calc(100% - 8px));">
                        <span class="text-amber-300 font-heading font-black text-xl tracking-tighter">O</span>
                        <div class="absolute inset-0 bg-amber-400/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    <div>
                        <div class="text-lg font-black font-heading tracking-[0.25em] text-white group-hover:text-amber-300 transition-colors flex items-center gap-2">
                            ОРБИТА
                            <span class="text-[9px] font-sans font-light px-1.5 py-0.5 border border-amber-500/30 text-amber-300 tracking-normal uppercase">MOSCOW</span>
                        </div>
                        <div class="text-[9px] uppercase tracking-[0.2em] text-slate-400 font-medium flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-amber-400"></span>
                            Яузская 1/15
                        </div>
                    </div>
                </a>

                <!-- Navigation Links -->
                <nav class="hidden lg:flex items-center gap-8 bg-black/60 border border-amber-500/20 px-8 py-3 backdrop-blur-3xl" style="clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));">
                    <a href="#about" class="text-xs font-semibold uppercase tracking-widest text-slate-300 hover:text-amber-300 transition-colors">// О концепции</a>
                    <a href="#seating" class="text-xs font-semibold uppercase tracking-widest text-slate-300 hover:text-amber-300 transition-colors">// План рассадки</a>
                    <a href="#menu" class="text-xs font-semibold uppercase tracking-widest text-slate-300 hover:text-amber-300 transition-colors">// Меню</a>
                    <a href="#loyalty" class="text-xs font-semibold uppercase tracking-widest text-slate-300 hover:text-amber-300 transition-colors">// Орбитальность</a>
                    <a href="#contacts" class="text-xs font-semibold uppercase tracking-widest text-slate-300 hover:text-amber-300 transition-colors">// Контакты</a>
                </nav>

                <!-- Atmosphere Controls & Booking Button -->
                <div class="flex items-center gap-4">
                    <!-- Day / Night Toggle -->
                    <button id="mode-toggle-btn" onclick="toggleDayNightMode()" class="px-4 py-2.5 bg-white/5 border border-amber-500/20 text-[10px] font-heading font-bold text-amber-300 hover:bg-amber-500/10 transition-all flex items-center gap-2" style="clip-path: polygon(0 0, calc(100% - 6px) 0, 100% 6px, 100% 100%, 6px 100%, 0 calc(100% - 6px));">
                        <!-- Custom SVG Crescent/Sun Icon -->
                        <svg id="mode-svg" class="w-3.5 h-3.5 text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                        <span id="mode-label" class="hidden sm:inline tracking-wider">NIGHT MODE</span>
                    </button>

                    <!-- Reserve Button -->
                    <button onclick="openBookingModal('Главная зона')" class="relative inline-flex items-center justify-center px-6 py-2.5 text-xs font-bold font-heading bg-gradient-to-r from-amber-300 via-amber-400 to-amber-500 text-black shadow-lg shadow-amber-500/20 hover:scale-105 transition-all duration-300" style="clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 8px, 100% 100%, 8px 100%, 0 calc(100% - 8px));">
                        <span class="uppercase tracking-widest font-black">Забронировать</span>
                    </button>
                </div>
            </div>
        </header>

        <!-- Modernist Hero Section -->
        <section id="hero" class="relative min-h-screen flex items-center justify-center pt-32 pb-20 overflow-hidden">
            <div class="max-w-6xl mx-auto px-4 text-center relative z-10">

                <!-- Modernist Architectural Tag -->
                <div class="inline-flex items-center gap-3 px-5 py-2 bg-black/80 border border-amber-500/30 backdrop-blur-2xl mb-8" style="clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 8px, 100% 100%, 8px 100%, 0 calc(100% - 8px));">
                    <span class="w-1.5 h-1.5 bg-amber-400 animate-pulse"></span>
                    <span class="text-[11px] font-bold uppercase tracking-[0.25em] text-amber-300 font-heading">
                        ИСТОРИЧЕСКИЙ ОСОБНЯК • БАР ОТ ВАНИ ДМИТРИЕНКО
                    </span>
                </div>

                <!-- Main Dynamic Title -->
                <h1 class="text-4xl sm:text-7xl md:text-8xl lg:text-9xl font-black font-heading tracking-tight text-white mb-8 leading-[0.92]">
                    ДВИГАЙСЯ <br/>
                    <span class="text-gold-gradient">
                        ВМЕСТЕ С ОРБИТОЙ
                    </span>
                </h1>

                <!-- Architectural Modernist Day/Night Dual Box -->
                <div class="max-w-3xl mx-auto mb-12 grid grid-cols-1 md:grid-cols-2 gap-5 text-left">
                    <!-- Day Box -->
                    <div class="architectural-card p-6 border-l-2 border-l-amber-400">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M4.93 19.07l1.41-1.41m11.32-11.32l1.41-1.41"/></svg>
                                <span class="text-xs font-heading font-bold uppercase tracking-widest text-amber-400">ДНЕВНОЙ ФОРМАТ</span>
                            </div>
                            <span class="text-[10px] text-slate-500 font-mono">// 12:00 — 18:00</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-light">Фэнси-бар с яркой авторской кухней, коворкингом и творческими встречами.</p>
                    </div>

                    <!-- Night Box -->
                    <div class="architectural-card p-6 border-l-2 border-l-amber-200">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                                <span class="text-xs font-heading font-bold uppercase tracking-widest text-amber-200">НОЧНОЙ ФОРМАТ</span>
                            </div>
                            <span class="text-[10px] text-slate-500 font-mono">// 18:00 — 03:00</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-light">Пространство с актуальным звуком, сетами любимых артистов и авторскими коктейлями.</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-5">
                    <button onclick="openBookingModal('Главная сцена')" class="w-full sm:w-auto px-10 py-4 bg-gradient-to-r from-amber-300 via-amber-400 to-amber-500 text-black font-heading text-xs tracking-widest uppercase font-black shadow-2xl hover:scale-105 transition-all duration-300" style="clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 10px 100%, 0 calc(100% - 10px));">
                        ЗАБРОНИРОВАТЬ СТОЛ
                    </button>
                    <a href="#seating" class="w-full sm:w-auto px-10 py-4 bg-black/80 hover:bg-white/10 border border-amber-500/30 backdrop-blur-2xl text-slate-200 font-heading text-xs tracking-widest uppercase font-bold transition-all duration-300" style="clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 10px 100%, 0 calc(100% - 10px));">
                        ПЛАН РАССАДКИ
                    </a>
                </div>

                <!-- Location Info Strip -->
                <div class="mt-16 inline-flex flex-wrap items-center justify-center gap-6 px-8 py-3.5 bg-black/90 border border-amber-500/20 text-xs text-slate-300 backdrop-blur-2xl" style="clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));">
                    <span class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        Москва, ул. Яузская 1/15
                    </span>
                    <span class="hidden sm:inline text-amber-500/40">/</span>
                    <span class="flex items-center gap-2">
                        метро Китай-город / Таганская
                    </span>
                    <span class="hidden sm:inline text-amber-500/40">/</span>
                    <span class="text-amber-300 font-semibold">Вс–Чт: 12:00–00:00 | Пт–Сб: 12:00–03:00</span>
                </div>
            </div>
        </section>

        <!-- Continuous Orbit Ticker Marquee -->
        <div class="w-full bg-black border-y border-amber-500/20 py-3 overflow-hidden backdrop-blur-xl">
            <div class="animate-marquee whitespace-nowrap flex items-center gap-12 font-heading text-[11px] uppercase tracking-[0.3em] font-bold text-amber-300/80">
                <span>[✦ ОРБИТА — ТВОРЧЕСКИЙ КЛАСТЕР]</span>
                <span>[✦ АВТОРСКАЯ КУХНЯ ВАНА ДМИТРИЕНКО]</span>
                <span>[✦ АКТУАЛЬНЫЙ ЗВУК И ЖИВЫЕ ДЖЕМЫ]</span>
                <span>[✦ ИСТОРИЧЕСКИЙ ОСОБНЯК НА ЯУЗСКОЙ]</span>
                <span>[✦ ОРБИТА — ТВОРЧЕСКИЙ КЛАСТЕР]</span>
                <span>[✦ АВТОРСКАЯ КУХНЯ ВАНА ДМИТРИЕНКО]</span>
                <span>[✦ АКТУАЛЬНЫЙ ЗВУК И ЖИВЫЕ ДЖЕМЫ]</span>
                <span>[✦ ИСТОРИЧЕСКИЙ ОСОБНЯК НА ЯУЗСКОЙ]</span>
            </div>
        </div>

        <!-- Concept Section -->
        <section id="about" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                    <!-- Left Column Text -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-300 text-[10px] font-heading uppercase tracking-widest">
                            // CONCEPT & VISION
                        </div>

                        <h2 class="text-3xl sm:text-5xl font-black font-heading text-white leading-tight">
                            ОРБИТА — БАР, ГДЕ <span class="text-gold-gradient">ЗВЕЗДЫ ТУСУЮТСЯ</span> НЕ НА НЕБЕ, А ЗА СОСЕДНИМ СТОЛИКОМ
                        </h2>

                        <p class="text-slate-300 text-base sm:text-lg leading-relaxed font-light">
                            «Встретимся на Орбите! Здесь тебя будут ждать авторские бар и кухня, креативные классы, квартирники, джемы с молодыми артистами и музыкантами, уютные концерты и, конечно же, я.»
                        </p>

                        <div class="architectural-card p-6 border-l-2 border-l-amber-400">
                            <div class="text-xs uppercase font-bold text-amber-400 font-heading mb-1">— Ваня Дмитриенко</div>
                            <p class="text-xs text-slate-400 italic font-light leading-relaxed">«Я давно мечтал о пространстве, в котором смогу делиться тем, что мне важно. Место, куда можно приехать за свежими идеями, поработать, послушать музыку или просто круто провести время.»</p>
                        </div>

                        <!-- 3 Architectural Highlights -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                            <div class="architectural-card p-5">
                                <div class="text-amber-300 font-heading font-black text-2xl mb-1">01</div>
                                <div class="text-xs font-bold text-white mb-1">Творческий кластер</div>
                                <div class="text-[11px] text-slate-400">Летние маркеты & арт-события</div>
                            </div>
                            <div class="architectural-card p-5">
                                <div class="text-amber-300 font-heading font-black text-2xl mb-1">02</div>
                                <div class="text-xs font-bold text-white mb-1">Бар-трансформер</div>
                                <div class="text-[11px] text-slate-400">Из коворкинга в ночной клуб</div>
                            </div>
                            <div class="architectural-card p-5">
                                <div class="text-amber-300 font-heading font-black text-2xl mb-1">03</div>
                                <div class="text-xs font-bold text-white mb-1">Авторская кухня</div>
                                <div class="text-[11px] text-slate-400">Smart casual гастрономия</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column Interactive Moon Controls -->
                    <div class="lg:col-span-5">
                        <div class="architectural-card p-8 border border-amber-500/30 text-center">
                            <div class="text-xs font-heading font-bold uppercase tracking-widest text-amber-300 mb-2 flex items-center justify-center gap-2">
                                <span class="w-1.5 h-1.5 bg-amber-400 animate-ping"></span>
                                ИНТЕРАКТИВНАЯ ФАЗА ЛУНЫ
                            </div>
                            <p class="text-xs text-slate-400 mb-6 font-light">Переключайте угол освещения и солнечные векторы в реальном времени</p>

                            <div class="space-y-3">
                                <button onclick="rotateMoonPhase('full')" class="w-full py-3 px-4 bg-black/60 hover:bg-amber-500/20 border border-amber-500/20 text-xs font-heading font-bold text-slate-200 transition-all flex items-center justify-between" style="clip-path: polygon(0 0, calc(100% - 6px) 0, 100% 6px, 100% 100%, 6px 100%, 0 calc(100% - 6px));">
                                    <span class="tracking-wider">// ПОЛНОЛУНИЕ (PARTY MODE)</span>
                                    <span class="text-amber-400">&rarr;</span>
                                </button>
                                <button onclick="rotateMoonPhase('crescent')" class="w-full py-3 px-4 bg-black/60 hover:bg-amber-500/20 border border-amber-500/20 text-xs font-heading font-bold text-slate-200 transition-all flex items-center justify-between" style="clip-path: polygon(0 0, calc(100% - 6px) 0, 100% 6px, 100% 100%, 6px 100%, 0 calc(100% - 6px));">
                                    <span class="tracking-wider">// ПОЛУМЕСЯЦ (LOUNGE MODE)</span>
                                    <span class="text-amber-400">&rarr;</span>
                                </button>
                                <button onclick="rotateMoonPhase('eclipse')" class="w-full py-3 px-4 bg-black/60 hover:bg-amber-500/20 border border-amber-500/20 text-xs font-heading font-bold text-slate-200 transition-all flex items-center justify-between" style="clip-path: polygon(0 0, calc(100% - 6px) 0, 100% 6px, 100% 100%, 6px 100%, 0 calc(100% - 6px));">
                                    <span class="tracking-wider">// ЗАТМЕНИЕ (NIGHT SOUND)</span>
                                    <span class="text-amber-400">&rarr;</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Modernist Seating Map Section -->
        <section id="seating" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-300 text-[10px] font-heading uppercase tracking-widest mb-4">
                        // ARCHITECTURAL FLOOR PLAN
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black font-heading text-white">ПЛАН РАССАДКИ</h2>
                    <p class="text-slate-400 text-xs sm:text-sm mt-3">Выберите зону или стол для мгновенной брони</p>
                </div>

                <!-- Unified Architectural Seating Grid -->
                <div class="architectural-card p-6 sm:p-10 border border-amber-500/30">
                    <div class="grid grid-cols-12 gap-5 min-h-[420px]">

                        <!-- Main Stage & Dancefloor Zone -->
                        <div class="col-span-12 md:col-span-8 bg-black/70 border border-amber-500/30 p-6 flex flex-col justify-between relative group" style="clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="text-[9px] font-mono font-bold uppercase tracking-widest px-2.5 py-1 bg-amber-500/10 text-amber-300 border border-amber-500/20">
                                        ZONE A • STAGE & SOUND
                                    </span>
                                    <h3 class="font-heading font-black text-2xl text-white mt-2">Главная Сцена</h3>
                                </div>
                                <button onclick="openBookingModal('Главная Сцена')" class="px-4 py-2 bg-amber-400 text-black font-heading font-bold text-xs uppercase tracking-wider hover:bg-amber-300 transition-colors" style="clip-path: polygon(0 0, calc(100% - 6px) 0, 100% 6px, 100% 100%, 6px 100%, 0 calc(100% - 6px));">
                                    Забронировать
                                </button>
                            </div>

                            <!-- Clickable Tables 1..6 -->
                            <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 mt-8">
                                @for($i = 1; $i <= 6; $i++)
                                    <button onclick="openBookingModal('Стол №{{ $i }} (Сцена)')" class="seating-btn py-3.5 text-center">
                                        <div class="text-xs font-bold text-amber-300 font-heading">№ {{ $i }}</div>
                                        <div class="text-[9px] text-slate-400 font-mono">2-4 мест</div>
                                    </button>
                                @endfor
                            </div>
                        </div>

                        <!-- Bar Island Zone -->
                        <div class="col-span-12 md:col-span-4 bg-black/70 border border-amber-500/30 p-6 flex flex-col justify-between" style="clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));">
                            <div>
                                <span class="text-[9px] font-mono font-bold uppercase tracking-widest px-2.5 py-1 bg-amber-500/10 text-amber-300 border border-amber-500/20">
                                    ZONE B • BAR
                                </span>
                                <h3 class="font-heading font-black text-2xl text-white mt-2">Барный Остров</h3>
                                <p class="text-xs text-slate-400 mt-2 font-light leading-relaxed">Авторские коктейли и живой контакт с миксологами.</p>
                            </div>
                            <button onclick="openBookingModal('Барная стойка')" class="w-full py-3 bg-amber-500/20 hover:bg-amber-500/30 border border-amber-500/40 text-amber-300 font-heading font-bold text-xs uppercase tracking-wider transition-colors mt-6" style="clip-path: polygon(0 0, calc(100% - 6px) 0, 100% 6px, 100% 100%, 6px 100%, 0 calc(100% - 6px));">
                                Забронировать бар
                            </button>
                        </div>

                        <!-- VIP Balcony Gallery -->
                        <div class="col-span-12 md:col-span-4 bg-black/70 border border-amber-500/30 p-6 flex flex-col justify-between" style="clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));">
                            <div>
                                <span class="text-[9px] font-mono font-bold uppercase tracking-widest px-2.5 py-1 bg-amber-500/10 text-amber-300 border border-amber-500/20">
                                    ZONE C • VIP VIEW
                                </span>
                                <h3 class="font-heading font-black text-xl text-white mt-2">Балконная Галерея</h3>
                                <p class="text-xs text-slate-400 mt-1 font-light">Панорамная локация с видом на сцену.</p>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-4">
                                <button onclick="openBookingModal('Стол №7 (Балкон)')" class="seating-btn py-2.5 text-center">
                                    <div class="text-xs font-bold text-amber-300 font-heading">№ 7</div>
                                    <div class="text-[9px] text-slate-400 font-mono">4-6 мест</div>
                                </button>
                                <button onclick="openBookingModal('Стол №8 (Балкон)')" class="seating-btn py-2.5 text-center">
                                    <div class="text-xs font-bold text-amber-300 font-heading">№ 8</div>
                                    <div class="text-[9px] text-slate-400 font-mono">4-6 мест</div>
                                </button>
                            </div>
                        </div>

                        <!-- Fireplace & Karaoke -->
                        <div class="col-span-12 md:col-span-5 bg-black/70 border border-amber-500/30 p-6 flex flex-col justify-between" style="clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));">
                            <div>
                                <span class="text-[9px] font-mono font-bold uppercase tracking-widest px-2.5 py-1 bg-amber-500/10 text-amber-300 border border-amber-500/20">
                                    ZONE D • LOUNGE & SOUND
                                </span>
                                <h3 class="font-heading font-black text-xl text-white mt-2">Каминная & Караоке</h3>
                                <p class="text-xs text-slate-400 mt-1 font-light">Камерная атмосфера с камином и винилом.</p>
                            </div>
                            <div class="grid grid-cols-3 gap-2 mt-4">
                                <button onclick="openBookingModal('Стол №9 (Каминная)')" class="seating-btn py-2.5 text-center">
                                    <div class="text-xs font-bold text-amber-300 font-heading">№ 9</div>
                                    <div class="text-[9px] text-slate-400 font-mono">2-4 мест</div>
                                </button>
                                <button onclick="openBookingModal('Стол №10 (Каминная)')" class="seating-btn py-2.5 text-center">
                                    <div class="text-xs font-bold text-amber-300 font-heading">№ 10</div>
                                    <div class="text-[9px] text-slate-400 font-mono">2-4 мест</div>
                                </button>
                                <button onclick="openBookingModal('Стол №11 (Каминная)')" class="seating-btn py-2.5 text-center">
                                    <div class="text-xs font-bold text-amber-300 font-heading">№ 11</div>
                                    <div class="text-[9px] text-slate-400 font-mono">6+ мест</div>
                                </button>
                            </div>
                        </div>

                        <!-- Coworking Zone -->
                        <div class="col-span-12 md:col-span-3 bg-black/70 border border-amber-500/30 p-6 flex flex-col justify-between" style="clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));">
                            <div>
                                <span class="text-[9px] font-mono font-bold uppercase tracking-widest px-2.5 py-1 bg-amber-500/10 text-amber-300 border border-amber-500/20">
                                    ZONE E • WORK & COFFEE
                                </span>
                                <h3 class="font-heading font-black text-xl text-white mt-2">Коворкинг</h3>
                                <p class="text-xs text-slate-400 mt-1 font-light">Рабочие места и спешелти кофе.</p>
                            </div>
                            <button onclick="openBookingModal('Дневной Коворкинг')" class="w-full py-3 bg-amber-400 text-black font-heading font-bold text-xs uppercase tracking-wider transition-colors mt-4 hover:bg-amber-300" style="clip-path: polygon(0 0, calc(100% - 6px) 0, 100% 6px, 100% 100%, 6px 100%, 0 calc(100% - 6px));">
                                Забронировать
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Menu Section (Kitchen & Bar) -->
        <section id="menu" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-300 text-[10px] font-heading uppercase tracking-widest mb-4">
                        // GASTRONOMY & COCKTAILS
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black font-heading text-white">В НАШЕМ МЕНЮ</h2>
                    <p class="text-slate-400 text-xs sm:text-sm mt-3">Авторская кулинария и оригинальная миксология</p>
                </div>

                <!-- Tabs Switcher -->
                <div class="flex justify-center mb-12">
                    <div class="inline-flex p-1 bg-black/90 border border-amber-500/30 backdrop-blur-3xl" style="clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 10px 100%, 0 calc(100% - 10px));">
                        <button id="tab-kitchen" onclick="switchMenu('kitchen')" class="px-8 py-3 text-xs font-heading font-bold uppercase tracking-widest transition-all duration-300 bg-amber-400 text-black" style="clip-path: polygon(0 0, calc(100% - 6px) 0, 100% 6px, 100% 100%, 6px 100%, 0 calc(100% - 6px));">
                            МЕНЮ КУХНИ
                        </button>
                        <button id="tab-bar" onclick="switchMenu('bar')" class="px-8 py-3 text-xs font-heading font-bold uppercase tracking-widest transition-all duration-300 text-slate-400 hover:text-white" style="clip-path: polygon(0 0, calc(100% - 6px) 0, 100% 6px, 100% 100%, 6px 100%, 0 calc(100% - 6px));">
                            БАРНОЕ МЕНЮ
                        </button>
                    </div>
                </div>

                <!-- Kitchen Menu Grid -->
                <div id="menu-kitchen" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($menu['kitchen'] as $item)
                        <div class="architectural-card p-6 flex flex-col justify-between group">
                            <div>
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="font-heading font-bold text-white text-base group-hover:text-amber-300 transition-colors">{{ $item['name'] }}</h4>
                                    <span class="text-base font-black font-heading text-amber-300 ml-4 whitespace-nowrap">{{ $item['price'] }}</span>
                                </div>
                                <p class="text-slate-400 text-xs mb-4 font-light leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                            <div>
                                <span class="text-[9px] font-mono uppercase tracking-widest px-2.5 py-1 bg-amber-500/10 text-amber-300 border border-amber-500/20">
                                    {{ $item['tag'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Bar Menu Grid -->
                <div id="menu-bar" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
                    @foreach($menu['bar'] as $item)
                        <div class="architectural-card p-6 flex flex-col justify-between group">
                            <div>
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="font-heading font-bold text-white text-base group-hover:text-amber-300 transition-colors">{{ $item['name'] }}</h4>
                                    <span class="text-base font-black font-heading text-amber-300 ml-4 whitespace-nowrap">{{ $item['price'] }}</span>
                                </div>
                                <p class="text-slate-400 text-xs mb-4 font-light leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                            <div>
                                <span class="text-[9px] font-mono uppercase tracking-widest px-2.5 py-1 bg-amber-500/10 text-amber-300 border border-amber-500/20">
                                    {{ $item['tag'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Loyalty Section ("Орбитальность") -->
        <section id="loyalty" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="architectural-card p-8 sm:p-14 border border-amber-500/30">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                        <div class="lg:col-span-6 space-y-6">
                            <div class="inline-flex items-center gap-2 px-3.5 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-300 text-[10px] font-heading uppercase tracking-widest">
                                // PRIVILEGE SYSTEM
                            </div>
                            <h2 class="text-3xl sm:text-5xl font-black font-heading text-white">«ОРБИТАЛЬНОСТЬ»</h2>
                            <p class="text-slate-300 text-sm sm:text-base leading-relaxed font-light">
                                Получайте кэшбэк, закрытые приглашения и доступ к спешелти мерчу. Чем выше статус, тем больше привилегий в клубе.
                            </p>

                            <!-- Interactive Points Calculator -->
                            <div class="bg-black/80 border border-amber-500/20 p-6" style="clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 10px 100%, 0 calc(100% - 10px));">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-bold text-slate-300 font-heading uppercase tracking-wider">Сумма расходов в месяц</span>
                                    <span id="calc-budget-text" class="text-amber-300 font-black font-heading text-base">25 000 ₽</span>
                                </div>
                                <input type="range" id="loyalty-slider" min="5000" max="100000" step="5000" value="25000" oninput="updateLoyaltyCalc(this.value)" class="w-full accent-amber-400 h-1.5 bg-slate-800 rounded-none cursor-pointer my-4">

                                <div class="grid grid-cols-2 gap-4 border-t border-amber-500/20 pt-4">
                                    <div>
                                        <div class="text-[9px] text-slate-400 font-mono uppercase">Ваш уровень:</div>
                                        <div id="calc-status" class="text-amber-300 font-heading font-bold text-sm mt-0.5">Уровень 2: Орбита</div>
                                    </div>
                                    <div>
                                        <div class="text-[9px] text-slate-400 font-mono uppercase">Бонусный кэшбэк:</div>
                                        <div id="calc-cashback" class="text-amber-300 font-heading font-bold text-sm mt-0.5">2 500 ₽ / мес</div>
                                    </div>
                                </div>
                            </div>

                            <a href="https://www.t.me/orbitabar_bot" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-amber-300 via-amber-400 to-amber-500 text-black font-heading font-black text-xs uppercase tracking-widest shadow-xl hover:scale-105 transition-transform" style="clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 8px, 100% 100%, 8px 100%, 0 calc(100% - 8px));">
                                РЕГИСТРИРУЙСЯ В TELEGRAM BOT
                            </a>
                        </div>

                        <!-- Tier Cards Grid -->
                        <div class="lg:col-span-6 space-y-4">
                            @foreach($loyaltyTiers as $tier)
                                <div class="architectural-card p-5 border border-amber-500/20 flex items-center justify-between">
                                    <div>
                                        <div class="text-[9px] font-mono text-amber-400/80 uppercase tracking-widest mb-0.5">LEVEL 0{{ $loop->iteration }}</div>
                                        <h4 class="font-heading font-bold text-base text-white mb-0.5">{{ $tier['tier'] }}</h4>
                                        <div class="text-xs text-slate-400 font-light">{{ $tier['perk'] }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xl font-black font-heading text-amber-300">{{ $tier['cashback'] }}</div>
                                        <div class="text-[9px] text-slate-500 font-mono uppercase">{{ $tier['condition'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Location & Contact Section -->
        <section id="contacts" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-300 text-[10px] font-heading uppercase tracking-widest">
                            // LOCATION & ROUTE
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-black font-heading text-white">ИЩИ НАС ЗДЕСЬ</h2>

                        <div class="space-y-4 text-slate-300">
                            <div class="architectural-card p-5 flex items-start gap-4">
                                <svg class="w-5 h-5 text-amber-400 shrink-0 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <div>
                                    <div class="text-[9px] text-slate-400 font-mono uppercase">Адрес</div>
                                    <div class="font-bold text-white text-sm mt-0.5">г. Москва, улица Яузская 1/15</div>
                                    <div class="text-xs text-slate-400 mt-0.5 font-light">Ближайшие станции метро: Китай-город, Таганская</div>
                                </div>
                            </div>

                            <div class="architectural-card p-5 flex items-start gap-4">
                                <svg class="w-5 h-5 text-amber-400 shrink-0 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <div>
                                    <div class="text-[9px] text-slate-400 font-mono uppercase">Время работы</div>
                                    <div class="font-bold text-white text-sm mt-0.5">Вс – Чт: 12:00 — 00:00</div>
                                    <div class="font-bold text-amber-300 text-sm">Пт – Сб: 12:00 — 03:00</div>
                                </div>
                            </div>

                            <div class="architectural-card p-5 flex items-start gap-4">
                                <svg class="w-5 h-5 text-amber-400 shrink-0 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <div>
                                    <div class="text-[9px] text-slate-400 font-mono uppercase">Бронирование & Инфо</div>
                                    <div class="font-bold text-white text-sm mt-0.5">+7 (495) 141-05-55</div>
                                    <div class="text-xs text-slate-400 mt-0.5 font-light">orbita.yauza@gmail.com</div>
                                </div>
                            </div>
                        </div>

                        <a href="https://yandex.ru/maps/org/orbita/200600732534" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-amber-300 via-amber-400 to-amber-500 text-black font-heading font-black text-xs uppercase tracking-widest shadow-xl hover:scale-105 transition-transform" style="clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 8px, 100% 100%, 8px 100%, 0 calc(100% - 8px));">
                            ПОСТРОИТЬ МАРШРУТ НА КАРТЕ
                        </a>
                    </div>

                    <!-- Interactive Map Viewport -->
                    <div class="architectural-card p-2 h-80 sm:h-auto min-h-[380px] relative bg-black/90">
                        <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Aa51483f6d6e1bdd5fd51fccd95c1ec128ee72b0b3000d23fd9abd084b712a3df&amp;source=constructor" width="100%" height="100%" frameborder="0" class="w-full h-full opacity-85 hover:opacity-100 transition-opacity"></iframe>
                    </div>

                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-amber-500/20 py-12 relative bg-black">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <span class="text-amber-300 font-heading font-black text-xl">ОРБИТА</span>
                    <span class="text-slate-600 text-xs">/</span>
                    <span class="text-slate-400 text-xs font-light">© 2026 ОРБИТА БАР. Исторический особняк на Яузской 1/15.</span>
                </div>
                <div class="flex items-center gap-6 text-slate-400 text-xs font-mono">
                    <a href="https://t.me/orbita_yauza" target="_blank" class="hover:text-amber-300 transition-colors">TELEGRAM</a>
                    <a href="https://vk.com/orbita_yauza" target="_blank" class="hover:text-amber-300 transition-colors">VKONTAKTE</a>
                    <a href="https://www.tiktok.com/@orbita_yauza" target="_blank" class="hover:text-amber-300 transition-colors">TIKTOK</a>
                </div>
            </div>
        </footer>

    </div>

    <!-- Modernist Booking Modal -->
    <div id="booking-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-3xl hidden opacity-0 transition-all duration-300">
        <div class="architectural-card bg-[#0a0c12] border border-amber-500/40 p-6 sm:p-10 max-w-lg w-full relative shadow-[0_0_80px_rgba(212,175,55,0.2)]">

            <button onclick="closeBookingModal()" class="absolute top-6 right-6 text-slate-400 hover:text-amber-300 font-bold text-xl w-8 h-8 flex items-center justify-center border border-amber-500/30 transition-colors">&times;</button>

            <div class="flex items-center gap-2 mb-2">
                <span class="w-2 h-2 bg-amber-400 animate-ping"></span>
                <span class="text-[10px] uppercase font-mono tracking-widest text-amber-300">// RESERVATION SYSTEM</span>
            </div>

            <h3 class="font-heading font-black text-2xl sm:text-3xl text-white mb-1">БРОНИРОВАНИЕ</h3>
            <p id="modal-subtitle" class="text-xs text-slate-400 mb-8 font-mono">Локация: Главная сцена</p>

            <form id="booking-form" onsubmit="submitBooking(event)" class="space-y-4">
                <input type="hidden" id="booking-zone" name="zone" value="Главная сцена">
                <input type="hidden" id="booking-guests" name="guests" value="2">

                <div>
                    <label class="block text-[10px] uppercase font-mono tracking-wider text-slate-300 mb-1">Ваше имя</label>
                    <input type="text" name="name" required class="w-full bg-black/60 border border-amber-500/20 px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-400 transition-colors font-mono" placeholder="Иван Иванов">
                </div>

                <div>
                    <label class="block text-[10px] uppercase font-mono tracking-wider text-slate-300 mb-1">Телефон</label>
                    <input type="tel" name="phone" required class="w-full bg-black/60 border border-amber-500/20 px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-400 transition-colors font-mono" placeholder="+7 (999) 000-00-00">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase font-mono tracking-wider text-slate-300 mb-1">Дата</label>
                        <input type="date" name="date" required class="w-full bg-black/60 border border-amber-500/20 px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-400 transition-colors font-mono">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase font-mono tracking-wider text-slate-300 mb-1">Время</label>
                        <input type="time" name="time" required class="w-full bg-black/60 border border-amber-500/20 px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-400 transition-colors font-mono">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] uppercase font-mono tracking-wider text-slate-300 mb-2">Количество гостей</label>
                    <div class="grid grid-cols-4 gap-2">
                        <button type="button" onclick="selectGuests(1, this)" class="guest-pill py-2.5 text-xs font-mono">1 гость</button>
                        <button type="button" onclick="selectGuests(2, this)" class="guest-pill py-2.5 text-xs font-mono active">2 гостя</button>
                        <button type="button" onclick="selectGuests(4, this)" class="guest-pill py-2.5 text-xs font-mono">4 гостя</button>
                        <button type="button" onclick="selectGuests(6, this)" class="guest-pill py-2.5 text-xs font-mono">6+ гостей</button>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 mt-4 bg-gradient-to-r from-amber-300 via-amber-400 to-amber-500 text-black font-heading font-black text-xs uppercase tracking-widest shadow-xl hover:scale-[1.02] transition-transform" style="clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 8px, 100% 100%, 8px 100%, 0 calc(100% - 8px));">
                    ПОДТВЕРДИТЬ БРОНИРОВАНИЕ
                </button>
            </form>

            <div id="booking-success" class="hidden text-center py-8">
                <div class="w-12 h-12 border border-amber-400 text-amber-300 flex items-center justify-center mx-auto mb-4 font-mono text-xl">✓</div>
                <h4 class="font-heading font-bold text-2xl text-white mb-2">БРОНЬ ПОДТВЕРЖДЕНА!</h4>
                <p class="text-slate-300 text-xs max-w-xs mx-auto leading-relaxed font-light">Система зафиксировала ваш визит. Ждем вас на Яузской 1/15!</p>
            </div>
        </div>
    </div>

    <!-- WebGL Three.js Photorealistic Shader Moon Engine -->
    <script>
        // --- 1. THREE.JS REALISTIC SHADER MOON & CELESTIAL ATMOSPHERE ---
        const container = document.getElementById('moon-canvas-container');
        const scene = new THREE.Scene();
        scene.fog = new THREE.FogExp2(0x050507, 0.012);

        const camera = new THREE.PerspectiveCamera(48, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.z = 22;

        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        container.appendChild(renderer.domElement);

        // Lighting System
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.2);
        scene.add(ambientLight);

        // Primary Sun Illumination Vector
        const sunLight = new THREE.DirectionalLight(0xfff5db, 4.0);
        sunLight.position.set(18, 12, 16);
        scene.add(sunLight);

        // Subtle Champagne Rim Lighting
        const rimLight = new THREE.DirectionalLight(0xd4af37, 1.2);
        rimLight.position.set(-20, -10, -5);
        scene.add(rimLight);

        // Moon Container Group
        const moonGroup = new THREE.Group();
        scene.add(moonGroup);

        const moonGeo = new THREE.SphereGeometry(5.8, 128, 128);

        // Photorealistic Procedural Lunar Texture Generator
        function generatePhotorealisticMoonTexture() {
            const canvas = document.createElement('canvas');
            canvas.width = 2048;
            canvas.height = 1024;
            const ctx = canvas.getContext('2d');

            // High dynamic range realistic lunar regolith base texture
            const grad = ctx.createLinearGradient(0, 0, 0, 1024);
            grad.addColorStop(0, '#585a66');
            grad.addColorStop(0.4, '#9a9ca8');
            grad.addColorStop(0.7, '#737582');
            grad.addColorStop(1, '#424450');
            ctx.fillStyle = grad;
            ctx.fillRect(0, 0, 2048, 1024);

            // Fine Regolith Micro-Noise Grain
            const imgData = ctx.getImageData(0, 0, 2048, 1024);
            const data = imgData.data;
            for (let i = 0; i < data.length; i += 4) {
                const noise = (Math.random() - 0.5) * 22;
                data[i] = Math.min(255, Math.max(0, data[i] + noise));
                data[i+1] = Math.min(255, Math.max(0, data[i+1] + noise));
                data[i+2] = Math.min(255, Math.max(0, data[i+2] + noise));
            }
            ctx.putImageData(imgData, 0, 0);

            // Procedural Lunar Maria (Dark Volcanic Basalt Plains)
            const mariaList = [
                {x: 650, y: 380, rx: 280, ry: 200, a: -0.2},
                {x: 1000, y: 320, rx: 220, ry: 160, a: 0.3},
                {x: 1280, y: 440, rx: 310, ry: 240, a: -0.1},
                {x: 420, y: 520, rx: 180, ry: 130, a: 0.4},
                {x: 1550, y: 340, rx: 230, ry: 170, a: 0.15}
            ];

            mariaList.forEach(m => {
                const mGrad = ctx.createRadialGradient(m.x, m.y, 10, m.x, m.y, m.rx);
                mGrad.addColorStop(0, 'rgba(28, 30, 38, 0.7)');
                mGrad.addColorStop(0.6, 'rgba(45, 48, 58, 0.45)');
                mGrad.addColorStop(1, 'rgba(90, 92, 102, 0)');
                ctx.fillStyle = mGrad;
                ctx.beginPath();
                ctx.ellipse(m.x, m.y, m.rx, m.ry, m.a, 0, Math.PI * 2);
                ctx.fill();
            });

            // Realistic Impact Craters with Ejecta Rays & Soft Rims
            for (let i = 0; i < 350; i++) {
                const x = Math.random() * 2048;
                const y = Math.random() * 1024;
                const r = 3 + Math.random() * 32;

                // Outer Ejecta Blanket / Rim
                const craterGrad = ctx.createRadialGradient(x, y, 0, x, y, r);
                craterGrad.addColorStop(0, 'rgba(22, 24, 30, 0.75)');
                craterGrad.addColorStop(0.55, 'rgba(40, 42, 52, 0.4)');
                craterGrad.addColorStop(0.8, 'rgba(215, 220, 230, 0.35)'); // Highlighted rim
                craterGrad.addColorStop(1, 'rgba(100, 105, 115, 0)');

                ctx.fillStyle = craterGrad;
                ctx.beginPath();
                ctx.arc(x, y, r, 0, Math.PI * 2);
                ctx.fill();
            }

            return new THREE.CanvasTexture(canvas);
        }

        const moonTexture = generatePhotorealisticMoonTexture();

        const moonMat = new THREE.MeshStandardMaterial({
            map: moonTexture,
            roughness: 0.85,
            metalness: 0.02,
            bumpMap: moonTexture,
            bumpScale: 0.08
        });

        const moonMesh = new THREE.Mesh(moonGeo, moonMat);
        moonMesh.position.set(7.2, 1.8, -2);
        moonGroup.add(moonMesh);

        // Fine Champagne Orbital Ring
        const ringGeo = new THREE.TorusGeometry(10.2, 0.04, 16, 160);
        const ringMat = new THREE.MeshBasicMaterial({ color: 0xd4af37, transparent: true, opacity: 0.45 });
        const ringMesh = new THREE.Mesh(ringGeo, ringMat);
        ringMesh.position.set(7.2, 1.8, -2);
        ringMesh.rotation.x = Math.PI / 2.6;
        moonGroup.add(ringMesh);

        // Background Star Dust
        const starCount = 1000;
        const starGeo = new THREE.BufferGeometry();
        const starPos = new Float32Array(starCount * 3);

        for (let i = 0; i < starCount * 3; i += 3) {
            starPos[i] = (Math.random() - 0.5) * 140;
            starPos[i + 1] = (Math.random() - 0.5) * 140;
            starPos[i + 2] = (Math.random() - 0.5) * 140;
        }

        starGeo.setAttribute('position', new THREE.BufferAttribute(starPos, 3));
        const starMat = new THREE.PointsMaterial({ size: 0.15, color: 0xffffff, transparent: true, opacity: 0.6 });
        const starfield = new THREE.Points(starGeo, starMat);
        scene.add(starfield);

        // Mouse Parallax Interaction
        let mouseX = 0, mouseY = 0;
        let targetX = 0, targetY = 0;

        window.addEventListener('mousemove', (e) => {
            mouseX = (e.clientX - window.innerWidth / 2) * 0.0006;
            mouseY = (e.clientY - window.innerHeight / 2) * 0.0006;
        });

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        // Smooth Animation Render Loop
        const clock = new THREE.Clock();

        function animate() {
            requestAnimationFrame(animate);
            const delta = clock.getElapsedTime();

            targetX += (mouseX - targetX) * 0.04;
            targetY += (mouseY - targetY) * 0.04;

            moonMesh.rotation.y = delta * 0.06 + targetX * 2.5;
            moonMesh.rotation.x = Math.sin(delta * 0.08) * 0.08 + targetY * 2.5;

            ringMesh.rotation.z = delta * 0.12;
            starfield.rotation.y = delta * 0.008;

            renderer.render(scene, camera);
        }

        animate();

        // --- 2. MOON PHASE LOGIC ---
        function rotateMoonPhase(phase) {
            if (phase === 'full') {
                sunLight.position.set(10, 10, 25);
                sunLight.intensity = 4.5;
            } else if (phase === 'crescent') {
                sunLight.position.set(-25, 5, 8);
                sunLight.intensity = 3.2;
            } else if (phase === 'eclipse') {
                sunLight.position.set(0, -25, -12);
                sunLight.intensity = 0.6;
            }
        }

        // --- 3. DAY / NIGHT ATMOSPHERE SWITCHER ---
        let isDayMode = false;
        function toggleDayNightMode() {
            isDayMode = !isDayMode;
            const body = document.body;
            const modeLabel = document.getElementById('mode-label');

            if (isDayMode) {
                body.classList.add('theme-day');
                modeLabel.innerText = 'DAY MODE';
                scene.fog.color.setHex(0x0b0d14);
                sunLight.color.setHex(0xffe29d);
            } else {
                body.classList.remove('theme-day');
                modeLabel.innerText = 'NIGHT MODE';
                scene.fog.color.setHex(0x050507);
                sunLight.color.setHex(0xfff5db);
            }
        }

        // --- 4. LOYALTY CALCULATOR ---
        function updateLoyaltyCalc(val) {
            const budgetText = document.getElementById('calc-budget-text');
            const statusText = document.getElementById('calc-status');
            const cashbackText = document.getElementById('calc-cashback');

            budgetText.innerText = new Intl.NumberFormat('ru-RU').format(val) + ' ₽';

            let status = 'Уровень 1: Спутник (5%)';
            let percent = 0.05;

            if (val >= 50000) {
                status = 'Уровень 3: Гравитация (15%)';
                percent = 0.15;
            } else if (val >= 20000) {
                status = 'Уровень 2: Орбита (10%)';
                percent = 0.10;
            }

            const cashback = Math.round(val * percent);
            statusText.innerText = status;
            cashbackText.innerText = new Intl.NumberFormat('ru-RU').format(cashback) + ' ₽ / мес';
        }

        // --- 5. GUEST PILLS ---
        function selectGuests(count, btn) {
            document.getElementById('booking-guests').value = count;
            document.querySelectorAll('.guest-pill').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }

        // --- 6. MENU SWITCHER ---
        function switchMenu(type) {
            const kitchenMenu = document.getElementById('menu-kitchen');
            const barMenu = document.getElementById('menu-bar');
            const tabKitchen = document.getElementById('tab-kitchen');
            const tabBar = document.getElementById('tab-bar');

            if (type === 'kitchen') {
                kitchenMenu.classList.remove('hidden');
                barMenu.classList.add('hidden');
                tabKitchen.className = "px-8 py-3 text-xs font-heading font-bold uppercase tracking-widest transition-all duration-300 bg-amber-400 text-black";
                tabBar.className = "px-8 py-3 text-xs font-heading font-bold uppercase tracking-widest transition-all duration-300 text-slate-400 hover:text-white";
            } else {
                barMenu.classList.remove('hidden');
                kitchenMenu.classList.add('hidden');
                tabBar.className = "px-8 py-3 text-xs font-heading font-bold uppercase tracking-widest transition-all duration-300 bg-amber-400 text-black";
                tabKitchen.className = "px-8 py-3 text-xs font-heading font-bold uppercase tracking-widest transition-all duration-300 text-slate-400 hover:text-white";
            }
        }

        // --- 7. MODAL & AJAX ---
        function openBookingModal(zoneName) {
            document.getElementById('booking-zone').value = zoneName;
            document.getElementById('modal-subtitle').innerText = 'Локация: ' + zoneName;
            const modal = document.getElementById('booking-modal');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('opacity-0'), 10);
        }

        function closeBookingModal() {
            const modal = document.getElementById('booking-modal');
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.getElementById('booking-form').classList.remove('hidden');
                document.getElementById('booking-success').classList.add('hidden');
            }, 300);
        }

        function submitBooking(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            fetch('/api/bookings', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    form.classList.add('hidden');
                    document.getElementById('booking-success').classList.remove('hidden');
                } else {
                    alert('Ошибка бронирования.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Ошибка отправки.');
            });
        }
    </script>
</body>
</html>
