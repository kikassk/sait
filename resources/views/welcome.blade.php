<!DOCTYPE html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ОРБИТА // ТВОРЧЕСКИЙ КЛАСТЕР & БАР-ТРАНСФОРМЕР</title>
    <meta name="description" content="Авангардное пространство на Яузской 1/15. Авторская кухня, актуальный звук, 3D сингулярность.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts: Unbounded, Syne & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,300;0,500;0,800;1,400&family=Syne:wght@500;700;800&family=Unbounded:wght@300;500;700;900&display=swap" rel="stylesheet">

    <!-- Three.js Engine -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    @vite(['resources/css/app.css'])

    <style>
        :root {
            --bg-void: #020204;
            --card-glass: rgba(8, 10, 16, 0.75);
            --neon-cyan: #00f0ff;
            --neon-purple: #a855f7;
            --chrome-silver: #cbd5e1;
            --hud-border: rgba(0, 240, 255, 0.2);
            --hud-glow: rgba(0, 240, 255, 0.12);
        }

        body {
            font-family: 'Syne', sans-serif;
            background-color: var(--bg-void);
            color: #f1f5f9;
            overflow-x: hidden;
            selection-background-color: #00f0ff;
            selection-color: #000;
        }

        .font-heading {
            font-family: 'Unbounded', sans-serif;
        }

        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }

        /* 3D WebGL Canvas Viewport */
        #singularity-canvas-container {
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

        /* Avant-Garde Asymmetrical Cyber Cards */
        .cyber-panel {
            background: var(--card-glass);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--hud-border);
            clip-path: polygon(
                0 0,
                calc(100% - 20px) 0,
                100% 20px,
                100% 100%,
                20px 100%,
                0 calc(100% - 20px)
            );
            position: relative;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .cyber-panel-alt {
            background: var(--card-glass);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(168, 85, 247, 0.25);
            clip-path: polygon(
                20px 0,
                100% 0,
                100% calc(100% - 20px),
                calc(100% - 20px) 100%,
                0 100%,
                0 20px
            );
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .cyber-panel:hover {
            border-color: var(--neon-cyan);
            box-shadow: 0 0 35px var(--hud-glow);
            transform: translateY(-3px) scale(1.005);
        }

        .cyber-panel-alt:hover {
            border-color: var(--neon-purple);
            box-shadow: 0 0 35px rgba(168, 85, 247, 0.2);
            transform: translateY(-3px) scale(1.005);
        }

        /* Non-Standard Diagonal Decorative Lines */
        .diag-stripe {
            background: repeating-linear-gradient(
                -45deg,
                rgba(0, 240, 255, 0.05),
                rgba(0, 240, 255, 0.05) 8px,
                transparent 8px,
                transparent 16px
            );
        }

        /* Glass HUD Header */
        .cyber-nav {
            background: rgba(2, 2, 4, 0.85);
            backdrop-filter: blur(32px);
            border-bottom: 1px solid var(--hud-border);
        }

        /* Continuous Kinetic Ticker */
        @keyframes tickerLoop {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-ticker {
            display: flex;
            width: 200%;
            animation: tickerLoop 25s linear infinite;
        }

        /* Glitch Gradient Text */
        .text-cyan-purple-gradient {
            background: linear-gradient(135deg, #00f0ff 0%, #a855f7 50%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Neon Corner Indicators */
        .hud-corner-tl {
            position: absolute;
            top: -1px;
            left: -1px;
            width: 8px;
            height: 8px;
            border-top: 2px solid var(--neon-cyan);
            border-left: 2px solid var(--neon-cyan);
        }
        .hud-corner-br {
            position: absolute;
            bottom: -1px;
            right: -1px;
            width: 8px;
            height: 8px;
            border-bottom: 2px solid var(--neon-cyan);
            border-right: 2px solid var(--neon-cyan);
        }

        /* Day/Night Theme Override */
        body.theme-day {
            --bg-void: #060913;
            --card-glass: rgba(12, 18, 30, 0.85);
            --neon-cyan: #38bdf8;
            --hud-border: rgba(56, 189, 248, 0.3);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #020204;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #00f0ff;
        }
    </style>
</head>
<body class="bg-[#020204] text-slate-100 antialiased selection:bg-cyan-400 selection:text-black">

    <!-- 3D WebGL WebGL Singularity Canvas -->
    <div id="singularity-canvas-container"></div>

    <div class="content-layer">

        <!-- Avant-Garde Navigation Header -->
        <header class="fixed top-0 left-0 right-0 z-50 cyber-nav" id="navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between">

                <!-- Brand Logo / HUD Tag -->
                <a href="#hero" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-black/90 border border-cyan-500/50 flex items-center justify-center relative group-hover:border-cyan-400 transition-all shadow-[0_0_15px_rgba(0,240,255,0.2)]" style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%);">
                        <!-- Custom Geometric Vector Icon -->
                        <svg class="w-5 h-5 text-cyan-400 group-hover:rotate-90 transition-transform duration-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"/>
                            <polyline points="2 17 12 22 22 17"/>
                            <polyline points="2 12 12 17 22 12"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-base font-black font-heading tracking-[0.3em] text-white group-hover:text-cyan-400 transition-colors flex items-center gap-2">
                            ОРБИТА
                            <span class="text-[9px] font-mono px-1.5 py-0.5 border border-cyan-500/40 text-cyan-400 bg-cyan-950/40">SYS.01</span>
                        </div>
                        <div class="text-[9px] font-mono uppercase tracking-widest text-slate-400 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 bg-cyan-400 animate-pulse"></span>
                            ЯУЗСКАЯ 1/15 // MOSCOW
                        </div>
                    </div>
                </a>

                <!-- Asymmetrical HUD Nav Links -->
                <nav class="hidden lg:flex items-center gap-6 bg-black/80 border border-cyan-500/30 px-6 py-2.5 backdrop-blur-2xl" style="clip-path: polygon(12px 0, 100% 0, calc(100% - 12px) 100%, 0 100%);">
                    <a href="#about" class="text-[11px] font-mono uppercase tracking-widest text-slate-300 hover:text-cyan-400 transition-colors">// КОНЦЕПЦИЯ</a>
                    <a href="#seating" class="text-[11px] font-mono uppercase tracking-widest text-slate-300 hover:text-cyan-400 transition-colors">// БЛУПРИНТ</a>
                    <a href="#menu" class="text-[11px] font-mono uppercase tracking-widest text-slate-300 hover:text-cyan-400 transition-colors">// МЕНЮ</a>
                    <a href="#loyalty" class="text-[11px] font-mono uppercase tracking-widest text-slate-300 hover:text-cyan-400 transition-colors">// СИНГУЛЯРНОСТЬ</a>
                    <a href="#contacts" class="text-[11px] font-mono uppercase tracking-widest text-slate-300 hover:text-cyan-400 transition-colors">// ЛОКАЦИЯ</a>
                </nav>

                <!-- Atmosphere Controls & Reservation Trigger -->
                <div class="flex items-center gap-3">
                    <button id="mode-toggle-btn" onclick="toggleDayNightMode()" class="px-3.5 py-2 bg-black/80 border border-purple-500/40 text-[10px] font-mono text-purple-300 hover:border-purple-400 transition-all flex items-center gap-2" style="clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 8px, 100% 100%, 8px 100%, 0 calc(100% - 8px));">
                        <!-- Custom HUD Diamond Icon -->
                        <svg class="w-3.5 h-3.5 text-purple-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" transform="rotate(45 12 12)"/>
                        </svg>
                        <span id="mode-label" class="hidden sm:inline tracking-wider">NIGHT MATRIX</span>
                    </button>

                    <button onclick="openBookingModal('Главный Холл')" class="px-6 py-2.5 text-xs font-mono font-bold bg-cyan-400 text-black hover:bg-cyan-300 transition-all shadow-[0_0_20px_rgba(0,240,255,0.4)] flex items-center gap-2" style="clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 10px 100%, 0 calc(100% - 10px));">
                        <span class="uppercase tracking-wider">БРОНИРОВАТЬ</span>
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </button>
                </div>
            </div>
        </header>

        <!-- Avant-Garde Hero Section -->
        <section id="hero" class="relative min-h-screen flex items-center justify-center pt-32 pb-20 overflow-hidden">

            <!-- Side Telemetry Vertical HUD Bar (Desktop) -->
            <div class="hidden xl:flex fixed left-6 top-1/2 -translate-y-1/2 flex-col items-center gap-8 z-20 text-[9px] font-mono text-slate-500 uppercase tracking-widest">
                <div class="rotate-90 origin-left whitespace-nowrap">// SYSTEM_STATUS: ONLINE</div>
                <div class="w-px h-16 bg-cyan-500/30"></div>
                <div class="rotate-90 origin-left whitespace-nowrap">LAT: 55.7512 | LON: 37.6184</div>
            </div>

            <div class="max-w-6xl mx-auto px-4 text-center relative z-10">

                <!-- HUD Protocol Badge -->
                <div class="inline-flex items-center gap-3 px-4 py-1.5 bg-black/90 border border-cyan-500/40 text-cyan-300 font-mono text-xs uppercase tracking-widest mb-8" style="clip-path: polygon(10px 0, 100% 0, calc(100% - 10px) 100%, 0 100%);">
                    <svg class="w-3.5 h-3.5 text-cyan-400 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a10 10 0 0 1 10 10"/></svg>
                    <span>ИСТОРИЧЕСКИЙ ОСОБНЯК // ПРОЕКТ ВАНИ ДМИТРИЕНКО</span>
                </div>

                <!-- Main Kinetic Asymmetrical Title -->
                <h1 class="text-4xl sm:text-7xl md:text-8xl lg:text-9xl font-black font-heading tracking-tight text-white mb-8 leading-[0.9] text-left sm:text-center">
                    ДВИГАЙСЯ <br/>
                    <span class="text-cyan-purple-gradient relative inline-block">
                        ВМЕСТЕ С ОРБИТОЙ
                        <span class="absolute -top-3 -right-6 text-[10px] font-mono font-normal text-cyan-400 border border-cyan-500/30 px-2 py-0.5 hidden sm:inline-block">v2.0</span>
                    </span>
                </h1>

                <!-- Asymmetrical Dual Protocol Cards -->
                <div class="max-w-3xl mx-auto mb-12 grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                    <!-- Day Protocol -->
                    <div class="cyber-panel p-6 relative">
                        <div class="hud-corner-tl"></div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-mono font-bold uppercase tracking-wider text-cyan-400 flex items-center gap-2">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                                ДНЕВНОЙ ПРОТОКОЛ
                            </span>
                            <span class="text-[10px] text-slate-500 font-mono">// 12:00 — 18:00</span>
                        </div>
                        <p class="text-xs text-slate-300 font-light leading-relaxed">Фэнси-бар с авторской кухней, тихим коворкингом и лекциями творческого кластера.</p>
                    </div>

                    <!-- Night Protocol -->
                    <div class="cyber-panel-alt p-6 relative">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-mono font-bold uppercase tracking-wider text-purple-400 flex items-center gap-2">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10 10 10 0 0 0-10-10z"/><path d="M12 18a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"/></svg>
                                НОЧНОЙ МАТРИКС
                            </span>
                            <span class="text-[10px] text-slate-500 font-mono">// 18:00 — 03:00</span>
                        </div>
                        <p class="text-xs text-slate-300 font-light leading-relaxed">Актуальный sound-дизайн, диджей-сеты артистов, авторская миксология и трансформация зала.</p>
                    </div>
                </div>

                <!-- Action Triggers -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <button onclick="openBookingModal('Главная Сцена')" class="w-full sm:w-auto px-10 py-4 bg-cyan-400 hover:bg-cyan-300 text-black font-mono font-bold text-xs uppercase tracking-widest shadow-[0_0_25px_rgba(0,240,255,0.3)] transition-all" style="clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));">
                        [ ЗАБРОНИРОВАТЬ СТОЛ ]
                    </button>
                    <a href="#seating" class="w-full sm:w-auto px-10 py-4 bg-black/80 hover:bg-cyan-950/40 border border-cyan-500/40 text-cyan-300 font-mono font-bold text-xs uppercase tracking-widest transition-all" style="clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));">
                        ИНТЕРАКТИВНЫЙ БЛУПРИНТ
                    </a>
                </div>

                <!-- Location HUD Bar -->
                <div class="mt-16 inline-flex flex-wrap items-center justify-center gap-6 px-6 py-3 bg-black/90 border border-cyan-500/30 text-xs text-slate-300 font-mono backdrop-blur-xl" style="clip-path: polygon(12px 0, 100% 0, calc(100% - 12px) 100%, 0 100%);">
                    <span class="flex items-center gap-2 text-cyan-400">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/><circle cx="12" cy="10" r="3"/></svg>
                        Яузская ул., 1/15
                    </span>
                    <span class="text-slate-600">//</span>
                    <span>м. Китай-город / Таганская</span>
                    <span class="text-slate-600">//</span>
                    <span class="text-purple-300">Вс–Чт: 12:00–00:00 | Пт–Сб: 12:00–03:00</span>
                </div>
            </div>
        </section>

        <!-- Kinetic Cyber Marquee -->
        <div class="w-full bg-black border-y border-cyan-500/30 py-2.5 overflow-hidden font-mono text-[11px] uppercase tracking-[0.25em] text-cyan-400/90 diag-stripe">
            <div class="animate-ticker whitespace-nowrap flex items-center gap-12">
                <span>[✦ ОРБИТА — АВАНГАРДНЫЙ ТРАНСФОРМЕР]</span>
                <span>[✦ SOUND ENGINE BY VANYA DMITRIENKO]</span>
                <span>[✦ 3D SINGULARITY INTERACTION]</span>
                <span>[✦ ИСТОРИЧЕСКИЙ ОСОБНЯК НА ЯУЗСКОЙ]</span>
                <span>[✦ ОРБИТА — АВАНГАРДНЫЙ ТРАНСФОРМЕР]</span>
                <span>[✦ SOUND ENGINE BY VANYA DMITRIENKO]</span>
                <span>[✦ 3D SINGULARITY INTERACTION]</span>
                <span>[✦ ИСТОРИЧЕСКИЙ ОСОБНЯК НА ЯУЗСКОЙ]</span>
            </div>
        </div>

        <!-- Concept & Singularity Section -->
        <section id="about" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                    <!-- Concept Text -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-cyan-950/40 border border-cyan-500/40 text-cyan-400 font-mono text-[10px] uppercase tracking-widest">
                            // CONCEPT MATRIX
                        </div>

                        <h2 class="text-3xl sm:text-5xl font-black font-heading text-white leading-tight">
                            БАР, ГДЕ <span class="text-cyan-purple-gradient">ЗВЕЗДНЫЕ ОРБИТЫ</span> ПЕРЕСЕКАЮТСЯ В РЕАЛЬНОМ ВРЕМЕНИ
                        </h2>

                        <p class="text-slate-300 text-sm sm:text-base leading-relaxed font-light">
                            «Встретимся на Орбите! Здесь тебя ждут авторские кухня и бар, креативные квартирники, джемы с молодыми артистами и уютная атмосфера исторического особняка.»
                        </p>

                        <div class="cyber-panel p-6 border-l-2 border-l-cyan-400">
                            <div class="text-xs font-mono font-bold text-cyan-400 mb-1">// ВАНЯ ДМИТРИЕНКО</div>
                            <p class="text-xs text-slate-400 italic font-light leading-relaxed">«Я давно мечтал о месте, где смогу собирать друзей и единомышленников. Пространство, в котором соединены музыка, вкус, вдохновение и неформальное общение.»</p>
                        </div>

                        <!-- 3 Asymmetrical HUD Cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 font-mono">
                            <div class="cyber-panel p-4">
                                <div class="text-cyan-400 font-bold text-xl mb-1">#01</div>
                                <div class="text-xs font-bold text-white mb-1">Кластер</div>
                                <div class="text-[10px] text-slate-400">Маркеты и арт-события</div>
                            </div>
                            <div class="cyber-panel p-4">
                                <div class="text-purple-400 font-bold text-xl mb-1">#02</div>
                                <div class="text-xs font-bold text-white mb-1">Трансформер</div>
                                <div class="text-[10px] text-slate-400">Коворкинг → Клуб</div>
                            </div>
                            <div class="cyber-panel p-4">
                                <div class="text-cyan-400 font-bold text-xl mb-1">#03</div>
                                <div class="text-xs font-bold text-white mb-1">Гастрономия</div>
                                <div class="text-[10px] text-slate-400">Авторский фьюжн</div>
                            </div>
                        </div>
                    </div>

                    <!-- Interactive 3D Singularity Control Matrix -->
                    <div class="lg:col-span-5">
                        <div class="cyber-panel p-8 border border-purple-500/40 text-center relative">
                            <div class="hud-corner-br"></div>
                            <div class="text-xs font-mono font-bold uppercase tracking-widest text-purple-300 mb-2 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 text-purple-400 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M1 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
                                3D SINGULARITY ENGINE CONTROLS
                            </div>
                            <p class="text-xs text-slate-400 mb-6 font-mono">Управление геометрической формой 3D ядра в реальном времени</p>

                            <div class="space-y-3 font-mono text-xs">
                                <button onclick="setSingularityMode('hyperdrive')" class="w-full py-3 px-4 bg-black/80 hover:bg-cyan-950/50 border border-cyan-500/30 text-cyan-300 transition-all flex items-center justify-between" style="clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 8px, 100% 100%, 8px 100%, 0 calc(100% - 8px));">
                                    <span>[01] HYPERDRIVE PULSE</span>
                                    <span>&rarr;</span>
                                </button>
                                <button onclick="setSingularityMode('wireframe')" class="w-full py-3 px-4 bg-black/80 hover:bg-purple-950/50 border border-purple-500/30 text-purple-300 transition-all flex items-center justify-between" style="clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 8px, 100% 100%, 8px 100%, 0 calc(100% - 8px));">
                                    <span>[02] NEON WIREFRAME MATRIX</span>
                                    <span>&rarr;</span>
                                </button>
                                <button onclick="setSingularityMode('void')" class="w-full py-3 px-4 bg-black/80 hover:bg-slate-900 border border-slate-700 text-slate-300 transition-all flex items-center justify-between" style="clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 8px, 100% 100%, 8px 100%, 0 calc(100% - 8px));">
                                    <span>[03] VOID ACCRETION DISK</span>
                                    <span>&rarr;</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Interactive Seating Blueprint Matrix -->
        <section id="seating" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-cyan-950/40 border border-cyan-500/40 text-cyan-400 font-mono text-[10px] uppercase tracking-widest mb-3">
                        // BLUEPRINT MATRIX
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black font-heading text-white">ПЛАН РАССАДКИ</h2>
                    <p class="text-slate-400 text-xs sm:text-sm mt-2 font-mono">Выберите сектор для бронирования места</p>
                </div>

                <!-- Blueprint Grid -->
                <div class="cyber-panel p-6 sm:p-10 border border-cyan-500/40">
                    <div class="grid grid-cols-12 gap-6 min-h-[440px]">

                        <!-- Zone A: Stage Core -->
                        <div class="col-span-12 md:col-span-8 bg-black/80 border border-cyan-500/40 p-6 flex flex-col justify-between relative group" style="clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 16px 100%, 0 calc(100% - 16px));">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="text-[9px] font-mono uppercase tracking-widest px-2.5 py-1 bg-cyan-950/60 text-cyan-300 border border-cyan-500/30">
                                        SECTOR 01 // STAGE CORE
                                    </span>
                                    <h3 class="font-heading font-black text-2xl text-white mt-2">Главная Сцена & Танцпол</h3>
                                </div>
                                <button onclick="openBookingModal('Главная Сцена')" class="px-4 py-2 bg-cyan-400 text-black font-mono font-bold text-xs uppercase hover:bg-cyan-300 transition-colors" style="clip-path: polygon(0 0, calc(100% - 6px) 0, 100% 6px, 100% 100%, 6px 100%, 0 calc(100% - 6px));">
                                    ЗАБРОНИРОВАТЬ
                                </button>
                            </div>

                            <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 mt-8 font-mono">
                                @for($i = 1; $i <= 6; $i++)
                                    <button onclick="openBookingModal('Стол №{{ $i }} (Сцена)')" class="p-3 text-center bg-black border border-cyan-500/20 hover:border-cyan-400 hover:bg-cyan-950/30 transition-all">
                                        <div class="text-xs font-bold text-cyan-300">№ {{ $i }}</div>
                                        <div class="text-[9px] text-slate-500">2-4 МЕСТ</div>
                                    </button>
                                @endfor
                            </div>
                        </div>

                        <!-- Zone B: Bar Matrix -->
                        <div class="col-span-12 md:col-span-4 bg-black/80 border border-purple-500/40 p-6 flex flex-col justify-between" style="clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 16px 100%, 0 calc(100% - 16px));">
                            <div>
                                <span class="text-[9px] font-mono uppercase tracking-widest px-2.5 py-1 bg-purple-950/60 text-purple-300 border border-purple-500/30">
                                    SECTOR 02 // BAR ISLAND
                                </span>
                                <h3 class="font-heading font-black text-2xl text-white mt-2">Барный Остров</h3>
                                <p class="text-xs text-slate-400 mt-2 font-mono leading-relaxed">Контактная стойка с миксологами и авторской картой.</p>
                            </div>
                            <button onclick="openBookingModal('Барный Остров')" class="w-full py-3 bg-purple-950/50 hover:bg-purple-900/60 border border-purple-500/40 text-purple-300 font-mono font-bold text-xs uppercase tracking-wider transition-colors mt-6">
                                [ БАРНАЯ СТОЙКА ]
                            </button>
                        </div>

                        <!-- Zone C: VIP Gallery -->
                        <div class="col-span-12 md:col-span-4 bg-black/80 border border-cyan-500/30 p-6 flex flex-col justify-between" style="clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 16px 100%, 0 calc(100% - 16px));">
                            <div>
                                <span class="text-[9px] font-mono uppercase tracking-widest px-2.5 py-1 bg-cyan-950/60 text-cyan-300 border border-cyan-500/30">
                                    SECTOR 03 // VIP GALLERY
                                </span>
                                <h3 class="font-heading font-black text-xl text-white mt-2">Балконная Галерея</h3>
                                <p class="text-xs text-slate-400 mt-1 font-mono">Панорамный вид на сцену.</p>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-4 font-mono">
                                <button onclick="openBookingModal('Стол №7 (Балкон)')" class="p-2.5 text-center bg-black border border-cyan-500/20 hover:border-cyan-400">
                                    <div class="text-xs font-bold text-cyan-300">№ 7 (VIP)</div>
                                </button>
                                <button onclick="openBookingModal('Стол №8 (Балкон)')" class="p-2.5 text-center bg-black border border-cyan-500/20 hover:border-cyan-400">
                                    <div class="text-xs font-bold text-cyan-300">№ 8 (VIP)</div>
                                </button>
                            </div>
                        </div>

                        <!-- Zone D: Lounge Fireplace -->
                        <div class="col-span-12 md:col-span-5 bg-black/80 border border-cyan-500/30 p-6 flex flex-col justify-between" style="clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 16px 100%, 0 calc(100% - 16px));">
                            <div>
                                <span class="text-[9px] font-mono uppercase tracking-widest px-2.5 py-1 bg-cyan-950/60 text-cyan-300 border border-cyan-500/30">
                                    SECTOR 04 // LOUNGE
                                </span>
                                <h3 class="font-heading font-black text-xl text-white mt-2">Каминный Лаунж</h3>
                                <p class="text-xs text-slate-400 mt-1 font-mono">Камерная зона с виниловым проигрывателем.</p>
                            </div>
                            <div class="grid grid-cols-3 gap-2 mt-4 font-mono">
                                <button onclick="openBookingModal('Стол №9 (Каминная)')" class="p-2.5 text-center bg-black border border-cyan-500/20 hover:border-cyan-400">
                                    <div class="text-xs font-bold text-cyan-300">№ 9</div>
                                </button>
                                <button onclick="openBookingModal('Стол №10 (Каминная)')" class="p-2.5 text-center bg-black border border-cyan-500/20 hover:border-cyan-400">
                                    <div class="text-xs font-bold text-cyan-300">№ 10</div>
                                </button>
                                <button onclick="openBookingModal('Стол №11 (Каминная)')" class="p-2.5 text-center bg-black border border-cyan-500/20 hover:border-cyan-400">
                                    <div class="text-xs font-bold text-cyan-300">№ 11</div>
                                </button>
                            </div>
                        </div>

                        <!-- Zone E: Coworking Hub -->
                        <div class="col-span-12 md:col-span-3 bg-black/80 border border-purple-500/30 p-6 flex flex-col justify-between" style="clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 16px 100%, 0 calc(100% - 16px));">
                            <div>
                                <span class="text-[9px] font-mono uppercase tracking-widest px-2.5 py-1 bg-purple-950/60 text-purple-300 border border-purple-500/30">
                                    SECTOR 05 // WORK HUB
                                </span>
                                <h3 class="font-heading font-black text-xl text-white mt-2">Коворкинг</h3>
                                <p class="text-xs text-slate-400 mt-1 font-mono">Дневная рабочая зона.</p>
                            </div>
                            <button onclick="openBookingModal('Коворкинг')" class="w-full py-2.5 bg-purple-400 text-black font-mono font-bold text-xs uppercase mt-4 hover:bg-purple-300 transition-colors">
                                ЗАБРОНИРОВАТЬ
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Avant-Garde Menu Section -->
        <section id="menu" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-cyan-950/40 border border-cyan-500/40 text-cyan-400 font-mono text-[10px] uppercase tracking-widest mb-3">
                        // GASTRONOMY & MIXOLOGY
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black font-heading text-white">АВТОРСКОЕ МЕНЮ</h2>
                </div>

                <!-- Tab Selector Buttons -->
                <div class="flex justify-center mb-12 font-mono">
                    <div class="inline-flex p-1 bg-black/90 border border-cyan-500/40" style="clip-path: polygon(10px 0, 100% 0, calc(100% - 10px) 100%, 0 100%);">
                        <button id="tab-kitchen" onclick="switchMenu('kitchen')" class="px-8 py-3 text-xs font-bold uppercase tracking-widest bg-cyan-400 text-black transition-all">
                            КУХНЯ [FOOD]
                        </button>
                        <button id="tab-bar" onclick="switchMenu('bar')" class="px-8 py-3 text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-white transition-all">
                            БАР [DRINKS]
                        </button>
                    </div>
                </div>

                <!-- Kitchen Items -->
                <div id="menu-kitchen" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($menu['kitchen'] as $item)
                        <div class="cyber-panel p-6 flex flex-col justify-between group">
                            <div>
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="font-heading font-bold text-white text-base group-hover:text-cyan-400 transition-colors">{{ $item['name'] }}</h4>
                                    <span class="text-sm font-mono font-bold text-cyan-400 ml-4 whitespace-nowrap">{{ $item['price'] }}</span>
                                </div>
                                <p class="text-slate-400 text-xs mb-4 font-mono leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                            <div>
                                <span class="text-[9px] font-mono uppercase tracking-widest px-2.5 py-1 bg-cyan-950/60 text-cyan-300 border border-cyan-500/30">
                                    {{ $item['tag'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Bar Items -->
                <div id="menu-bar" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
                    @foreach($menu['bar'] as $item)
                        <div class="cyber-panel-alt p-6 flex flex-col justify-between group">
                            <div>
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="font-heading font-bold text-white text-base group-hover:text-purple-400 transition-colors">{{ $item['name'] }}</h4>
                                    <span class="text-sm font-mono font-bold text-purple-400 ml-4 whitespace-nowrap">{{ $item['price'] }}</span>
                                </div>
                                <p class="text-slate-400 text-xs mb-4 font-mono leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                            <div>
                                <span class="text-[9px] font-mono uppercase tracking-widest px-2.5 py-1 bg-purple-950/60 text-purple-300 border border-purple-500/30">
                                    {{ $item['tag'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Singularity Loyalty Engine -->
        <section id="loyalty" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="cyber-panel p-8 sm:p-12 border border-cyan-500/40 font-mono">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                        <div class="lg:col-span-6 space-y-6">
                            <div class="inline-flex items-center gap-2 px-3 py-1 bg-cyan-950/40 border border-cyan-500/40 text-cyan-400 text-[10px] uppercase tracking-widest">
                                // PRIVILEGE ENGINE
                            </div>
                            <h2 class="text-3xl sm:text-5xl font-black font-heading text-white">«СИНГУЛЯРНОСТЬ»</h2>
                            <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                                Расчитывайте персональный кэшбэк и привилегии через телеграм-бот клуба.
                            </p>

                            <!-- Interactive Slider -->
                            <div class="bg-black/90 border border-cyan-500/30 p-6" style="clip-path: polygon(10px 0, 100% 0, calc(100% - 10px) 100%, 0 100%);">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs text-slate-300 uppercase">Расходы в месяц:</span>
                                    <span id="calc-budget-text" class="text-cyan-400 font-bold text-base">25 000 ₽</span>
                                </div>
                                <input type="range" id="loyalty-slider" min="5000" max="100000" step="5000" value="25000" oninput="updateLoyaltyCalc(this.value)" class="w-full accent-cyan-400 h-1 bg-slate-800 rounded-none cursor-pointer my-4">

                                <div class="grid grid-cols-2 gap-4 border-t border-cyan-500/20 pt-4">
                                    <div>
                                        <div class="text-[9px] text-slate-500 uppercase">Статус:</div>
                                        <div id="calc-status" class="text-cyan-300 font-bold text-xs mt-0.5">Уровень 2: Орбита</div>
                                    </div>
                                    <div>
                                        <div class="text-[9px] text-slate-500 uppercase">Бонусный кэшбэк:</div>
                                        <div id="calc-cashback" class="text-cyan-300 font-bold text-xs mt-0.5">2 500 ₽ / мес</div>
                                    </div>
                                </div>
                            </div>

                            <a href="https://www.t.me/orbitabar_bot" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 bg-cyan-400 text-black font-mono font-bold text-xs uppercase tracking-widest hover:bg-cyan-300 transition-colors" style="clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 8px, 100% 100%, 8px 100%, 0 calc(100% - 8px));">
                                АКТИВИРОВАТЬ В TELEGRAM
                            </a>
                        </div>

                        <div class="lg:col-span-6 space-y-4">
                            @foreach($loyaltyTiers as $tier)
                                <div class="cyber-panel p-5 border border-cyan-500/20 flex items-center justify-between">
                                    <div>
                                        <div class="text-[9px] font-mono text-cyan-400 uppercase tracking-widest mb-0.5">TIER_0{{ $loop->iteration }}</div>
                                        <h4 class="font-heading font-bold text-sm text-white">{{ $tier['tier'] }}</h4>
                                        <div class="text-xs text-slate-400 font-mono mt-0.5">{{ $tier['perk'] }}</div>
                                    </div>
                                    <div class="text-right font-mono">
                                        <div class="text-lg font-bold text-cyan-400">{{ $tier['cashback'] }}</div>
                                        <div class="text-[9px] text-slate-500 uppercase">{{ $tier['condition'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Location & Map -->
        <section id="contacts" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                    <div class="space-y-6 font-mono">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-cyan-950/40 border border-cyan-500/40 text-cyan-400 text-[10px] uppercase tracking-widest">
                            // COORDINATES
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-black font-heading text-white">ЛОКАЦИЯ</h2>

                        <div class="space-y-4 text-slate-300">
                            <div class="cyber-panel p-5">
                                <div class="text-[9px] text-cyan-400 uppercase">// АДРЕС</div>
                                <div class="font-bold text-white text-sm mt-1">г. Москва, ул. Яузская 1/15</div>
                                <div class="text-xs text-slate-400 mt-1">Метро: Китай-город / Таганская</div>
                            </div>

                            <div class="cyber-panel p-5">
                                <div class="text-[9px] text-purple-400 uppercase">// РЕЖИМ РАБОТЫ</div>
                                <div class="font-bold text-white text-sm mt-1">Вс – Чт: 12:00 — 00:00</div>
                                <div class="font-bold text-cyan-400 text-sm">Пт – Сб: 12:00 — 03:00</div>
                            </div>

                            <div class="cyber-panel p-5">
                                <div class="text-[9px] text-cyan-400 uppercase">// КОНТАКТЫ</div>
                                <div class="font-bold text-white text-sm mt-1">+7 (495) 141-05-55</div>
                                <div class="text-xs text-slate-400 mt-1">orbita.yauza@gmail.com</div>
                            </div>
                        </div>

                        <a href="https://yandex.ru/maps/org/orbita/200600732534" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 bg-cyan-400 text-black font-mono font-bold text-xs uppercase tracking-widest hover:bg-cyan-300 transition-colors" style="clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 8px, 100% 100%, 8px 100%, 0 calc(100% - 8px));">
                            ОТКРЫТЬ ЯНДЕКС.КАРТЫ
                        </a>
                    </div>

                    <!-- Map Container -->
                    <div class="cyber-panel p-2 min-h-[380px] relative bg-black">
                        <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Aa51483f6d6e1bdd5fd51fccd95c1ec128ee72b0b3000d23fd9abd084b712a3df&amp;source=constructor" width="100%" height="100%" frameborder="0" class="w-full h-full opacity-85 hover:opacity-100 transition-opacity"></iframe>
                    </div>

                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-cyan-500/30 py-10 bg-black font-mono">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <span class="text-cyan-400 font-heading font-black text-xl">ОРБИТА</span>
                    <span class="text-slate-600">//</span>
                    <span class="text-slate-400 text-xs">© 2026 ОРБИТА. Яузская 1/15.</span>
                </div>
                <div class="flex items-center gap-6 text-slate-400 text-xs">
                    <a href="https://t.me/orbita_yauza" target="_blank" class="hover:text-cyan-400 transition-colors">TELEGRAM</a>
                    <a href="https://vk.com/orbita_yauza" target="_blank" class="hover:text-cyan-400 transition-colors">VKONTAKTE</a>
                    <a href="https://www.tiktok.com/@orbita_yauza" target="_blank" class="hover:text-cyan-400 transition-colors">TIKTOK</a>
                </div>
            </div>
        </footer>

    </div>

    <!-- Booking Modal -->
    <div id="booking-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-3xl hidden opacity-0 transition-all duration-300 font-mono">
        <div class="cyber-panel bg-[#060810] border border-cyan-500/50 p-6 sm:p-10 max-w-lg w-full relative">

            <button onclick="closeBookingModal()" class="absolute top-6 right-6 text-slate-400 hover:text-cyan-400 text-xl font-bold">&times;</button>

            <div class="text-[10px] uppercase tracking-widest text-cyan-400 mb-2">// RESERVATION SYSTEM</div>
            <h3 class="font-heading font-black text-2xl text-white mb-1">БРОНИРОВАНИЕ</h3>
            <p id="modal-subtitle" class="text-xs text-slate-400 mb-6">Локация: Главный Холл</p>

            <form id="booking-form" onsubmit="submitBooking(event)" class="space-y-4">
                <input type="hidden" id="booking-zone" name="zone" value="Главная сцена">
                <input type="hidden" id="booking-guests" name="guests" value="2">

                <div>
                    <label class="block text-[10px] uppercase text-slate-400 mb-1">Ваше имя</label>
                    <input type="text" name="name" required class="w-full bg-black/80 border border-cyan-500/30 px-4 py-2.5 text-xs text-white focus:outline-none focus:border-cyan-400" placeholder="Иван">
                </div>

                <div>
                    <label class="block text-[10px] uppercase text-slate-400 mb-1">Телефон</label>
                    <input type="tel" name="phone" required class="w-full bg-black/80 border border-cyan-500/30 px-4 py-2.5 text-xs text-white focus:outline-none focus:border-cyan-400" placeholder="+7 (999) 000-00-00">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase text-slate-400 mb-1">Дата</label>
                        <input type="date" name="date" required class="w-full bg-black/80 border border-cyan-500/30 px-4 py-2.5 text-xs text-white focus:outline-none focus:border-cyan-400">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase text-slate-400 mb-1">Время</label>
                        <input type="time" name="time" required class="w-full bg-black/80 border border-cyan-500/30 px-4 py-2.5 text-xs text-white focus:outline-none focus:border-cyan-400">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] uppercase text-slate-400 mb-2">Количество гостей</label>
                    <div class="grid grid-cols-4 gap-2">
                        <button type="button" onclick="selectGuests(1, this)" class="guest-pill py-2 text-xs bg-black border border-cyan-500/30">1</button>
                        <button type="button" onclick="selectGuests(2, this)" class="guest-pill py-2 text-xs bg-cyan-400 text-black font-bold">2</button>
                        <button type="button" onclick="selectGuests(4, this)" class="guest-pill py-2 text-xs bg-black border border-cyan-500/30">4</button>
                        <button type="button" onclick="selectGuests(6, this)" class="guest-pill py-2 text-xs bg-black border border-cyan-500/30">6+</button>
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 bg-cyan-400 text-black font-mono font-bold text-xs uppercase tracking-widest hover:bg-cyan-300 transition-colors mt-4">
                    ПОДТВЕРДИТЬ БРОНИРОВАНИЕ
                </button>
            </form>

            <div id="booking-success" class="hidden text-center py-8">
                <div class="w-10 h-10 border border-cyan-400 text-cyan-400 flex items-center justify-center mx-auto mb-3 text-lg font-bold">✓</div>
                <h4 class="font-heading font-bold text-xl text-white mb-2">БРОНЬ ПОДТВЕРЖДЕНА!</h4>
                <p class="text-slate-300 text-xs">Ждем вас на Яузской 1/15.</p>
            </div>
        </div>
    </div>

    <!-- 3D WEBGL SINGULARITY ENGINE SCRIPT -->
    <script>
        const container = document.getElementById('singularity-canvas-container');
        const scene = new THREE.Scene();
        scene.fog = new THREE.FogExp2(0x020204, 0.015);

        const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.z = 24;

        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        container.appendChild(renderer.domElement);

        // Lights
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.4);
        scene.add(ambientLight);

        const cyanLight = new THREE.PointLight(0x00f0ff, 5, 50);
        cyanLight.position.set(10, 10, 10);
        scene.add(cyanLight);

        const purpleLight = new THREE.PointLight(0xa855f7, 5, 50);
        purpleLight.position.set(-10, -10, 10);
        scene.add(purpleLight);

        // Core Singularity Group
        const singularityGroup = new THREE.Group();
        singularityGroup.position.set(6.5, 0, -2);
        scene.add(singularityGroup);

        // 1. Central Morphing Geometric Crystal Core
        const coreGeo = new THREE.IcosahedronGeometry(4.2, 2);
        const coreMat = new THREE.MeshStandardMaterial({
            color: 0x050b14,
            roughness: 0.2,
            metalness: 0.9,
            wireframe: false,
            flatShading: true
        });
        const coreMesh = new THREE.Mesh(coreGeo, coreMat);
        singularityGroup.add(coreMesh);

        // Outer Wireframe Shell
        const shellGeo = new THREE.IcosahedronGeometry(4.8, 1);
        const shellMat = new THREE.MeshBasicMaterial({
            color: 0x00f0ff,
            wireframe: true,
            transparent: true,
            opacity: 0.35
        });
        const shellMesh = new THREE.Mesh(shellGeo, shellMat);
        singularityGroup.add(shellMesh);

        // 2. Dual Vortex Accretion Rings
        const ring1Geo = new THREE.TorusGeometry(8.5, 0.03, 16, 120);
        const ring1Mat = new THREE.MeshBasicMaterial({ color: 0x00f0ff, transparent: true, opacity: 0.6 });
        const ring1 = new THREE.Mesh(ring1Geo, ring1Mat);
        ring1.rotation.x = Math.PI / 3;
        singularityGroup.add(ring1);

        const ring2Geo = new THREE.TorusGeometry(10.5, 0.02, 16, 120);
        const ring2Mat = new THREE.MeshBasicMaterial({ color: 0xa855f7, transparent: true, opacity: 0.45 });
        const ring2 = new THREE.Mesh(ring2Geo, ring2Mat);
        ring2.rotation.y = Math.PI / 4;
        ring2.rotation.x = -Math.PI / 6;
        singularityGroup.add(ring2);

        // 3. Cyber Dust Particles
        const particleCount = 1200;
        const particleGeo = new THREE.BufferGeometry();
        const positions = new Float32Array(particleCount * 3);

        for (let i = 0; i < particleCount * 3; i += 3) {
            positions[i] = (Math.random() - 0.5) * 120;
            positions[i + 1] = (Math.random() - 0.5) * 120;
            positions[i + 2] = (Math.random() - 0.5) * 120;
        }

        particleGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        const particleMat = new THREE.PointsMaterial({ size: 0.12, color: 0x00f0ff, transparent: true, opacity: 0.5 });
        const particleField = new THREE.Points(particleGeo, particleMat);
        scene.add(particleField);

        // Mouse Parallax Physics
        let mouseX = 0, mouseY = 0;
        window.addEventListener('mousemove', (e) => {
            mouseX = (e.clientX - window.innerWidth / 2) * 0.0008;
            mouseY = (e.clientY - window.innerHeight / 2) * 0.0008;
        });

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        // Vertex Displacement Animation Loop
        const clock = new THREE.Clock();
        const origPositions = coreGeo.attributes.position.clone();

        function animate() {
            requestAnimationFrame(animate);
            const t = clock.getElapsedTime();

            // Vertex morphing on the central core
            const pos = coreGeo.attributes.position;
            for (let i = 0; i < pos.count; i++) {
                const u = origPositions.getX(i);
                const v = origPositions.getY(i);
                const w = origPositions.getZ(i);

                const wave = Math.sin(t * 2 + u * 0.5 + v * 0.5) * 0.25;
                pos.setXYZ(i, u + u * wave * 0.1, v + v * wave * 0.1, w + w * wave * 0.1);
            }
            coreGeo.attributes.position.needsUpdate = true;

            // Rotations
            coreMesh.rotation.y = t * 0.25 + mouseX * 2;
            coreMesh.rotation.x = t * 0.15 + mouseY * 2;

            shellMesh.rotation.y = -t * 0.3;
            shellMesh.rotation.z = t * 0.2;

            ring1.rotation.z = t * 0.4;
            ring2.rotation.z = -t * 0.3;

            particleField.rotation.y = t * 0.02;

            renderer.render(scene, camera);
        }

        animate();

        // Singularity Mode Switching
        function setSingularityMode(mode) {
            if (mode === 'hyperdrive') {
                cyanLight.intensity = 10;
                purpleLight.intensity = 8;
                shellMat.color.setHex(0x00f0ff);
            } else if (mode === 'wireframe') {
                cyanLight.intensity = 3;
                purpleLight.intensity = 10;
                shellMat.color.setHex(0xa855f7);
            } else if (mode === 'void') {
                cyanLight.intensity = 1;
                purpleLight.intensity = 1;
                shellMat.color.setHex(0x334155);
            }
        }

        // Atmosphere Switcher
        let isDay = false;
        function toggleDayNightMode() {
            isDay = !isDay;
            const body = document.body;
            const lbl = document.getElementById('mode-label');

            if (isDay) {
                body.classList.add('theme-day');
                lbl.innerText = 'DAY MATRIX';
                scene.fog.color.setHex(0x060913);
            } else {
                body.classList.remove('theme-day');
                lbl.innerText = 'NIGHT MATRIX';
                scene.fog.color.setHex(0x020204);
            }
        }

        // Loyalty Calc
        function updateLoyaltyCalc(val) {
            const bTxt = document.getElementById('calc-budget-text');
            const sTxt = document.getElementById('calc-status');
            const cTxt = document.getElementById('calc-cashback');

            bTxt.innerText = new Intl.NumberFormat('ru-RU').format(val) + ' ₽';

            let status = 'Уровень 1: Спутник (5%)';
            let percent = 0.05;

            if (val >= 50000) {
                status = 'Уровень 3: Сингулярность (15%)';
                percent = 0.15;
            } else if (val >= 20000) {
                status = 'Уровень 2: Орбита (10%)';
                percent = 0.10;
            }

            const cashback = Math.round(val * percent);
            sTxt.innerText = status;
            cTxt.innerText = new Intl.NumberFormat('ru-RU').format(cashback) + ' ₽ / мес';
        }

        // Guest Pills
        function selectGuests(count, btn) {
            document.getElementById('booking-guests').value = count;
            document.querySelectorAll('.guest-pill').forEach(b => {
                b.className = "guest-pill py-2 text-xs bg-black border border-cyan-500/30";
            });
            btn.className = "guest-pill py-2 text-xs bg-cyan-400 text-black font-bold";
        }

        // Menu Switcher
        function switchMenu(type) {
            const kitchen = document.getElementById('menu-kitchen');
            const bar = document.getElementById('menu-bar');
            const tK = document.getElementById('tab-kitchen');
            const tB = document.getElementById('tab-bar');

            if (type === 'kitchen') {
                kitchen.classList.remove('hidden');
                bar.classList.add('hidden');
                tK.className = "px-8 py-3 text-xs font-bold uppercase tracking-widest bg-cyan-400 text-black transition-all";
                tB.className = "px-8 py-3 text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-white transition-all";
            } else {
                bar.classList.remove('hidden');
                kitchen.classList.add('hidden');
                tB.className = "px-8 py-3 text-xs font-bold uppercase tracking-widest bg-purple-400 text-black transition-all";
                tK.className = "px-8 py-3 text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-white transition-all";
            }
        }

        // Modal
        function openBookingModal(zone) {
            document.getElementById('booking-zone').value = zone;
            document.getElementById('modal-subtitle').innerText = 'Сектор: ' + zone;
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

        function submitBooking(e) {
            e.preventDefault();
            const form = e.target;
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
