<!DOCTYPE html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ОРБИТА — Творческий кластер & Бар-трансформер от Вани Дмитриенко</title>
    <meta name="description" content="Исторический особняк на Яузской 1/15. Днем — фэнси-бар и творческое пространство, ночью — актуальный звук и авторская миксология.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;500;700;900&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300&display=swap" rel="stylesheet">

    <!-- Three.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    @vite(['resources/css/app.css'])

    <style>
        :root {
            --bg-dark: #07080c;
            --accent-gold: #e2b874;
            --accent-lunar: #d4e0eb;
            --glow-moon: rgba(226, 184, 116, 0.25);
            --mode-glow: #e2b874;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            color: #f1f5f9;
            overflow-x: hidden;
            transition: background-color 0.8s ease;
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

        /* Sleek Glassmorphism */
        .orbita-glass {
            background: rgba(15, 17, 26, 0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .orbita-glass:hover {
            border-color: rgba(226, 184, 116, 0.35);
            box-shadow: 0 25px 60px rgba(226, 184, 116, 0.12);
            transform: translateY(-3px);
        }

        .orbita-nav {
            background: rgba(7, 8, 12, 0.85);
            backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Day / Night Theme Transitions */
        body.theme-day {
            --bg-dark: #0f121a;
            --accent-gold: #f59e0b;
            --accent-lunar: #fbbf24;
            --glow-moon: rgba(245, 158, 11, 0.3);
        }
        body.theme-day .orbita-glass {
            background: rgba(25, 30, 45, 0.7);
            border-color: rgba(245, 158, 11, 0.2);
        }

        /* Interactive Map Table Buttons */
        .map-table-btn {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .map-table-btn:hover {
            background: rgba(226, 184, 116, 0.2);
            border-color: var(--accent-gold);
            transform: scale(1.06);
            box-shadow: 0 0 20px rgba(226, 184, 116, 0.4);
        }

        /* Custom Guest Option Buttons */
        .guest-pill {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #94a3b8;
            transition: all 0.25s ease;
        }
        .guest-pill.active, .guest-pill:hover {
            background: linear-gradient(135deg, rgba(226, 184, 116, 0.3), rgba(212, 224, 235, 0.2));
            border-color: var(--accent-gold);
            color: #ffffff;
            box-shadow: 0 0 15px rgba(226, 184, 116, 0.3);
        }

        /* Keyframe Animations */
        @keyframes floatLunar {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(1.5deg); }
        }
        .animate-lunar-float {
            animation: floatLunar 7s ease-in-out infinite;
        }

        @keyframes moonGlowPulse {
            0%, 100% { opacity: 0.7; filter: drop-shadow(0 0 25px rgba(226, 184, 116, 0.3)); }
            50% { opacity: 1; filter: drop-shadow(0 0 50px rgba(226, 184, 116, 0.6)); }
        }
        .animate-moon-glow {
            animation: moonGlowPulse 5s ease-in-out infinite;
        }

        @keyframes marqueeScroll {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: flex;
            width: 200%;
            animation: marqueeScroll 25s linear infinite;
        }

        /* Gold Gradient Text */
        .text-gold-gradient {
            background: linear-gradient(135deg, #fef08a 0%, #e2b874 50%, #b4833e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 7px;
        }
        ::-webkit-scrollbar-track {
            background: #07080c;
        }
        ::-webkit-scrollbar-thumb {
            background: #2a2e3d;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #e2b874;
        }
    </style>
</head>
<body class="bg-[#07080c] text-slate-100 antialiased selection:bg-amber-500 selection:text-black">

    <!-- 3D WebGL Canvas Container for Interactive Moon & Celestial Atmosphere -->
    <div id="moon-canvas-container"></div>

    <div class="content-layer">

        <!-- Header / Navigation Bar -->
        <header class="fixed top-0 left-0 right-0 z-50 orbita-nav transition-all duration-300" id="navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <!-- Brand Logo & Location -->
                <a href="#hero" class="flex items-center gap-3.5 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-200 via-amber-500 to-amber-700 p-[1.5px] shadow-lg shadow-amber-500/20 group-hover:scale-105 transition-transform">
                        <div class="w-full h-full bg-[#07080c] rounded-[14px] flex items-center justify-center">
                            <span class="text-amber-300 font-heading font-black text-2xl tracking-tighter">О</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-xl font-black font-heading tracking-[0.2em] text-white group-hover:text-amber-300 transition-colors">
                            ОРБИТА
                        </div>
                        <div class="text-[9px] uppercase tracking-[0.2em] text-amber-400/90 font-medium flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                            Яузская 1/15 • Москва
                        </div>
                    </div>
                </a>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center gap-8 bg-black/40 border border-white/10 px-8 py-3 rounded-full shadow-2xl backdrop-blur-2xl">
                    <a href="#about" class="text-xs font-semibold uppercase tracking-wider text-slate-300 hover:text-amber-300 transition-colors">О концепции</a>
                    <a href="#seating" class="text-xs font-semibold uppercase tracking-wider text-slate-300 hover:text-amber-300 transition-colors">План рассадки</a>
                    <a href="#menu" class="text-xs font-semibold uppercase tracking-wider text-slate-300 hover:text-amber-300 transition-colors">Меню</a>
                    <a href="#loyalty" class="text-xs font-semibold uppercase tracking-wider text-slate-300 hover:text-amber-300 transition-colors">Орбитальность</a>
                    <a href="#team" class="text-xs font-semibold uppercase tracking-wider text-slate-300 hover:text-amber-300 transition-colors">Команда</a>
                    <a href="#contacts" class="text-xs font-semibold uppercase tracking-wider text-slate-300 hover:text-amber-300 transition-colors">Контакты</a>
                </nav>

                <!-- Day/Night Mode Switcher & Booking CTA -->
                <div class="flex items-center gap-4">
                    <!-- Day / Night Toggle -->
                    <button id="mode-toggle-btn" onclick="toggleDayNightMode()" class="px-4 py-2.5 rounded-full bg-white/5 border border-white/15 text-[11px] font-heading font-bold text-amber-300 hover:bg-amber-500/10 transition-all flex items-center gap-2">
                        <span id="mode-icon">🌙</span>
                        <span id="mode-label" class="hidden sm:inline">РЕЖИМ: НОЧЬ</span>
                    </button>

                    <!-- Reserve Button -->
                    <button onclick="openBookingModal('Главная зона')" class="relative inline-flex items-center justify-center px-6 py-2.5 overflow-hidden text-xs font-bold font-heading rounded-full bg-gradient-to-r from-amber-300 via-amber-500 to-amber-600 text-black shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:scale-105 transition-all duration-300">
                        <span class="uppercase tracking-widest font-black">Забронировать</span>
                    </button>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section id="hero" class="relative min-h-screen flex items-center justify-center pt-32 pb-20 overflow-hidden">
            <div class="max-w-6xl mx-auto px-4 text-center relative z-10">

                <!-- Badge -->
                <div class="inline-flex items-center gap-3 px-6 py-2 rounded-full bg-white/5 border border-amber-500/30 backdrop-blur-2xl mb-8 shadow-2xl animate-lunar-float">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-amber-300 font-heading">
                        ИСТОРИЧЕСКИЙ ОСОБНЯК • БАР ОТ ВАНИ ДМИТРИЕНКО
                    </span>
                </div>

                <!-- Main Dynamic Title -->
                <h1 class="text-4xl sm:text-7xl md:text-8xl lg:text-9xl font-black font-heading tracking-tight text-white mb-8 leading-[0.95]">
                    ДВИГАЙСЯ <br/>
                    <span class="text-gold-gradient animate-moon-glow">
                        ВМЕСТЕ С ОРБИТОЙ
                    </span>
                </h1>

                <!-- Dual Day/Night Atmosphere Subtitle -->
                <div class="max-w-3xl mx-auto mb-12 grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                    <div class="orbita-glass p-6 rounded-3xl border-l-4 border-l-amber-400">
                        <div class="text-xs font-heading font-bold uppercase tracking-wider text-amber-400 mb-2">☀️ ДНЕМ МЫ</div>
                        <p class="text-sm text-slate-300 leading-relaxed font-light">Фэнси-бар с яркой авторской кухней, коворкингом и творческими встречами.</p>
                    </div>
                    <div class="orbita-glass p-6 rounded-3xl border-l-4 border-l-amber-200">
                        <div class="text-xs font-heading font-bold uppercase tracking-wider text-amber-200 mb-2">🌙 НОЧЬЮ МЫ</div>
                        <p class="text-sm text-slate-300 leading-relaxed font-light">Пространство с актуальным звуком, сетами любимых артистов и авторскими коктейлями.</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-5">
                    <button onclick="openBookingModal('Главная сцена')" class="w-full sm:w-auto px-10 py-4.5 rounded-full bg-gradient-to-r from-amber-300 via-amber-500 to-amber-600 text-black font-heading text-xs tracking-widest uppercase font-black shadow-2xl shadow-amber-500/30 hover:scale-105 transition-all duration-300">
                        ЗАБРОНИРОВАТЬ СТОЛ
                    </button>
                    <a href="#seating" class="w-full sm:w-auto px-10 py-4.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/15 backdrop-blur-2xl text-slate-200 font-heading text-xs tracking-widest uppercase font-bold transition-all duration-300">
                        ПЛАН РАССАДКИ
                    </a>
                </div>

                <!-- Info Location Strip -->
                <div class="mt-16 inline-flex flex-wrap items-center justify-center gap-6 px-8 py-4 rounded-full bg-black/60 border border-white/10 text-xs text-slate-300 backdrop-blur-xl">
                    <span class="flex items-center gap-2">📍 Москва, ул. Яузская 1/15</span>
                    <span class="hidden sm:inline text-slate-600">•</span>
                    <span class="flex items-center gap-2">🚇 метро Китай-город / Таганская</span>
                    <span class="hidden sm:inline text-slate-600">•</span>
                    <span class="text-amber-300 font-semibold">Вс–Чт: 12:00–00:00 | Пт–Сб: 12:00–03:00</span>
                </div>
            </div>
        </section>

        <!-- Continuous Orbit Ticker Marquee -->
        <div class="w-full bg-black/90 border-y border-amber-500/20 py-3.5 overflow-hidden backdrop-blur-xl">
            <div class="animate-marquee whitespace-nowrap flex items-center gap-12 font-heading text-xs uppercase tracking-[0.3em] font-bold text-amber-300/80">
                <span>✦ ОРБИТА — ТВОРЧЕСКИЙ КЛАСТЕР</span>
                <span>✦ АВТОРСКАЯ КУХНЯ ВАНА ДМИТРИЕНКО</span>
                <span>✦ АКТУАЛЬНЫЙ ЗВУК И ЖИВЫЕ ДЖЕМЫ</span>
                <span>✦ ИСТОРИЧЕСКИЙ ОСОБНЯК НА ЯУЗСКОЙ</span>
                <span>✦ ОРБИТА — ТВОРЧЕСКИЙ КЛАСТЕР</span>
                <span>✦ АВТОРСКАЯ КУХНЯ ВАНА ДМИТРИЕНКО</span>
                <span>✦ АКТУАЛЬНЫЙ ЗВУК И ЖИВЫЕ ДЖЕМЫ</span>
                <span>✦ ИСТОРИЧЕСКИЙ ОСОБНЯК НА ЯУЗСКОЙ</span>
            </div>
        </div>

        <!-- About / Concept Section -->
        <section id="about" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                    <!-- Left Column Text -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs uppercase tracking-widest font-bold">
                            О КОНЦЕПЦИИ
                        </div>

                        <h2 class="text-3xl sm:text-5xl font-black font-heading text-white leading-tight">
                            ООРБИТА — БАР, ГДЕ <span class="text-gold-gradient">ЗВЕЗДЫ ТУСУЮТСЯ</span> НЕ НА НЕБЕ, А ЗА СОСЕДНИМ СТОЛИКОМ
                        </h2>

                        <p class="text-slate-300 text-base sm:text-lg leading-relaxed font-light">
                            «Встретимся на Орбите! Здесь тебя будут ждать авторские бар и кухня, креативные классы, квартирники, джемы с молодыми артистами и музыкантами, уютные концерты и, конечно же, я.»
                        </p>

                        <div class="p-6 rounded-3xl bg-amber-500/5 border border-amber-500/20">
                            <div class="text-xs uppercase font-bold text-amber-400 font-heading mb-1">— Ваня Дмитриенко</div>
                            <p class="text-xs text-slate-400 italic">«Я давно мечтал о пространстве, в котором смогу делиться тем, что мне важно. Место, куда можно приехать за свежими идеями, поработать, послушать музыку или просто круто провести время.»</p>
                        </div>

                        <!-- 3 Highlights -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                            <div class="orbita-glass p-5 rounded-2xl">
                                <div class="text-amber-300 font-heading font-black text-2xl mb-1">01</div>
                                <div class="text-xs font-bold text-white mb-1">Творческий кластер</div>
                                <div class="text-[11px] text-slate-400">Летние маркеты & арт-события</div>
                            </div>
                            <div class="orbita-glass p-5 rounded-2xl">
                                <div class="text-amber-300 font-heading font-black text-2xl mb-1">02</div>
                                <div class="text-xs font-bold text-white mb-1">Бар-трансформер</div>
                                <div class="text-[11px] text-slate-400">Из уютного коворкинга в ночной клуб</div>
                            </div>
                            <div class="orbita-glass p-5 rounded-2xl">
                                <div class="text-amber-300 font-heading font-black text-2xl mb-1">03</div>
                                <div class="text-xs font-bold text-white mb-1">Авторская кухня</div>
                                <div class="text-[11px] text-slate-400">Smart casual гастрономия</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column 3D Moon Interactive Control Panel -->
                    <div class="lg:col-span-5">
                        <div class="orbita-glass rounded-3xl p-8 border border-amber-500/30 relative text-center">
                            <div class="text-xs font-heading font-bold uppercase tracking-widest text-amber-300 mb-4 flex items-center justify-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                                ИНТЕРАКТИВНАЯ ЛУННАЯ ОРБИТА
                            </div>
                            <p class="text-xs text-slate-400 mb-6 font-light">Вращайте трехмерную Луну мышью и управляйте орбитальной фазой в реальном времени</p>

                            <div class="space-y-4">
                                <button onclick="rotateMoonPhase('full')" class="w-full py-3 px-4 rounded-2xl bg-white/5 hover:bg-amber-500/20 border border-white/10 text-xs font-heading font-bold text-slate-200 transition-all flex items-center justify-between">
                                    <span>🌕 ПОЛНОЛУНИЕ (PARTY MODE)</span>
                                    <span class="text-amber-400">&rarr;</span>
                                </button>
                                <button onclick="rotateMoonPhase('crescent')" class="w-full py-3 px-4 rounded-2xl bg-white/5 hover:bg-amber-500/20 border border-white/10 text-xs font-heading font-bold text-slate-200 transition-all flex items-center justify-between">
                                    <span>🌙 ПОЛУМЕСЯЦ (LOUNGE MODE)</span>
                                    <span class="text-amber-400">&rarr;</span>
                                </button>
                                <button onclick="rotateMoonPhase('eclipse')" class="w-full py-3 px-4 rounded-2xl bg-white/5 hover:bg-amber-500/20 border border-white/10 text-xs font-heading font-bold text-slate-200 transition-all flex items-center justify-between">
                                    <span>🌑 ЗАТМЕНИЕ (NIGHT SOUND)</span>
                                    <span class="text-amber-400">&rarr;</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Seating Map Section ("План рассадки") -->
        <section id="seating" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs uppercase tracking-widest font-bold mb-4">
                        ПРОСТРАНСТВО ОСОБНЯКА
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black font-heading text-white">ПЛАН РАССАДКИ</h2>
                    <p class="text-slate-400 text-sm mt-4">Нажмите на любой стол или зону, чтобы мгновенно забронировать визит</p>
                </div>

                <!-- Interactive Map Visualization Grid -->
                <div class="orbita-glass rounded-3xl p-6 sm:p-10 border border-amber-500/30 relative">
                    <div class="grid grid-cols-12 gap-4 min-h-[420px]">

                        <!-- Stage / Scene -->
                        <div class="col-span-12 md:col-span-8 bg-amber-500/10 border border-amber-500/30 rounded-2xl p-6 flex flex-col justify-between relative group">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30">СЦЕНА & ТАНЦПОЛ</span>
                                    <h3 class="font-heading font-black text-2xl text-white mt-2">Главная Сцена</h3>
                                </div>
                                <button onclick="openBookingModal('Главная Сцена')" class="px-4 py-2 rounded-xl bg-amber-400 text-black font-heading font-bold text-xs uppercase tracking-wider hover:bg-amber-300 transition-colors">
                                    Забронировать
                                </button>
                            </div>

                            <!-- Clickable Tables 1..6 -->
                            <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 mt-6">
                                @for($i = 1; $i <= 6; $i++)
                                    <button onclick="openBookingModal('Стол №{{ $i }} (Сцена)')" class="map-table-btn py-4 rounded-xl text-center">
                                        <div class="text-xs font-bold text-amber-300 font-heading">№ {{ $i }}</div>
                                        <div class="text-[9px] text-slate-400 uppercase">2-4 мест</div>
                                    </button>
                                @endfor
                            </div>
                        </div>

                        <!-- Bar Zone -->
                        <div class="col-span-12 md:col-span-4 bg-purple-500/10 border border-purple-500/30 rounded-2xl p-6 flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full bg-purple-500/20 text-purple-300 border border-purple-500/30">КОНТАКТНЫЙ БАР</span>
                                <h3 class="font-heading font-black text-2xl text-white mt-2">Барный Остров</h3>
                                <p class="text-xs text-slate-400 mt-2">Авторские коктейли и живой контакт с миксологами.</p>
                            </div>
                            <button onclick="openBookingModal('Барная стойка')" class="w-full py-3 rounded-xl bg-purple-500 hover:bg-purple-400 text-white font-heading font-bold text-xs uppercase tracking-wider transition-colors mt-6">
                                Забронировать бар
                            </button>
                        </div>

                        <!-- VIP Balcony Gallery -->
                        <div class="col-span-12 md:col-span-4 bg-indigo-500/10 border border-indigo-500/30 rounded-2xl p-6 flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">VIP VIEW</span>
                                <h3 class="font-heading font-black text-xl text-white mt-2">Балконная Галерея</h3>
                                <p class="text-xs text-slate-400 mt-1">Панорамная локация с видом на сцену.</p>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-4">
                                <button onclick="openBookingModal('Стол №7 (Балкон)')" class="map-table-btn py-2.5 rounded-xl text-center">
                                    <div class="text-xs font-bold text-indigo-300 font-heading">№ 7</div>
                                    <div class="text-[9px] text-slate-400">4-6 мест</div>
                                </button>
                                <button onclick="openBookingModal('Стол №8 (Балкон)')" class="map-table-btn py-2.5 rounded-xl text-center">
                                    <div class="text-xs font-bold text-indigo-300 font-heading">№ 8</div>
                                    <div class="text-[9px] text-slate-400">4-6 мест</div>
                                </button>
                            </div>
                        </div>

                        <!-- Fireplace & Karaoke Room -->
                        <div class="col-span-12 md:col-span-5 bg-rose-500/10 border border-rose-500/30 rounded-2xl p-6 flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full bg-rose-500/20 text-rose-300 border border-rose-500/30">УЮТ & МУЗЫКА</span>
                                <h3 class="font-heading font-black text-xl text-white mt-2">Каминная & Караоке</h3>
                                <p class="text-xs text-slate-400 mt-1">Камерная атмосфера с камином и виниловым звуком.</p>
                            </div>
                            <div class="grid grid-cols-3 gap-2 mt-4">
                                <button onclick="openBookingModal('Стол №9 (Каминная)')" class="map-table-btn py-2.5 rounded-xl text-center">
                                    <div class="text-xs font-bold text-rose-300 font-heading">№ 9</div>
                                    <div class="text-[9px] text-slate-400">2-4 мест</div>
                                </button>
                                <button onclick="openBookingModal('Стол №10 (Каминная)')" class="map-table-btn py-2.5 rounded-xl text-center">
                                    <div class="text-xs font-bold text-rose-300 font-heading">№ 10</div>
                                    <div class="text-[9px] text-slate-400">2-4 мест</div>
                                </button>
                                <button onclick="openBookingModal('Стол №11 (Каминная)')" class="map-table-btn py-2.5 rounded-xl text-center">
                                    <div class="text-xs font-bold text-rose-300 font-heading">№ 11</div>
                                    <div class="text-[9px] text-slate-400">6+ мест</div>
                                </button>
                            </div>
                        </div>

                        <!-- Coworking & Lounge Zone -->
                        <div class="col-span-12 md:col-span-3 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl p-6 flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">ДНЕВНОЙ ФОРМАТ</span>
                                <h3 class="font-heading font-black text-xl text-white mt-2">Коворкинг</h3>
                                <p class="text-xs text-slate-400 mt-1">Комфортные рабочие места и спешелти кофе.</p>
                            </div>
                            <button onclick="openBookingModal('Дневной Коворкинг')" class="w-full py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-black font-heading font-bold text-xs uppercase tracking-wider transition-colors mt-4">
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
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs uppercase tracking-widest font-bold mb-4">
                        ГАСТРОНОМИЯ & МИКСОЛОГИЯ
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black font-heading text-white">В НАШЕМ МЕНЮ</h2>
                    <p class="text-slate-400 text-sm mt-3">С авторским взглядом от шеф-повара и шеф-бармена</p>
                </div>

                <!-- Tabs Switcher -->
                <div class="flex justify-center mb-12">
                    <div class="inline-flex p-1.5 rounded-full bg-black/80 border border-white/10 backdrop-blur-2xl">
                        <button id="tab-kitchen" onclick="switchMenu('kitchen')" class="px-8 py-3.5 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 bg-gradient-to-r from-amber-300 to-amber-500 text-black shadow-xl">
                            МЕНЮ КУХНИ
                        </button>
                        <button id="tab-bar" onclick="switchMenu('bar')" class="px-8 py-3.5 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 text-slate-400 hover:text-white">
                            БАРНОЕ МЕНЮ
                        </button>
                    </div>
                </div>

                <!-- Kitchen Menu Grid -->
                <div id="menu-kitchen" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($menu['kitchen'] as $item)
                        <div class="orbita-glass p-6 rounded-3xl flex flex-col justify-between group">
                            <div>
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="font-heading font-bold text-white text-base group-hover:text-amber-300 transition-colors">{{ $item['name'] }}</h4>
                                    <span class="text-lg font-black font-heading text-amber-300 ml-4 whitespace-nowrap">{{ $item['price'] }}</span>
                                </div>
                                <p class="text-slate-400 text-xs mb-4 font-light leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-amber-500/10 text-amber-300 border border-amber-500/20">
                                    {{ $item['tag'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Bar Menu Grid -->
                <div id="menu-bar" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
                    @foreach($menu['bar'] as $item)
                        <div class="orbita-glass p-6 rounded-3xl flex flex-col justify-between group">
                            <div>
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="font-heading font-bold text-white text-base group-hover:text-amber-300 transition-colors">{{ $item['name'] }}</h4>
                                    <span class="text-lg font-black font-heading text-amber-300 ml-4 whitespace-nowrap">{{ $item['price'] }}</span>
                                </div>
                                <p class="text-slate-400 text-xs mb-4 font-light leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-purple-500/10 text-purple-300 border border-purple-500/20">
                                    {{ $item['tag'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Loyalty Program ("Орбитальность") -->
        <section id="loyalty" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="orbita-glass rounded-3xl border border-amber-500/30 p-8 sm:p-14 relative overflow-hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                        <div class="lg:col-span-6 space-y-6">
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/20 text-amber-300 text-xs uppercase tracking-widest font-bold">
                                ПРОГРАММА ЛОЯЛЬНОСТИ
                            </div>
                            <h2 class="text-3xl sm:text-5xl font-black font-heading text-white">«ОРБИТАЛЬНОСТЬ»</h2>
                            <p class="text-slate-300 text-base leading-relaxed font-light">
                                Получай бонусы, скидки и закрытый доступ. Набираешь баллы и поднимаешься по четырем уровням, открывая лимитки мерча, спешелти бонусы и личные приглашения от Вани Дмитриенко.
                            </p>

                            <!-- Interactive Points Calculator Slider -->
                            <div class="bg-black/70 border border-white/10 rounded-2xl p-6 backdrop-blur-xl">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-bold text-slate-300 uppercase tracking-wider font-heading">Сумма чека в месяц</span>
                                    <span id="calc-budget-text" class="text-amber-300 font-black font-heading text-lg">25 000 ₽</span>
                                </div>
                                <input type="range" id="loyalty-slider" min="5000" max="100000" step="5000" value="25000" oninput="updateLoyaltyCalc(this.value)" class="w-full accent-amber-400 h-2 bg-slate-800 rounded-lg cursor-pointer my-4">

                                <div class="grid grid-cols-2 gap-4 border-t border-white/10 pt-4">
                                    <div>
                                        <div class="text-[10px] text-slate-400 uppercase font-bold">Ваш статус:</div>
                                        <div id="calc-status" class="text-amber-300 font-heading font-bold text-base">Уровень 2: Орбита</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] text-slate-400 uppercase font-bold">Кэшбэк на счет:</div>
                                        <div id="calc-cashback" class="text-amber-300 font-heading font-bold text-base">2 500 ₽ / мес</div>
                                    </div>
                                </div>
                            </div>

                            <a href="https://www.t.me/orbitabar_bot" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 rounded-full bg-gradient-to-r from-amber-300 to-amber-500 text-black font-heading font-black text-xs uppercase tracking-widest shadow-xl hover:scale-105 transition-transform">
                                РЕГИСТРИРУЙСЯ В ОРБИТАЛЬНОСТИ
                            </a>
                        </div>

                        <!-- Tier Cards Grid -->
                        <div class="lg:col-span-6 space-y-4">
                            @foreach($loyaltyTiers as $tier)
                                <div class="orbita-glass p-6 rounded-2xl border border-white/10 flex items-center justify-between hover:border-amber-500/40 transition-all">
                                    <div>
                                        <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider mb-1">Уровень {{ $loop->iteration }}</div>
                                        <h4 class="font-heading font-bold text-lg text-white mb-1">{{ $tier['tier'] }}</h4>
                                        <div class="text-xs text-slate-300">{{ $tier['perk'] }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-black font-heading text-amber-300">{{ $tier['cashback'] }}</div>
                                        <div class="text-[10px] text-slate-400 uppercase">{{ $tier['condition'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Team & Careers -->
        <section id="team" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs uppercase tracking-widest font-bold mb-4">
                    КОМАНДА ОРБИТЫ
                </div>
                <h2 class="text-3xl sm:text-5xl font-black font-heading text-white mb-6">СОЗДАВАЙ АТМОСФЕРУ ВМЕСТЕ С НАМИ</h2>
                <p class="text-slate-300 max-w-2xl mx-auto text-sm sm:text-base leading-relaxed font-light mb-8">
                    Работа в Орбите — это возможность развиваться и вместе создавать уникальное культурное пространство. Мы — команда творческих людей, которые ценят свободу, креатив и открытость.
                </p>
                <a href="#contacts" onclick="openBookingModal('Заявка в команду')" class="inline-flex items-center gap-2 px-8 py-4 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white font-heading text-xs font-bold uppercase tracking-widest transition-all">
                    СТАТЬ ЧАСТЬЮ КОМАНДЫ &rarr;
                </a>
            </div>
        </section>

        <!-- Location & Contact Section -->
        <section id="contacts" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs uppercase tracking-widest font-bold">
                            КОНТАКТЫ & МАРШРУТ
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-black font-heading text-white">ИЩИ НАС ЗДЕСЬ</h2>

                        <div class="space-y-4 text-slate-300">
                            <div class="orbita-glass p-5 rounded-2xl flex items-start gap-4">
                                <span class="text-2xl">📍</span>
                                <div>
                                    <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Адрес</div>
                                    <div class="font-bold text-white text-sm mt-0.5">г. Москва, улица Яузская 1/15</div>
                                    <div class="text-xs text-slate-400 mt-0.5">Ближайшие станции метро: Китай-город, Таганская</div>
                                </div>
                            </div>

                            <div class="orbita-glass p-5 rounded-2xl flex items-start gap-4">
                                <span class="text-2xl">⏰</span>
                                <div>
                                    <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Время работы</div>
                                    <div class="font-bold text-white text-sm mt-0.5">Вс – Чт: 12:00 — 00:00</div>
                                    <div class="font-bold text-amber-300 text-sm">Пт – Сб: 12:00 — 03:00</div>
                                </div>
                            </div>

                            <div class="orbita-glass p-5 rounded-2xl flex items-start gap-4">
                                <span class="text-2xl">📞</span>
                                <div>
                                    <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Бронирование & Инфо</div>
                                    <div class="font-bold text-white text-sm mt-0.5">+7 (495) 141-05-55</div>
                                    <div class="text-xs text-slate-400 mt-0.5">orbita.yauza@gmail.com</div>
                                </div>
                            </div>
                        </div>

                        <a href="https://yandex.ru/maps/org/orbita/200600732534" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 rounded-full bg-gradient-to-r from-amber-300 to-amber-500 text-black font-heading font-black text-xs uppercase tracking-widest shadow-xl hover:scale-105 transition-transform">
                            ПОСТРОИТЬ МАРШРУТ НА КАРТЕ
                        </a>
                    </div>

                    <!-- Interactive Map Viewport -->
                    <div class="rounded-3xl overflow-hidden border border-white/10 h-80 sm:h-auto min-h-[380px] relative bg-slate-900 shadow-2xl">
                        <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Aa51483f6d6e1bdd5fd51fccd95c1ec128ee72b0b3000d23fd9abd084b712a3df&amp;source=constructor" width="100%" height="100%" frameborder="0" class="w-full h-full opacity-85 hover:opacity-100 transition-opacity"></iframe>
                    </div>

                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-white/10 py-12 relative bg-black/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <span class="text-amber-300 font-heading font-black text-xl">ОРБИТА</span>
                    <span class="text-slate-500 text-xs">|</span>
                    <span class="text-slate-400 text-xs font-light">© 2026 ОРБИТА БАР. Исторический особняк на Яузской.</span>
                </div>
                <div class="flex items-center gap-6 text-slate-400 text-xs font-semibold">
                    <a href="https://t.me/orbita_yauza" target="_blank" class="hover:text-amber-300 transition-colors">Telegram</a>
                    <a href="https://vk.com/orbita_yauza" target="_blank" class="hover:text-amber-300 transition-colors">VKontakte</a>
                    <a href="https://www.tiktok.com/@orbita_yauza" target="_blank" class="hover:text-amber-300 transition-colors">TikTok</a>
                </div>
            </div>
        </footer>

    </div>

    <!-- Booking Modal -->
    <div id="booking-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-2xl hidden opacity-0 transition-all duration-300">
        <div class="bg-[#0f111a] border border-amber-500/40 rounded-3xl p-6 sm:p-10 max-w-lg w-full relative shadow-[0_0_80px_rgba(226,184,116,0.2)] overflow-hidden">

            <button onclick="closeBookingModal()" class="absolute top-6 right-6 text-slate-400 hover:text-white font-bold text-2xl w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center transition-colors hover:border-amber-400">&times;</button>

            <div class="flex items-center gap-2 mb-2">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping"></span>
                <span class="text-xs uppercase font-bold tracking-widest text-amber-300 font-heading">ОНЛАЙН-РЕЗЕРВ СТОЛА</span>
            </div>

            <h3 class="font-heading font-black text-2xl sm:text-3xl text-white mb-2">БРОНИРОВАНИЕ</h3>
            <p id="modal-subtitle" class="text-xs text-slate-400 mb-8 font-light">Локация: Главная сцена</p>

            <form id="booking-form" onsubmit="submitBooking(event)" class="space-y-4">
                <input type="hidden" id="booking-zone" name="zone" value="Главная сцена">
                <input type="hidden" id="booking-guests" name="guests" value="2">

                <div>
                    <label class="block text-[10px] uppercase font-bold tracking-wider text-slate-300 mb-1 font-heading">Ваше имя</label>
                    <input type="text" name="name" required class="w-full bg-white/5 border border-white/15 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-400 transition-colors" placeholder="Иван Иванов">
                </div>

                <div>
                    <label class="block text-[10px] uppercase font-bold tracking-wider text-slate-300 mb-1 font-heading">Телефон</label>
                    <input type="tel" name="phone" required class="w-full bg-white/5 border border-white/15 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-400 transition-colors" placeholder="+7 (999) 000-00-00">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase font-bold tracking-wider text-slate-300 mb-1 font-heading">Дата</label>
                        <input type="date" name="date" required class="w-full bg-white/5 border border-white/15 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-400 transition-colors">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase font-bold tracking-wider text-slate-300 mb-1 font-heading">Время</label>
                        <input type="time" name="time" required class="w-full bg-white/5 border border-white/15 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-400 transition-colors">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] uppercase font-bold tracking-wider text-slate-300 mb-2 font-heading">Количество гостей</label>
                    <div class="grid grid-cols-4 gap-2">
                        <button type="button" onclick="selectGuests(1, this)" class="guest-pill py-2.5 rounded-xl text-xs font-heading font-bold">1 гость</button>
                        <button type="button" onclick="selectGuests(2, this)" class="guest-pill py-2.5 rounded-xl text-xs font-heading font-bold active">2 гостя</button>
                        <button type="button" onclick="selectGuests(4, this)" class="guest-pill py-2.5 rounded-xl text-xs font-heading font-bold">4 гостя</button>
                        <button type="button" onclick="selectGuests(6, this)" class="guest-pill py-2.5 rounded-xl text-xs font-heading font-bold">6+ гостей</button>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 mt-4 rounded-xl bg-gradient-to-r from-amber-300 via-amber-500 to-amber-600 text-black font-heading font-black text-xs uppercase tracking-widest shadow-xl shadow-amber-500/20 hover:scale-[1.02] transition-transform">
                    ПОДТВЕРДИТЬ БРОНИРОВАНИЕ
                </button>
            </form>

            <div id="booking-success" class="hidden text-center py-8">
                <div class="w-16 h-16 bg-amber-500/20 border border-amber-400 text-amber-300 rounded-full flex items-center justify-center mx-auto mb-4 font-bold text-2xl animate-bounce">✓</div>
                <h4 class="font-heading font-bold text-2xl text-white mb-2">БРОНЬ ПОДТВЕРЖДЕНА!</h4>
                <p class="text-slate-300 text-xs max-w-xs mx-auto leading-relaxed">Система зафиксировала ваш визит. Ждем вас на Яузской 1/15!</p>
            </div>
        </div>
    </div>

    <!-- WebGL Three.js Realistic Moon & Atmosphere Script -->
    <script>
        // --- 1. THREE.JS REALISTIC MOON & CELESTIAL BACKGROUND ---
        const container = document.getElementById('moon-canvas-container');
        const scene = new THREE.Scene();
        scene.fog = new THREE.FogExp2(0x07080c, 0.012);

        const camera = new THREE.PerspectiveCamera(50, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.z = 24;

        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        container.appendChild(renderer.domElement);

        // Lights
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.25);
        scene.add(ambientLight);

        // Key Directional Sunlight (Lunar Phase)
        const sunLight = new THREE.DirectionalLight(0xfff3d1, 3.5);
        sunLight.position.set(20, 10, 15);
        scene.add(sunLight);

        // Soft Lunar Aura PointLight
        const lunarAuraLight = new THREE.PointLight(0xe2b874, 2, 40);
        lunarAuraLight.position.set(-10, -10, 10);
        scene.add(lunarAuraLight);

        // 3D Moon Mesh
        const moonGroup = new THREE.Group();
        scene.add(moonGroup);

        const moonGeo = new THREE.SphereGeometry(6, 64, 64);

        // Procedural Lunar Surface Texture Generator using Canvas
        function generateMoonTexture() {
            const canvas = document.createElement('canvas');
            canvas.width = 1024;
            canvas.height = 512;
            const ctx = canvas.getContext('2d');

            // Lunar base gradient
            const grad = ctx.createLinearGradient(0, 0, 0, 512);
            grad.addColorStop(0, '#8c8e9e');
            grad.addColorStop(0.5, '#b0b2c4');
            grad.addColorStop(1, '#696b78');
            ctx.fillStyle = grad;
            ctx.fillRect(0, 0, 1024, 512);

            // Add procedural craters & maria dark spots
            ctx.fillStyle = 'rgba(40, 42, 55, 0.35)';
            for (let i = 0; i < 180; i++) {
                const x = Math.random() * 1024;
                const y = Math.random() * 512;
                const r = 10 + Math.random() * 60;
                ctx.beginPath();
                ctx.arc(x, y, r, 0, Math.PI * 2);
                ctx.fill();
            }

            // Crater rims
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.25)';
            ctx.lineWidth = 2;
            for (let i = 0; i < 90; i++) {
                const x = Math.random() * 1024;
                const y = Math.random() * 512;
                const r = 4 + Math.random() * 25;
                ctx.beginPath();
                ctx.arc(x, y, r, 0, Math.PI * 2);
                ctx.stroke();
            }

            return new THREE.CanvasTexture(canvas);
        }

        const moonTex = generateMoonTexture();
        const moonMat = new THREE.MeshStandardMaterial({
            map: moonTex,
            roughness: 0.85,
            metalness: 0.1,
            bumpMap: moonTex,
            bumpScale: 0.15
        });

        const moonMesh = new THREE.Mesh(moonGeo, moonMat);
        moonMesh.position.set(7, 2, -2);
        moonGroup.add(moonMesh);

        // Orbital Golden Dust Ring
        const ringGeo = new THREE.TorusGeometry(10.5, 0.08, 16, 120);
        const ringMat = new THREE.MeshBasicMaterial({ color: 0xe2b874, transparent: true, opacity: 0.4 });
        const ringMesh = new THREE.Mesh(ringGeo, ringMat);
        ringMesh.position.set(7, 2, -2);
        ringMesh.rotation.x = Math.PI / 2.5;
        moonGroup.add(ringMesh);

        // Background Star Particles
        const starCount = 1200;
        const starGeo = new THREE.BufferGeometry();
        const starPos = new Float32Array(starCount * 3);

        for (let i = 0; i < starCount * 3; i += 3) {
            starPos[i] = (Math.random() - 0.5) * 120;
            starPos[i + 1] = (Math.random() - 0.5) * 120;
            starPos[i + 2] = (Math.random() - 0.5) * 120;
        }

        starGeo.setAttribute('position', new THREE.BufferAttribute(starPos, 3));
        const starMat = new THREE.PointsMaterial({ size: 0.18, color: 0xffffff, transparent: true, opacity: 0.75 });
        const starfield = new THREE.Points(starGeo, starMat);
        scene.add(starfield);

        // Mouse Parallax Controls
        let mouseX = 0, mouseY = 0;
        let targetX = 0, targetY = 0;

        window.addEventListener('mousemove', (e) => {
            mouseX = (e.clientX - window.innerWidth / 2) * 0.0008;
            mouseY = (e.clientY - window.innerHeight / 2) * 0.0008;
        });

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        // Animation Loop
        const clock = new THREE.Clock();

        function animate() {
            requestAnimationFrame(animate);
            const delta = clock.getElapsedTime();

            targetX += (mouseX - targetX) * 0.05;
            targetY += (mouseY - targetY) * 0.05;

            moonMesh.rotation.y = delta * 0.08 + targetX * 3;
            moonMesh.rotation.x = Math.sin(delta * 0.1) * 0.1 + targetY * 3;

            ringMesh.rotation.z = delta * 0.15;
            starfield.rotation.y = delta * 0.01;

            renderer.render(scene, camera);
        }

        animate();

        // --- 2. MOON PHASE CONTROL INTERACTION ---
        function rotateMoonPhase(phase) {
            if (phase === 'full') {
                sunLight.position.set(10, 10, 25);
                sunLight.intensity = 4.0;
            } else if (phase === 'crescent') {
                sunLight.position.set(-25, 5, 10);
                sunLight.intensity = 3.0;
            } else if (phase === 'eclipse') {
                sunLight.position.set(0, -25, -10);
                sunLight.intensity = 0.8;
            }
        }

        // --- 3. DAY / NIGHT ATMOSPHERE TOGGLE ---
        let isDayMode = false;
        function toggleDayNightMode() {
            isDayMode = !isDayMode;
            const body = document.body;
            const icon = document.getElementById('mode-icon');
            const label = document.getElementById('mode-label');

            if (isDayMode) {
                body.classList.add('theme-day');
                icon.innerText = '☀️';
                label.innerText = 'РЕЖИМ: ДЕНЬ';
                scene.fog.color.setHex(0x0f121a);
                sunLight.color.setHex(0xffaa44);
            } else {
                body.classList.remove('theme-day');
                icon.innerText = '🌙';
                label.innerText = 'РЕЖИМ: НОЧЬ';
                scene.fog.color.setHex(0x07080c);
                sunLight.color.setHex(0xfff3d1);
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

        // --- 6. MENU TABS ---
        function switchMenu(type) {
            const kitchenMenu = document.getElementById('menu-kitchen');
            const barMenu = document.getElementById('menu-bar');
            const tabKitchen = document.getElementById('tab-kitchen');
            const tabBar = document.getElementById('tab-bar');

            if (type === 'kitchen') {
                kitchenMenu.classList.remove('hidden');
                barMenu.classList.add('hidden');
                tabKitchen.className = "px-8 py-3.5 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 bg-gradient-to-r from-amber-300 to-amber-500 text-black shadow-xl";
                tabBar.className = "px-8 py-3.5 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 text-slate-400 hover:text-white";
            } else {
                barMenu.classList.remove('hidden');
                kitchenMenu.classList.add('hidden');
                tabBar.className = "px-8 py-3.5 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 bg-gradient-to-r from-amber-300 to-amber-500 text-black shadow-xl";
                tabKitchen.className = "px-8 py-3.5 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 text-slate-400 hover:text-white";
            }
        }

        // --- 7. MODAL & AJAX BOOKING ---
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
