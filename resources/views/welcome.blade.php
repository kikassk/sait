<!DOCTYPE html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ОРБИТА — Фэнси-бар & Ночной Матрикс | Яузская 1/15</title>
    <meta name="description" content="Фэнси-бар с авторской кухней, тихим коворкингом и трансформируемым залом. Проект Вани Дмитриенко в историческом особняке XVIII века.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Syne:wght@400;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Three.js for 3D Mannequin & Hand Studio Stage -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #08080a;
            color: #f4f4f5;
            overflow-x: hidden;
        }

        .font-display { font-family: 'Syne', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        /* Custom Artistic Card Styles */
        .art-card-glass {
            background: linear-gradient(135deg, rgba(28, 28, 35, 0.7) 0%, rgba(15, 15, 20, 0.8) 100%);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 2.5rem;
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.6);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .art-card-glass:hover {
            border-color: rgba(255, 255, 255, 0.22);
            transform: translateY(-6px);
            box-shadow: 0 40px 80px -15px rgba(0, 0, 0, 0.8), 0 0 40px rgba(255, 255, 255, 0.05);
        }

        .art-card-pill {
            background: rgba(24, 24, 27, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 9999px;
        }

        .art-button-primary {
            background: linear-gradient(135deg, #ffffff 0%, #d4d4d8 100%);
            color: #09090b;
            font-weight: 700;
            border-radius: 9999px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .art-button-primary:hover {
            transform: scale(1.03);
            box-shadow: 0 12px 30px rgba(255, 255, 255, 0.2);
        }

        .art-button-glass {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #ffffff;
            border-radius: 9999px;
            transition: all 0.3s ease;
        }

        .art-button-glass:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .gradient-headline {
            background: linear-gradient(135deg, #ffffff 0%, #a1a1aa 50%, #52525b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Ambient Glows */
        .ambient-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
        }

        /* Map Dark Filter */
        .map-dark-filter {
            filter: invert(90%) hue-rotate(180deg) contrast(1.2) grayscale(0.8);
        }

        /* Ticker Animation */
        @keyframes ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .animate-ticker {
            display: flex;
            width: 200%;
            animation: ticker 30s linear infinite;
        }

        /* Table Blueprint SVG Styling */
        .table-node {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .table-node:hover {
            fill: rgba(255, 255, 255, 0.25) !important;
            stroke: #ffffff !important;
            stroke-width: 3px !important;
        }
    </style>
</head>
<body class="relative bg-zinc-950 text-zinc-100 antialiased selection:bg-zinc-800 selection:text-white">

    <!-- Ambient Background Lighting -->
    <div class="ambient-glow w-[600px] h-[600px] bg-zinc-800/20 top-0 left-1/2 -translate-x-1/2"></div>
    <div class="ambient-glow w-[800px] h-[800px] bg-zinc-700/10 top-[1200px] right-0"></div>

    <!-- 3D WebGL Canvas (Human Mannequin in Suit & Cyber Hand) -->
    <div id="canvas-container" class="fixed inset-0 z-0 pointer-events-none opacity-90"></div>

    <!-- FLOATING NAVIGATION BAR -->
    <header class="fixed top-6 inset-x-0 z-50 flex justify-center px-4">
        <nav class="art-card-pill px-8 py-4 flex items-center justify-between gap-8 max-w-6xl w-full shadow-2xl">
            <!-- Brand Logo -->
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-2xl bg-zinc-800 border border-zinc-700 flex items-center justify-center transition-transform group-hover:scale-105">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9" stroke-dasharray="3 3"/>
                        <circle cx="12" cy="12" r="4" fill="currentColor"/>
                    </svg>
                </div>
                <div>
                    <span class="font-display font-bold text-xl tracking-wider text-white block leading-none">ОРБИТА</span>
                    <span class="text-[9px] text-zinc-400 tracking-widest uppercase mt-0.5 block font-mono">Яузская 1/15</span>
                </div>
            </a>

            <!-- Nav Links -->
            <div class="hidden md:flex items-center gap-8 text-xs font-semibold uppercase tracking-wider text-zinc-300">
                <a href="#concept" class="hover:text-white transition-colors">Концепция</a>
                <a href="#events" class="hover:text-white transition-colors">DJ Афиша</a>
                <a href="#floorplan" class="hover:text-white transition-colors">3D Схема</a>
                <a href="#menu" class="hover:text-white transition-colors">Гастрономия</a>
                <a href="#map-section" class="hover:text-white transition-colors">Карта</a>
            </div>

            <!-- Action -->
            <button onclick="openBookingModal()" class="art-button-primary px-6 py-2.5 text-xs font-bold uppercase tracking-wider cursor-pointer">
                Забронировать
            </button>
        </nav>
    </header>

    <!-- MARQUEE TICKER -->
    <div class="relative z-10 top-28 overflow-hidden py-3 bg-zinc-900/60 border-y border-zinc-800/80 backdrop-blur-md">
        <div class="animate-ticker text-xs font-mono text-zinc-400 uppercase tracking-widest gap-12 items-center">
            <span>// ОСОБНЯК XVIII ВЕКА</span>
            <span>// АВТОРСКАЯ МИКСОЛОГИЯ</span>
            <span>// ВАНИ ДМИТРИЕНКО ПРОЕКТ</span>
            <span>// NIGHT MATRIX PERFORMANCES</span>
            <span>// РЕЗЕРВ СТОЛОВ ONLINE</span>
            <span>// ОСОБНЯК XVIII ВЕКА</span>
            <span>// АВТОРСКАЯ МИКСОЛОГИЯ</span>
            <span>// ВАНИ ДМИТРИЕНКО ПРОЕКТ</span>
            <span>// NIGHT MATRIX PERFORMANCES</span>
            <span>// РЕЗЕРВ СТОЛОВ ONLINE</span>
        </div>
    </div>

    <!-- MAIN CONTENT CONTAINER -->
    <main class="relative z-10 pt-36 pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-36">

        <!-- HERO SECTION -->
        <section class="min-h-[85vh] flex flex-col justify-center items-center text-center relative py-12">
            <!-- 3D Indicator Badge -->
            <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full bg-zinc-900/80 border border-zinc-700/80 backdrop-blur-xl mb-8">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                <span class="text-xs font-mono text-zinc-300 uppercase tracking-widest">3D Studio Stage // Humanoid Cyber Art Sculpture</span>
            </div>

            <h1 class="font-display text-5xl sm:text-7xl lg:text-9xl font-black tracking-tight max-w-6xl leading-[1.02] mb-8">
                ДВИГАЙСЯ <br>
                <span class="gradient-headline">ВМЕСТЕ С ОРБИТОЙ</span>
            </h1>

            <p class="text-lg sm:text-2xl text-zinc-400 max-w-3xl font-light leading-relaxed mb-12">
                Синтез фэнси-бара, культурного кластера и виртуальной арт-лаборатории. Пространство, где историческая архитектура XVIII века встречается с будущем.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-5 w-full max-w-lg">
                <button onclick="openBookingModal()" class="w-full sm:w-auto px-10 py-5 art-button-primary text-sm uppercase tracking-wider cursor-pointer">
                    Забронировать стол
                </button>
                <a href="#floorplan" class="w-full sm:w-auto px-10 py-5 art-button-glass text-sm font-semibold uppercase tracking-wider text-center">
                    3D Интерактивная схема
                </a>
            </div>

            <!-- Key Feature Cards Row -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-24 w-full max-w-5xl">
                <div class="art-card-glass p-8 text-left relative overflow-hidden group">
                    <div class="text-xs font-mono text-zinc-500 uppercase mb-2">01 / Дневной Режим</div>
                    <div class="font-display text-2xl font-bold text-white mb-2">Fancy Bar & Cowork</div>
                    <p class="text-xs text-zinc-400 leading-relaxed">Спешелти кофе, ланчи, авторские десерты и акустический комфорт с 12:00 до 18:00.</p>
                </div>

                <div class="art-card-glass p-8 text-left relative overflow-hidden group border-zinc-600/50">
                    <div class="text-xs font-mono text-zinc-400 uppercase mb-2">02 / Ночной Матрикс</div>
                    <div class="font-display text-2xl font-bold text-white mb-2">Night Matrix Club</div>
                    <p class="text-xs text-zinc-400 leading-relaxed">Авторская миксология, диджей-сеты артистов, светомузыкальная трансформация с 18:00 до 03:00.</p>
                </div>

                <div class="art-card-glass p-8 text-left relative overflow-hidden group">
                    <div class="text-xs font-mono text-zinc-500 uppercase mb-2">03 / Локация</div>
                    <div class="font-display text-2xl font-bold text-white mb-2">Исторический Особняк</div>
                    <p class="text-xs text-zinc-400 leading-relaxed">330 м² уникальной архитектуры на ул. Яузская, 1/15, Китай-город.</p>
                </div>
            </div>
        </section>

        <!-- LIVE EVENTS POSTER & DJ LINEUP SECTION -->
        <section id="events" class="space-y-12 scroll-mt-32">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="text-xs font-mono uppercase tracking-widest text-zinc-500 mb-2">// 🚀 LINEUP & PERFORMANCES</div>
                    <h2 class="font-display text-4xl sm:text-5xl font-black text-white">Афиша Night Matrix</h2>
                </div>
                <span class="text-xs font-mono text-zinc-400 border border-zinc-800 px-4 py-2 rounded-full bg-zinc-900">Ближайшие уикенды</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Event Card 1 -->
                <div class="art-card-glass p-8 sm:p-10 relative overflow-hidden flex flex-col justify-between min-h-[380px] group">
                    <div class="flex justify-between items-start">
                        <span class="px-4 py-1.5 rounded-full text-xs font-mono bg-zinc-800 text-zinc-200 border border-zinc-700">ПЯТНИЦА / 24 ОКТЯБРЯ / 22:00</span>
                        <span class="text-xs font-mono text-emerald-400">FREE ENTRY / GUESTLIST</span>
                    </div>

                    <div class="my-6 space-y-3">
                        <div class="text-xs text-zinc-400 uppercase tracking-widest font-mono">Deep Minimal & Organic House</div>
                        <h3 class="font-display text-3xl sm:text-4xl font-extrabold text-white">ECLIPSE SOUNDSCAPE</h3>
                        <p class="text-sm text-zinc-400 leading-relaxed">Специальный виниловый сет от резидентов системы Orbita с живым перкуссионным сопровождением.</p>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-zinc-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-zinc-800 border border-zinc-700 flex items-center justify-center font-bold text-xs">DJ</div>
                            <span class="text-xs font-bold text-zinc-200">DJ ALEX MATRIX & GUESTS</span>
                        </div>
                        <button onclick="openBookingModal()" class="art-button-glass px-5 py-2 text-xs font-bold uppercase cursor-pointer">Бронь стола</button>
                    </div>
                </div>

                <!-- Event Card 2 -->
                <div class="art-card-glass p-8 sm:p-10 relative overflow-hidden flex flex-col justify-between min-h-[380px] group border-zinc-700">
                    <div class="flex justify-between items-start">
                        <span class="px-4 py-1.5 rounded-full text-xs font-mono bg-zinc-800 text-zinc-200 border border-zinc-700">СУББОТА / 25 ОКТЯБРЯ / 23:00</span>
                        <span class="text-xs font-mono text-zinc-400">FC / DC 21+</span>
                    </div>

                    <div class="my-6 space-y-3">
                        <div class="text-xs text-zinc-400 uppercase tracking-widest font-mono">Indie Dance & Cyber Tech</div>
                        <h3 class="font-display text-3xl sm:text-4xl font-extrabold text-white">ORBITAL SINGULARITY</h3>
                        <p class="text-sm text-zinc-400 leading-relaxed">Ночное погружение с кастомным визио-арт перформансом и хедлайнером из Санкт-Петербурга.</p>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-zinc-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-zinc-800 border border-zinc-700 flex items-center justify-center font-bold text-xs">VJ</div>
                            <span class="text-xs font-bold text-zinc-200">VANIA DMITRIENKO & FRIENDS</span>
                        </div>
                        <button onclick="openBookingModal()" class="art-button-glass px-5 py-2 text-xs font-bold uppercase cursor-pointer">Бронь стола</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- INTERACTIVE FLOORPLAN / BLUEPRINT SEATING MAP -->
        <section id="floorplan" class="space-y-12 scroll-mt-32">
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <div class="text-xs font-mono uppercase tracking-widest text-zinc-500">// 📍 INTERACTIVE BLUEPRINT</div>
                <h2 class="font-display text-4xl sm:text-5xl font-black text-white">Интерактивная Схема Зала</h2>
                <p class="text-zinc-400 text-sm">Выберите интересующий стол или зону на схеме для мгновенного бронирования</p>
            </div>

            <div class="art-card-glass p-8 sm:p-12 relative overflow-hidden">
                <!-- SVG Floorplan Map -->
                <div class="relative w-full overflow-x-auto">
                    <svg viewBox="0 0 1000 500" class="w-full min-w-[700px] h-auto rounded-2xl bg-zinc-950 border border-zinc-800">
                        <defs>
                            <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.04)" stroke-width="1"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid)" />

                        <!-- Zone 1: Main Bar Area -->
                        <g id="zone-bar-svg" class="table-node" onclick="openBookingWithTable('Барный Зал', 'Стол #1 (4 чел)')">
                            <rect x="50" y="80" width="380" height="340" rx="20" fill="rgba(39, 39, 42, 0.4)" stroke="rgba(255,255,255,0.15)" stroke-width="2"/>
                            <text x="70" y="120" fill="#ffffff" font-family="Syne" font-size="20" font-weight="bold">ГЛАВНЫЙ БАРНЫЙ ЗАЛ</text>
                            <text x="70" y="145" fill="#a1a1aa" font-size="12" font-family="JetBrains Mono">40 Посадочных мест // Контактный Бар</text>

                            <!-- Table nodes -->
                            <rect x="90" y="180" width="80" height="80" rx="12" fill="rgba(255,255,255,0.08)" stroke="#71717a"/>
                            <text x="110" y="225" fill="#fff" font-size="12" font-family="JetBrains Mono">T-01</text>

                            <rect x="200" y="180" width="80" height="80" rx="12" fill="rgba(255,255,255,0.08)" stroke="#71717a"/>
                            <text x="220" y="225" fill="#fff" font-size="12" font-family="JetBrains Mono">T-02</text>

                            <rect x="310" y="180" width="80" height="80" rx="12" fill="rgba(255,255,255,0.08)" stroke="#71717a"/>
                            <text x="330" y="225" fill="#fff" font-size="12" font-family="JetBrains Mono">T-03</text>

                            <!-- Long Bar Counter -->
                            <rect x="90" y="300" width="300" height="40" rx="10" fill="rgba(255,255,255,0.15)" stroke="#a1a1aa"/>
                            <text x="170" y="325" fill="#fff" font-size="12" font-family="Syne" font-weight="bold">БАРНАЯ СТОЙКА</text>
                        </g>

                        <!-- Zone 2: Lounge Gallery -->
                        <g id="zone-lounge-svg" class="table-node" onclick="openBookingWithTable('Лаунж Галерея', 'Балконная Софа #4')">
                            <rect x="470" y="80" width="480" height="180" rx="20" fill="rgba(39, 39, 42, 0.4)" stroke="rgba(255,255,255,0.15)" stroke-width="2"/>
                            <text x="490" y="120" fill="#ffffff" font-family="Syne" font-size="20" font-weight="bold">ЛАУНЖ ГАЛЕРЕЯ (2 ЭТАЖ)</text>
                            <text x="490" y="145" fill="#a1a1aa" font-size="12" font-family="JetBrains Mono">25 Мест // Мягкие диваны // Панорамный вид</text>

                            <rect x="500" y="170" width="120" height="60" rx="12" fill="rgba(255,255,255,0.08)" stroke="#71717a"/>
                            <text x="535" y="205" fill="#fff" font-size="12" font-family="JetBrains Mono">L-SOFA 1</text>

                            <rect x="650" y="170" width="120" height="60" rx="12" fill="rgba(255,255,255,0.08)" stroke="#71717a"/>
                            <text x="685" y="205" fill="#fff" font-size="12" font-family="JetBrains Mono">L-SOFA 2</text>

                            <rect x="800" y="170" width="120" height="60" rx="12" fill="rgba(255,255,255,0.08)" stroke="#71717a"/>
                            <text x="835" y="205" fill="#fff" font-size="12" font-family="JetBrains Mono">L-SOFA 3</text>
                        </g>

                        <!-- Zone 3: VIP Cigar Lounge -->
                        <g id="zone-vip-svg" class="table-node" onclick="openBookingWithTable('VIP Сигарная', 'Кабинет VIP (12 чел)')">
                            <rect x="470" y="280" width="480" height="140" rx="20" fill="rgba(39, 39, 42, 0.4)" stroke="rgba(255,255,255,0.15)" stroke-width="2"/>
                            <text x="490" y="320" fill="#ffffff" font-family="Syne" font-size="20" font-weight="bold">VIP СИГАРНЫЙ КАБИНЕТ</text>
                            <text x="490" y="345" fill="#a1a1aa" font-size="12" font-family="JetBrains Mono">12 Мест // Приватная винная комната</text>

                            <rect x="500" y="360" width="420" height="40" rx="10" fill="rgba(255,255,255,0.12)" stroke="#fff"/>
                            <text x="620" y="385" fill="#fff" font-size="12" font-family="Syne" font-weight="bold">ПРИВАТНЫЙ ОВАЛЬНЫЙ СТОЛ</text>
                        </g>
                    </svg>
                </div>

                <div class="mt-6 flex flex-wrap items-center justify-between gap-4 text-xs font-mono text-zinc-400">
                    <div class="flex items-center gap-6">
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded bg-zinc-700"></span> Доступные столы</span>
                        <span class="flex items-center gap-2"><span class="w-3 h-3 rounded bg-white"></span> Выбранный сектор</span>
                    </div>
                    <span>* Нажмите на любой сектор на схеме для бронирования</span>
                </div>
            </div>
        </section>

        <!-- GASTRONOMY & MIXOLOGY SHOWCASE -->
        <section id="menu" class="space-y-12 scroll-mt-32">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="text-xs font-mono uppercase tracking-widest text-zinc-500 mb-2">// 🍸 HIGH GASTRONOMY & MIXOLOGY</div>
                    <h2 class="font-display text-4xl sm:text-5xl font-black text-white">Авторская Карта</h2>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="toggleMenuTab('cocktails')" id="tab-btn-cocktails" class="px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider bg-white text-zinc-950 transition-all cursor-pointer">
                        Коктейли
                    </button>
                    <button onclick="toggleMenuTab('kitchen')" id="tab-btn-kitchen" class="px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white transition-all cursor-pointer">
                        Кухня
                    </button>
                </div>
            </div>

            <!-- Cocktails View -->
            <div id="menu-cocktails" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="art-card-glass p-8 space-y-6 relative overflow-hidden group">
                    <div class="w-12 h-12 rounded-2xl bg-zinc-800 border border-zinc-700 flex items-center justify-center font-display font-bold text-white">01</div>
                    <div>
                        <span class="text-xs font-mono text-zinc-400 uppercase">Signature Cocktail</span>
                        <h3 class="font-display text-2xl font-bold text-white mt-1">ORBITA SIGNAL #1</h3>
                        <p class="text-xs text-zinc-400 mt-2 leading-relaxed">Джин на лемонграссе, кордиал из белого персика, юдзу, золотая пыльца.</p>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-zinc-800 font-mono">
                        <span class="text-xs text-zinc-500">300 мл // 14% ABV</span>
                        <span class="font-bold text-lg text-white">890 ₽</span>
                    </div>
                </div>

                <div class="art-card-glass p-8 space-y-6 relative overflow-hidden group border-zinc-700">
                    <div class="w-12 h-12 rounded-2xl bg-zinc-800 border border-zinc-700 flex items-center justify-center font-display font-bold text-white">02</div>
                    <div>
                        <span class="text-xs font-mono text-zinc-400 uppercase">Smoked Bourbon</span>
                        <h3 class="font-display text-2xl font-bold text-white mt-1">MIDNIGHT ECLIPSE</h3>
                        <p class="text-xs text-zinc-400 mt-2 leading-relaxed">Бурбон 8-летней выдержки, выпаренный портвейн, ежевичный биттер, дым дуба.</p>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-zinc-800 font-mono">
                        <span class="text-xs text-zinc-500">250 мл // 22% ABV</span>
                        <span class="font-bold text-lg text-white">950 ₽</span>
                    </div>
                </div>

                <div class="art-card-glass p-8 space-y-6 relative overflow-hidden group">
                    <div class="w-12 h-12 rounded-2xl bg-zinc-800 border border-zinc-700 flex items-center justify-center font-display font-bold text-white">03</div>
                    <div>
                        <span class="text-xs font-mono text-zinc-400 uppercase">Tropical Zero Gravity</span>
                        <h3 class="font-display text-2xl font-bold text-white mt-1">ZERO GRAVITY</h3>
                        <p class="text-xs text-zinc-400 mt-2 leading-relaxed">Текила Reposado, кордиал из спелой маракуйи, содовая из жасмина.</p>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-zinc-800 font-mono">
                        <span class="text-xs text-zinc-500">350 мл // 12% ABV</span>
                        <span class="font-bold text-lg text-white">850 ₽</span>
                    </div>
                </div>
            </div>

            <!-- Kitchen View (Hidden by default) -->
            <div id="menu-kitchen" class="hidden grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="art-card-glass p-8 space-y-6 relative overflow-hidden">
                    <div class="w-12 h-12 rounded-2xl bg-zinc-800 border border-zinc-700 flex items-center justify-center font-display font-bold text-white">01</div>
                    <div>
                        <span class="text-xs font-mono text-zinc-400 uppercase">Cold Starter</span>
                        <h3 class="font-display text-2xl font-bold text-white mt-1">Тартар из Тунца</h3>
                        <p class="text-xs text-zinc-400 mt-2 leading-relaxed">Свежий желтопёрый тунец, авокадо хасс, понзу из юдзу, хрустящий чипс из нори.</p>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-zinc-800 font-mono">
                        <span class="text-xs text-zinc-500">180 г</span>
                        <span class="font-bold text-lg text-white">1 100 ₽</span>
                    </div>
                </div>

                <div class="art-card-glass p-8 space-y-6 relative overflow-hidden">
                    <div class="w-12 h-12 rounded-2xl bg-zinc-800 border border-zinc-700 flex items-center justify-center font-display font-bold text-white">02</div>
                    <div>
                        <span class="text-xs font-mono text-zinc-400 uppercase">Main Course</span>
                        <h3 class="font-display text-2xl font-bold text-white mt-1">Утиная Грудка Sous-Vide</h3>
                        <p class="text-xs text-zinc-400 mt-2 leading-relaxed">Соус из вяленой вишни, пюре из печеного пастернака и запеченный пак-чой.</p>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-zinc-800 font-mono">
                        <span class="text-xs text-zinc-500">280 г</span>
                        <span class="font-bold text-lg text-white">1 450 ₽</span>
                    </div>
                </div>

                <div class="art-card-glass p-8 space-y-6 relative overflow-hidden">
                    <div class="w-12 h-12 rounded-2xl bg-zinc-800 border border-zinc-700 flex items-center justify-center font-display font-bold text-white">03</div>
                    <div>
                        <span class="text-xs font-mono text-zinc-400 uppercase">Risotto</span>
                        <h3 class="font-display text-2xl font-bold text-white mt-1">Трюфельный Ризотто</h3>
                        <p class="text-xs text-zinc-400 mt-2 leading-relaxed">Итальянский рис Карнароли, белые грибы, пармезан 24 мес, стружка свежего трюфеля.</p>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-zinc-800 font-mono">
                        <span class="text-xs text-zinc-500">250 г</span>
                        <span class="font-bold text-lg text-white">1 250 ₽</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- MAP & LOCATION SECTION (YANDEX MAP EMBEDDED) -->
        <section id="map-section" class="space-y-12 scroll-mt-32">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="text-xs font-mono uppercase tracking-widest text-zinc-500 mb-2">// 🗺️ GEOLOCATION & NAVIGATION</div>
                    <h2 class="font-display text-4xl sm:text-5xl font-black text-white">Карта и Проезд</h2>
                </div>
                <div class="text-xs font-mono text-zinc-400">Москва, ул. Яузская, 1/15 (м. Китай-Город / Таганская)</div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Info Column -->
                <div class="lg:col-span-5 art-card-glass p-8 sm:p-10 space-y-8 flex flex-col justify-between">
                    <div>
                        <span class="px-3 py-1 rounded-full text-xs font-mono bg-zinc-800 text-zinc-300 border border-zinc-700">Исторический Особняк</span>
                        <h3 class="font-display text-3xl font-bold text-white mt-4">Как нас найти</h3>
                        <p class="text-sm text-zinc-400 mt-3 leading-relaxed">
                            Бар располагается в отдельно стоящем особняке XVIII века на Яузской улице. Собственный закрытый двор с парковкой для гостей.
                        </p>
                    </div>

                    <div class="space-y-4 font-mono text-xs text-zinc-300">
                        <div class="p-4 rounded-2xl bg-zinc-900/80 border border-zinc-800 flex items-center justify-between">
                            <span>🚶 Метро Китай-город</span>
                            <span class="text-zinc-400">7 мин пешком</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-zinc-900/80 border border-zinc-800 flex items-center justify-between">
                            <span>🚶 Метро Таганская</span>
                            <span class="text-zinc-400">9 мин пешком</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-zinc-900/80 border border-zinc-800 flex items-center justify-between">
                            <span>🅿️ Валет-паркинг</span>
                            <span class="text-zinc-400">Внутренний двор</span>
                        </div>
                    </div>

                    <a href="https://yandex.ru/maps/-/CDuP5B31" target="_blank" class="art-button-primary py-4 w-full text-center text-xs font-bold uppercase tracking-wider block">
                        Построить маршрут в Навигаторе
                    </a>
                </div>

                <!-- Interactive Yandex Map Embed Frame -->
                <div class="lg:col-span-7 art-card-glass overflow-hidden relative min-h-[420px] rounded-3xl border-zinc-800">
                    <iframe
                        src="https://yandex.ru/map-widget/v1/?ll=37.643200%2C55.751200&z=16&pt=37.643200%2C55.751200%2Cpm2rdm"
                        class="w-full h-full min-h-[420px] border-0 map-dark-filter"
                        allowfullscreen="true">
                    </iframe>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="border-t border-zinc-900 bg-zinc-950 py-16 relative z-10 mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="space-y-2 text-center md:text-left">
                <span class="font-display font-black text-2xl text-white">ОРБИТА</span>
                <p class="text-xs text-zinc-500">Фэнси-бар & Культурный кластер Вани Дмитриенко // 2025</p>
            </div>
            <div class="flex items-center gap-8 text-xs font-mono text-zinc-400">
                <a href="#concept" class="hover:text-white">Концепция</a>
                <a href="#events" class="hover:text-white">Афиша</a>
                <a href="#floorplan" class="hover:text-white">Схема</a>
                <a href="#map-section" class="hover:text-white">Карта</a>
            </div>
        </div>
    </footer>

    <!-- BOOKING MODAL -->
    <div id="booking-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/85 backdrop-blur-xl">
        <div class="art-card-glass max-w-xl w-full p-8 sm:p-10 relative space-y-6 border-zinc-700 shadow-2xl">
            <button onclick="closeBookingModal()" class="absolute top-6 right-6 w-10 h-10 rounded-full bg-zinc-800 border border-zinc-700 flex items-center justify-center text-zinc-400 hover:text-white cursor-pointer">
                ✕
            </button>

            <div>
                <span class="text-xs font-mono uppercase tracking-widest text-zinc-400">// ONLINE RESERVATION SYSTEM</span>
                <h3 class="font-display text-3xl font-bold text-white mt-1">Резерв Стола</h3>
            </div>

            <form id="booking-form" onsubmit="handleBookingSubmit(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-mono text-zinc-400 uppercase mb-1">ФИО Гостя</label>
                    <input type="text" required id="book-name" class="w-full bg-zinc-900 border border-zinc-800 rounded-2xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-zinc-500 transition-colors" placeholder="Иван Иванов">
                </div>

                <div>
                    <label class="block text-xs font-mono text-zinc-400 uppercase mb-1">Номер Телефона</label>
                    <input type="tel" required id="book-phone" class="w-full bg-zinc-900 border border-zinc-800 rounded-2xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-zinc-500 transition-colors" placeholder="+7 (999) 000-00-00">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-mono text-zinc-400 uppercase mb-1">Дата</label>
                        <input type="date" required id="book-date" class="w-full bg-zinc-900 border border-zinc-800 rounded-2xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-zinc-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-mono text-zinc-400 uppercase mb-1">Время</label>
                        <select required id="book-time" class="w-full bg-zinc-900 border border-zinc-800 rounded-2xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-zinc-500 transition-colors">
                            <option value="18:00">18:00</option>
                            <option value="19:00">19:00</option>
                            <option value="20:00">20:00</option>
                            <option value="21:00">21:00</option>
                            <option value="22:00">22:00</option>
                            <option value="23:00">23:00</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-mono text-zinc-400 uppercase mb-1">Гости</label>
                        <input type="number" min="1" max="12" value="2" required id="book-guests" class="w-full bg-zinc-900 border border-zinc-800 rounded-2xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-zinc-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-mono text-zinc-400 uppercase mb-1">Зона</label>
                        <select id="book-zone" class="w-full bg-zinc-900 border border-zinc-800 rounded-2xl px-4 py-3.5 text-sm text-white focus:outline-none focus:border-zinc-500 transition-colors">
                            <option value="Главный Бар">Главный Бар</option>
                            <option value="Лаунж Галерея">Лаунж Галерея</option>
                            <option value="VIP Сигарная">VIP Сигарная</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 rounded-2xl art-button-primary text-xs font-bold uppercase tracking-wider cursor-pointer mt-4">
                    Подтвердить бронирование
                </button>
            </form>

            <div id="booking-success" class="hidden text-center py-8 space-y-3">
                <div class="w-14 h-14 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center mx-auto text-2xl">✓</div>
                <h4 class="font-display text-2xl font-bold text-white">Стол забронирован!</h4>
                <p class="text-xs font-mono text-zinc-400">Наш хостес подтвердит вашу заявку по указанному номеру.</p>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        document.getElementById('book-date').value = new Date().toISOString().split('T')[0];

        function toggleMenuTab(tab) {
            const cocktails = document.getElementById('menu-cocktails');
            const kitchen = document.getElementById('menu-kitchen');
            const btnC = document.getElementById('tab-btn-cocktails');
            const btnK = document.getElementById('tab-btn-kitchen');

            if (tab === 'cocktails') {
                cocktails.classList.remove('hidden');
                kitchen.classList.add('hidden');
                btnC.className = 'px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider bg-white text-zinc-950 transition-all cursor-pointer';
                btnK.className = 'px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white transition-all cursor-pointer';
            } else {
                cocktails.classList.add('hidden');
                kitchen.classList.remove('hidden');
                btnK.className = 'px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider bg-white text-zinc-950 transition-all cursor-pointer';
                btnC.className = 'px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white transition-all cursor-pointer';
            }
        }

        function openBookingModal() {
            document.getElementById('booking-modal').classList.remove('hidden');
        }

        function openBookingWithTable(zoneName, tableName) {
            const selectZone = document.getElementById('book-zone');
            if (selectZone) selectZone.value = zoneName;
            openBookingModal();
        }

        function closeBookingModal() {
            document.getElementById('booking-modal').classList.add('hidden');
        }

        async function handleBookingSubmit(e) {
            e.preventDefault();
            const form = document.getElementById('booking-form');
            const success = document.getElementById('booking-success');

            const payload = {
                name: document.getElementById('book-name').value,
                phone: document.getElementById('book-phone').value,
                date: document.getElementById('book-date').value,
                time: document.getElementById('book-time').value,
                guests: parseInt(document.getElementById('book-guests').value),
                zone: document.getElementById('book-zone').value,
            };

            try {
                const res = await fetch('/api/bookings', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });

                if (res.ok) {
                    form.classList.add('hidden');
                    success.classList.remove('hidden');
                    setTimeout(() => {
                        closeBookingModal();
                        form.classList.remove('hidden');
                        success.classList.add('hidden');
                    }, 2500);
                }
            } catch (err) {
                console.error(err);
            }
        }

        // THREE.JS 3D PROCEDURAL HUMANOID MANNEQUIN IN SUIT & ARTICULATED CYBER HAND STAGE
        window.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('canvas-container');
            if (!container || typeof THREE === 'undefined') return;

            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(55, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.set(0, 0, 16);

            const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            container.appendChild(renderer.domElement);

            // Lighting setup for high contrast studio mannequin
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.3);
            scene.add(ambientLight);

            const keyLight = new THREE.DirectionalLight(0xffffff, 1.8);
            keyLight.position.set(10, 15, 10);
            scene.add(keyLight);

            const fillLight = new THREE.DirectionalLight(0x71717a, 1.2);
            fillLight.position.set(-10, -10, -5);
            scene.add(fillLight);

            // Procedural Humanoid Suit Mannequin Group
            const mannequinGroup = new THREE.Group();

            // Head (smooth faceted sphere)
            const headGeo = new THREE.IcosahedronGeometry(1.2, 3);
            const chromeMat = new THREE.MeshStandardMaterial({
                color: 0xd4d4d8,
                metalness: 0.9,
                roughness: 0.1
            });
            const head = new THREE.Mesh(headGeo, chromeMat);
            head.position.y = 3.2;
            mannequinGroup.add(head);

            // Suit Collar & Neck
            const neckGeo = new THREE.CylinderGeometry(0.5, 0.6, 0.8, 16);
            const neck = new THREE.Mesh(neckGeo, chromeMat);
            neck.position.y = 2.2;
            mannequinGroup.add(neck);

            // Tuxedo / Suit Torso Sculpture
            const torsoGeo = new THREE.CylinderGeometry(1.8, 1.1, 3.2, 16);
            const suitMat = new THREE.MeshStandardMaterial({
                color: 0x18181b,
                metalness: 0.5,
                roughness: 0.4
            });
            const torso = new THREE.Mesh(torsoGeo, suitMat);
            torso.position.y = 0.3;
            mannequinGroup.add(torso);

            // Suit Lapels (V-Shape Cutout)
            const lapelGeo = new THREE.ConeGeometry(0.8, 2.2, 4);
            lapelGeo.rotateX(Math.PI);
            const lapelMat = new THREE.MeshStandardMaterial({ color: 0x27272a, roughness: 0.2, metalness: 0.8 });
            const lapels = new THREE.Mesh(lapelGeo, lapelMat);
            lapels.position.set(0, 1.0, 1.0);
            lapels.scale.set(1.2, 1, 0.3);
            mannequinGroup.add(lapels);

            // Articulated Floating Metallic Cyber Hand
            const handGroup = new THREE.Group();

            // Palm
            const palmGeo = new THREE.BoxGeometry(1.2, 1.4, 0.4);
            const palm = new THREE.Mesh(palmGeo, chromeMat);
            handGroup.add(palm);

            // 4 Articulated Fingers
            for(let i=0; i<4; i++) {
                const fingerGeo = new THREE.CylinderGeometry(0.12, 0.1, 1.0, 12);
                const finger = new THREE.Mesh(fingerGeo, chromeMat);
                finger.position.set(-0.45 + i*0.3, 1.0, 0);
                finger.rotation.z = -0.1 + i*0.05;
                handGroup.add(finger);
            }

            // Thumb
            const thumbGeo = new THREE.CylinderGeometry(0.12, 0.1, 0.8, 12);
            const thumb = new THREE.Mesh(thumbGeo, chromeMat);
            thumb.position.set(-0.7, -0.2, 0.2);
            thumb.rotation.z = 0.6;
            handGroup.add(thumb);

            // Glowing Floating Glass Orb in Hand
            const orbGeo = new THREE.SphereGeometry(0.8, 32, 32);
            const orbMat = new THREE.MeshPhysicalMaterial({
                color: 0xffffff,
                transmission: 0.9,
                opacity: 1,
                transparent: true,
                roughness: 0.05,
                ior: 1.5
            });
            const orb = new THREE.Mesh(orbGeo, orbMat);
            orb.position.set(0, 1.8, 0.3);
            handGroup.add(orb);

            handGroup.position.set(2.8, -0.5, 2.0);
            handGroup.rotation.y = -0.4;
            mannequinGroup.add(handGroup);

            // Add Mannequin Group to Scene
            mannequinGroup.position.set(3.5, 0, 0);
            scene.add(mannequinGroup);

            // Particle matrix background
            const particleCount = 500;
            const particleGeo = new THREE.BufferGeometry();
            const positions = new Float32Array(particleCount * 3);
            for(let i=0; i<particleCount*3; i++) {
                positions[i] = (Math.random() - 0.5) * 50;
            }
            particleGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
            const particleMat = new THREE.PointsMaterial({ size: 0.06, color: 0x71717a, transparent: true, opacity: 0.4 });
            const particles = new THREE.Points(particleGeo, particleMat);
            scene.add(particles);

            // Smooth Mouse Parallax Physics
            let targetX = 0;
            let targetY = 0;
            window.addEventListener('mousemove', (e) => {
                targetX = (e.clientX / window.innerWidth - 0.5) * 1.5;
                targetY = (e.clientY / window.innerHeight - 0.5) * 1.5;
            });

            // Animation Loop
            let clock = new THREE.Clock();
            function animate() {
                requestAnimationFrame(animate);
                const elapsedTime = clock.getElapsedTime();

                // Gentle floating & rotation
                mannequinGroup.rotation.y = Math.sin(elapsedTime * 0.5) * 0.15;
                mannequinGroup.position.y = Math.sin(elapsedTime * 1.2) * 0.2;

                handGroup.position.y = -0.5 + Math.cos(elapsedTime * 1.5) * 0.15;
                orb.rotation.y += 0.01;

                // Parallax easing
                camera.position.x += (targetX - camera.position.x) * 0.05;
                camera.position.y += (-targetY - camera.position.y) * 0.05;

                particles.rotation.y = elapsedTime * 0.02;

                renderer.render(scene, camera);
            }
            animate();

            // Resize
            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            });
        });
    </script>
</body>
</html>
