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

    <!-- Three.js for 3D Kinetic Orbital Core Stage -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #060608;
            color: #f4f4f5;
            overflow-x: hidden;
        }

        .font-display { font-family: 'Syne', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        /* Custom Interactive Glow Cursor */
        #custom-cursor {
            pointer-events: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0) 70%);
            border: 1px solid rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            z-index: 9999;
            transition: transform 0.15s ease-out, opacity 0.3s ease;
            backdrop-filter: blur(2px);
        }

        /* Custom Artistic Card Styles */
        .art-card-glass {
            background: linear-gradient(135deg, rgba(22, 22, 28, 0.75) 0%, rgba(12, 12, 16, 0.85) 100%);
            backdrop-filter: blur(28px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 2.2rem;
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.7);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            transform-style: preserve-3d;
        }

        .art-card-glass:hover {
            border-color: rgba(255, 255, 255, 0.22);
            transform: translateY(-6px) rotateX(1.5deg) rotateY(-1.5deg);
            box-shadow: 0 40px 80px -15px rgba(0, 0, 0, 0.9), 0 0 40px rgba(255, 255, 255, 0.05);
        }

        .art-card-pill {
            background: rgba(18, 18, 22, 0.85);
            backdrop-filter: blur(24px);
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
            box-shadow: 0 12px 30px rgba(255, 255, 255, 0.25);
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
            background: rgba(255, 255, 255, 0.16);
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
            filter: blur(140px);
            pointer-events: none;
            z-index: 0;
            transition: background 1s ease;
        }

        /* Map Dark Filter */
        .map-dark-filter {
            filter: invert(90%) hue-rotate(180deg) contrast(1.2) grayscale(0.85);
        }

        /* Ticker Animation */
        @keyframes ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .animate-ticker {
            display: flex;
            width: 200%;
            animation: ticker 28s linear infinite;
        }

        /* Audio Visualizer Waves */
        .sound-wave-bar {
            width: 3px;
            height: 12px;
            background: #ffffff;
            border-radius: 2px;
            animation: soundWave 1.2s infinite ease-in-out alternate;
        }
        @keyframes soundWave {
            0% { height: 4px; }
            100% { height: 16px; }
        }

        /* Table Blueprint SVG Styling */
        .table-node {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .table-node:hover {
            fill: rgba(255, 255, 255, 0.22) !important;
            stroke: #ffffff !important;
            stroke-width: 3px !important;
        }

        /* Custom Icon Badge Pill */
        .icon-badge {
            display: inline-flex;
            items-center: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: 0.75rem;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #f4f4f5;
        }

        /* Shiny Metallic VIP Card Effect */
        .vip-card-shiny {
            background: linear-gradient(135deg, rgba(30,30,38,0.95) 0%, rgba(10,10,14,0.98) 100%);
            position: relative;
            overflow: hidden;
        }
        .vip-card-shiny::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%; width: 200%; height: 200%;
            background: linear-gradient(45deg, transparent 40%, rgba(255,255,255,0.08) 50%, transparent 60%);
            transform: rotate(30deg);
            animation: shine 6s infinite;
        }
        @keyframes shine {
            0% { transform: translateY(-100%) rotate(30deg); }
            100% { transform: translateY(100%) rotate(30deg); }
        }
    </style>
</head>
<body class="relative bg-zinc-950 text-zinc-100 antialiased selection:bg-zinc-800 selection:text-white">

    <!-- Custom Pointer Follower Glow -->
    <div id="custom-cursor"></div>

    <!-- Ambient Background Lighting -->
    <div id="bg-glow-1" class="ambient-glow w-[650px] h-[650px] bg-zinc-800/20 top-0 left-1/2 -translate-x-1/2"></div>
    <div id="bg-glow-2" class="ambient-glow w-[850px] h-[850px] bg-zinc-700/10 top-[1200px] right-0"></div>

    <!-- 3D WebGL Canvas (Kinetic Orbital Astrolabe Core) -->
    <div id="canvas-container" class="fixed inset-0 z-0 pointer-events-none opacity-90"></div>

    <!-- FLOATING NAVIGATION BAR -->
    <header class="fixed top-6 inset-x-0 z-50 flex justify-center px-4">
        <nav class="art-card-pill px-8 py-4 flex items-center justify-between gap-8 max-w-6xl w-full shadow-2xl">
            <!-- Brand Logo -->
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-2xl bg-zinc-900 border border-zinc-700/80 flex items-center justify-center transition-transform group-hover:scale-105">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9" stroke-dasharray="2 2"/>
                        <circle cx="12" cy="12" r="4" fill="currentColor"/>
                    </svg>
                </div>
                <div>
                    <span class="font-display font-bold text-xl tracking-wider text-white block leading-none">ОРБИТА</span>
                    <span class="text-[9px] text-zinc-400 tracking-widest uppercase mt-0.5 block font-mono">Яузская 1/15</span>
                </div>
            </a>

            <!-- Nav Links -->
            <div class="hidden lg:flex items-center gap-7 text-xs font-semibold uppercase tracking-wider text-zinc-300">
                <a href="#concept" class="hover:text-white transition-colors">Концепция</a>
                <a href="#mixology-navigator" class="hover:text-white transition-colors">Миксология</a>
                <a href="#events" class="hover:text-white transition-colors">DJ Афиша</a>
                <a href="#floorplan" class="hover:text-white transition-colors">3D Схема</a>
                <a href="#vip-pass" class="hover:text-white transition-colors">VIP Карта</a>
                <a href="#map-section" class="hover:text-white transition-colors">Карта</a>
            </div>

            <!-- Actions Right -->
            <div class="flex items-center gap-4">
                <!-- Ambient Audio Atmosphere Toggle -->
                <button onclick="toggleAudioAtmosphere()" id="audio-toggle-btn" title="Звуковая Атмосфера" class="p-2.5 rounded-full bg-zinc-900 border border-zinc-700/80 hover:border-zinc-500 text-zinc-300 transition-all flex items-center gap-2 cursor-pointer">
                    <svg id="audio-icon" class="w-4 h-4 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.287a6 6 0 010 7.427M9 9H5a1 1 0 00-1 1v4a1 1 0 001 1h4l5 5V4L9 9z"/>
                    </svg>
                    <div id="audio-bars" class="hidden flex items-center gap-0.5">
                        <span class="sound-wave-bar" style="animation-delay: 0s;"></span>
                        <span class="sound-wave-bar" style="animation-delay: 0.2s;"></span>
                        <span class="sound-wave-bar" style="animation-delay: 0.4s;"></span>
                    </div>
                </button>

                <button onclick="openBookingModal()" class="art-button-primary px-6 py-2.5 text-xs font-bold uppercase tracking-wider cursor-pointer">
                    Забронировать
                </button>
            </div>
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
        <section id="concept" class="min-h-[85vh] flex flex-col justify-center items-center text-center relative py-12">

            <!-- 3D Theme Switcher Bar -->
            <div class="inline-flex items-center gap-3 p-1.5 rounded-full bg-zinc-900/90 border border-zinc-700/80 backdrop-blur-xl mb-8 shadow-xl">
                <span class="px-3 text-[10px] font-mono text-zinc-400 uppercase tracking-wider">Lighting Mode:</span>
                <button onclick="set3DLighting('chrome')" id="theme-btn-chrome" class="px-3 py-1 rounded-full text-xs font-mono bg-white text-zinc-950 font-bold transition-all cursor-pointer">Neo-Gold</button>
                <button onclick="set3DLighting('cyan')" id="theme-btn-cyan" class="px-3 py-1 rounded-full text-xs font-mono bg-zinc-800 text-zinc-400 hover:text-white transition-all cursor-pointer">Deep Cyan</button>
                <button onclick="set3DLighting('purple')" id="theme-btn-purple" class="px-3 py-1 rounded-full text-xs font-mono bg-zinc-800 text-zinc-400 hover:text-white transition-all cursor-pointer">Quantum Violet</button>
            </div>

            <h1 class="font-display text-5xl sm:text-7xl lg:text-9xl font-black tracking-tight max-w-6xl leading-[1.02] mb-8">
                ДВИГАЙСЯ <br>
                <span class="gradient-headline">ВМЕСТЕ С ОРБИТОЙ</span>
            </h1>

            <p class="text-lg sm:text-2xl text-zinc-400 max-w-3xl font-light leading-relaxed mb-12">
                Синтез фэнси-бара, культурного кластера и виртуальной арт-лаборатории. Пространство, где историческая архитектура XVIII века встречается с будущим.
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
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-mono text-zinc-500 uppercase">01 / Дневной Режим</span>
                        <div class="icon-badge">
                            <svg class="w-4 h-4 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="5"/>
                                <path stroke-linecap="round" d="M12 2v2m0 16v2m10-10h-2M4 12H2m16.07-6.07l-1.41 1.41M7.34 16.66l-1.41 1.41m12.14 0l-1.41-1.41M7.34 7.34L5.93 5.93"/>
                            </svg>
                        </div>
                    </div>
                    <div class="font-display text-2xl font-bold text-white mb-2">Fancy Bar & Cowork</div>
                    <p class="text-xs text-zinc-400 leading-relaxed">Спешелти кофе, ланчи, авторские десерты и акустический комфорт с 12:00 до 18:00.</p>
                </div>

                <div class="art-card-glass p-8 text-left relative overflow-hidden group border-zinc-600/50">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-mono text-zinc-400 uppercase">02 / Ночной Матрикс</span>
                        <div class="icon-badge">
                            <svg class="w-4 h-4 text-zinc-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm12 0c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2Z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="font-display text-2xl font-bold text-white mb-2">Night Matrix Club</div>
                    <p class="text-xs text-zinc-400 leading-relaxed">Авторская миксология, диджей-сеты артистов, светомузыкальная трансформация с 18:00 до 03:00.</p>
                </div>

                <div class="art-card-glass p-8 text-left relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-mono text-zinc-500 uppercase">03 / Локация</span>
                        <div class="icon-badge">
                            <svg class="w-4 h-4 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="font-display text-2xl font-bold text-white mb-2">Исторический Особняк</div>
                    <p class="text-xs text-zinc-400 leading-relaxed">330 м² уникальной архитектуры на ул. Яузская, 1/15, Китай-город.</p>
                </div>
            </div>
        </section>

        <!-- INTERACTIVE MIXOLOGY MOOD NAVIGATOR -->
        <section id="mixology-navigator" class="space-y-12 scroll-mt-32">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-mono uppercase tracking-widest text-zinc-500 mb-2">
                        <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.4 15.12a2 2 0 00-1.022.547l-1.096 1.096a2 2 0 00.586 3.414l2.828.808a10 10 0 005.608 0l2.828-.808a2 2 0 00.586-3.414l-1.096-1.096z"/>
                        </svg>
                        <span>// AI MIXOLOGY MATRIX</span>
                    </div>
                    <h2 class="font-display text-4xl sm:text-5xl font-black text-white">Миксологический Навигатор</h2>
                </div>
                <span class="text-xs font-mono text-zinc-400 border border-zinc-800 px-4 py-2 rounded-full bg-zinc-900">Интерактивный Подбор Напитка</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <!-- Mood Buttons Selector -->
                <div class="lg:col-span-5 space-y-4">
                    <p class="text-xs font-mono text-zinc-400 uppercase">Выберите ваше текущее настроение вечерней орбиты:</p>

                    <div class="space-y-3">
                        <button onclick="selectCocktailMood('deep')" id="mood-btn-deep" class="w-full text-left p-5 rounded-2xl art-card-glass border-white/20 transition-all cursor-pointer flex items-center justify-between group">
                            <div>
                                <div class="font-display font-bold text-lg text-white">Deep & Smoked // Медитативный</div>
                                <div class="text-xs text-zinc-400 mt-1">Бурбон, древесный дым, тёмные биттеры</div>
                            </div>
                            <div class="icon-badge group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
                            </div>
                        </button>

                        <button onclick="selectCocktailMood('energy')" id="mood-btn-energy" class="w-full text-left p-5 rounded-2xl art-card-glass transition-all cursor-pointer flex items-center justify-between group">
                            <div>
                                <div class="font-display font-bold text-lg text-white">Citrus & Kinetic // Энергичный</div>
                                <div class="text-xs text-zinc-400 mt-1">Джин, юдзу, белый персик, лемонграсс</div>
                            </div>
                            <div class="icon-badge group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                        </button>

                        <button onclick="selectCocktailMood('sparkling')" id="mood-btn-sparkling" class="w-full text-left p-5 rounded-2xl art-card-glass transition-all cursor-pointer flex items-center justify-between group">
                            <div>
                                <div class="font-display font-bold text-lg text-white">Zero Gravity // Легкий & Игристый</div>
                                <div class="text-xs text-zinc-400 mt-1">Текила, жасминовая содовая, спелая маракуйя</div>
                            </div>
                            <div class="icon-badge group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Dynamic Pairing Display Card -->
                <div class="lg:col-span-7 art-card-glass p-8 sm:p-10 space-y-8 border-zinc-700 relative overflow-hidden">
                    <div class="flex justify-between items-start">
                        <span id="pair-tag" class="px-3.5 py-1.5 rounded-full text-xs font-mono bg-zinc-800 text-zinc-200 border border-zinc-700">ИТАЛЬЯНСКАЯ КЛАССИКА</span>
                        <span id="pair-abv" class="text-xs font-mono text-zinc-400">22% ABV // 250 ML</span>
                    </div>

                    <div>
                        <div class="text-xs font-mono text-zinc-500 uppercase tracking-widest">Рекомендуемый Коктейль</div>
                        <h3 id="pair-title" class="font-display text-3xl sm:text-4xl font-bold text-white mt-1">MIDNIGHT ECLIPSE</h3>
                        <p id="pair-desc" class="text-xs text-zinc-400 mt-3 leading-relaxed">Бурбон 8-летней выдержки, выпаренный портвейн, ежевичный биттер, дым дуба.</p>
                    </div>

                    <!-- Sensory Flavor Profile Gauges -->
                    <div class="space-y-3 font-mono text-xs">
                        <div>
                            <div class="flex justify-between text-zinc-400 mb-1"><span>Крепость / Strength</span><span id="gauge-val-1">85%</span></div>
                            <div class="w-full bg-zinc-900 rounded-full h-2 overflow-hidden border border-zinc-800">
                                <div id="gauge-bar-1" class="bg-white h-full transition-all duration-700" style="width: 85%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-zinc-400 mb-1"><span>Сладость / Sweetness</span><span id="gauge-val-2">35%</span></div>
                            <div class="w-full bg-zinc-900 rounded-full h-2 overflow-hidden border border-zinc-800">
                                <div id="gauge-bar-2" class="bg-zinc-400 h-full transition-all duration-700" style="width: 35%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-zinc-400 mb-1"><span>Аромат / Aroma</span><span id="gauge-val-3">95%</span></div>
                            <div class="w-full bg-zinc-900 rounded-full h-2 overflow-hidden border border-zinc-800">
                                <div id="gauge-bar-3" class="bg-white h-full transition-all duration-700" style="width: 95%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Ideal Food Pairing -->
                    <div class="p-4 rounded-2xl bg-zinc-900/80 border border-zinc-800 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="icon-badge">
                                <svg class="w-4 h-4 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-white">Идеальный фуд-пэйринг:</div>
                                <div id="pair-food" class="text-[11px] text-zinc-400">Утиная Грудка Sous-Vide со соусом из вяленой вишни</div>
                            </div>
                        </div>
                        <button onclick="openBookingModal()" class="art-button-primary px-4 py-2 text-[11px] uppercase cursor-pointer">Заказать</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- LIVE EVENTS POSTER & DJ LINEUP SECTION -->
        <section id="events" class="space-y-12 scroll-mt-32">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-mono uppercase tracking-widest text-zinc-500 mb-2">
                        <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span>// LINEUP & PERFORMANCES</span>
                    </div>
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
                            <div class="w-10 h-10 rounded-full bg-zinc-800 border border-zinc-700 flex items-center justify-center font-bold text-xs">
                                <svg class="w-5 h-5 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm12 0c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zM9 10l12-3"/>
                                </svg>
                            </div>
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
                            <div class="w-10 h-10 rounded-full bg-zinc-800 border border-zinc-700 flex items-center justify-center font-bold text-xs">
                                <svg class="w-5 h-5 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </div>
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
                <div class="flex items-center justify-center gap-2 text-xs font-mono uppercase tracking-widest text-zinc-500">
                    <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>// INTERACTIVE BLUEPRINT</span>
                </div>
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
                        <g id="zone-bar-svg" class="table-node" onclick="openBookingWithTable('Главный Бар', 'Стол #1 (4 чел)')">
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

        <!-- RESIDENT CLUB VIP DIGITAL CARD GENERATOR -->
        <section id="vip-pass" class="space-y-12 scroll-mt-32">
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <div class="flex items-center justify-center gap-2 text-xs font-mono uppercase tracking-widest text-zinc-500">
                    <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/>
                    </svg>
                    <span>// ORBITA RESIDENT CLUB</span>
                </div>
                <h2 class="font-display text-4xl sm:text-5xl font-black text-white">Цифровая Карта Резидента</h2>
                <p class="text-zinc-400 text-sm">Сгенерируйте индивидуальную клубную карту с привилегиями и пропуском на закрытые ивенты</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <!-- Generator Controls -->
                <div class="lg:col-span-5 art-card-glass p-8 space-y-6">
                    <div>
                        <label class="block text-xs font-mono text-zinc-400 uppercase mb-2">Имя на карте</label>
                        <input type="text" id="vip-input-name" oninput="updateVIPCard()" value="АЛЕКСАНДР В." class="w-full bg-zinc-900 border border-zinc-800 rounded-2xl px-4 py-3 text-sm text-white focus:outline-none focus:border-zinc-500">
                    </div>

                    <div>
                        <label class="block text-xs font-mono text-zinc-400 uppercase mb-2">Статус Клуба</label>
                        <select id="vip-input-tier" onchange="updateVIPCard()" class="w-full bg-zinc-900 border border-zinc-800 rounded-2xl px-4 py-3 text-sm text-white focus:outline-none focus:border-zinc-500">
                            <option value="ORBITAL RESIDENT">ORBITAL RESIDENT (Cashback 10%)</option>
                            <option value="BLACK MATRIX VIP">BLACK MATRIX VIP (Secret Lounge Access)</option>
                            <option value="FOUNDER MEMBER">FOUNDER MEMBER (Personal Concierge)</option>
                        </select>
                    </div>

                    <div class="pt-4 border-t border-zinc-800 flex items-center justify-between text-xs font-mono text-zinc-400">
                        <span>Цифровой ID: <span id="vip-id-display" class="text-white font-bold">#ORB-9842</span></span>
                        <button onclick="downloadVIPPass()" class="art-button-primary px-4 py-2 uppercase text-[10px] cursor-pointer">Сохранить</button>
                    </div>
                </div>

                <!-- Live Shiny VIP Card Visualizer -->
                <div class="lg:col-span-7 flex justify-center">
                    <div id="vip-card-element" class="vip-card-shiny w-full max-w-md aspect-[1.58/1] rounded-3xl p-8 border border-zinc-700/80 shadow-2xl flex flex-col justify-between text-white transition-transform duration-500 hover:scale-105">
                        <!-- Top Row -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="12" r="9" stroke-dasharray="2 2"/>
                                        <circle cx="12" cy="12" r="4" fill="currentColor"/>
                                    </svg>
                                </div>
                                <span class="font-display font-black text-xl tracking-wider">ОРБИТА</span>
                            </div>
                            <span id="vip-tier-badge" class="px-3 py-1 rounded-full text-[10px] font-mono bg-white/10 border border-white/20 text-zinc-200">ORBITAL RESIDENT</span>
                        </div>

                        <!-- Middle Code & Hologram -->
                        <div class="my-4 flex items-center justify-between">
                            <div>
                                <div class="text-[10px] font-mono text-zinc-400 uppercase">MEMBER NAME</div>
                                <div id="vip-card-name" class="font-display font-extrabold text-2xl tracking-wide uppercase">АЛЕКСАНДР В.</div>
                            </div>
                            <!-- Dynamic Holographic Pass SVG Icon -->
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-400/20 via-emerald-400/20 to-indigo-400/20 border border-white/30 flex items-center justify-center shadow-inner">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Bottom Numbers -->
                        <div class="flex items-end justify-between border-t border-white/10 pt-4 font-mono text-xs text-zinc-400">
                            <div>
                                <span>VALID THRU: </span><span class="text-white font-bold">12/28</span>
                            </div>
                            <span id="vip-card-id" class="text-white tracking-widest font-bold">#ORB-9842-88</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- MAP & LOCATION SECTION (YANDEX MAP EMBEDDED) -->
        <section id="map-section" class="space-y-12 scroll-mt-32">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-mono uppercase tracking-widest text-zinc-500 mb-2">
                        <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        <span>// GEOLOCATION & NAVIGATION</span>
                    </div>
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
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-zinc-800/90 border border-zinc-700/80 flex items-center justify-center text-zinc-300">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                <span>Метро Китай-город</span>
                            </div>
                            <span class="text-zinc-400">7 мин пешком</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-zinc-900/80 border border-zinc-800 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-zinc-800/90 border border-zinc-700/80 flex items-center justify-center text-zinc-300">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                <span>Метро Таганская</span>
                            </div>
                            <span class="text-zinc-400">9 мин пешком</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-zinc-900/80 border border-zinc-800 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-zinc-800/90 border border-zinc-700/80 flex items-center justify-center text-zinc-300">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                </div>
                                <span>Валет-паркинг</span>
                            </div>
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
                <a href="#mixology-navigator" class="hover:text-white">Миксология</a>
                <a href="#events" class="hover:text-white">Афиша</a>
                <a href="#floorplan" class="hover:text-white">Схема</a>
                <a href="#vip-pass" class="hover:text-white">VIP Карта</a>
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

        // Custom Cursor Movement Physics
        const customCursor = document.getElementById('custom-cursor');
        window.addEventListener('mousemove', (e) => {
            if (customCursor) {
                customCursor.style.transform = `translate(${e.clientX}px, ${e.clientY}px) translate(-50%, -50%)`;
            }
        });

        // Cocktail Mood Matrix Selection Data
        const cocktailMoods = {
            deep: {
                title: "MIDNIGHT ECLIPSE",
                tag: "SMOKED BOURBON",
                abv: "22% ABV // 250 ML",
                desc: "Бурбон 8-летней выдержки, выпаренный портвейн, ежевичный биттер, дым дубовой щепы.",
                g1: "85%", g2: "35%", g3: "95%",
                food: "Утиная Грудка Sous-Vide с вишневым соусом"
            },
            energy: {
                title: "ORBITA SIGNAL #1",
                tag: "CITRUS BOTANICAL",
                abv: "14% ABV // 300 ML",
                desc: "Джин на лемонграссе, кордиал из спелого белого персика, юдзу, золотая пищевая пыльца.",
                g1: "45%", g2: "65%", g3: "88%",
                food: "Тартар из Желтопёрого Тунца с нори"
            },
            sparkling: {
                title: "ZERO GRAVITY",
                tag: "TROPICAL ZERO-G",
                abv: "12% ABV // 350 ML",
                desc: "Текила Reposado, кордиал из маракуйи, натуральная содовая из лепестков жасмина.",
                g1: "30%", g2: "80%", g3: "75%",
                food: "Трюфельный Ризотто с грибами"
            }
        };

        function selectCocktailMood(mood) {
            const data = cocktailMoods[mood];
            if (!data) return;

            document.getElementById('pair-title').innerText = data.title;
            document.getElementById('pair-tag').innerText = data.tag;
            document.getElementById('pair-abv').innerText = data.abv;
            document.getElementById('pair-desc').innerText = data.desc;
            document.getElementById('pair-food').innerText = data.food;

            document.getElementById('gauge-val-1').innerText = data.g1;
            document.getElementById('gauge-bar-1').style.width = data.g1;

            document.getElementById('gauge-val-2').innerText = data.g2;
            document.getElementById('gauge-bar-2').style.width = data.g2;

            document.getElementById('gauge-val-3').innerText = data.g3;
            document.getElementById('gauge-bar-3').style.width = data.g3;

            ['deep', 'energy', 'sparkling'].forEach(m => {
                const btn = document.getElementById(`mood-btn-${m}`);
                if (m === mood) {
                    btn.classList.add('border-white/30');
                } else {
                    btn.classList.remove('border-white/30');
                }
            });
        }

        // VIP Pass Card Generator
        function updateVIPCard() {
            const nameInput = document.getElementById('vip-input-name').value || 'АЛЕКСАНДР В.';
            const tierSelect = document.getElementById('vip-input-tier').value;

            document.getElementById('vip-card-name').innerText = nameInput;
            document.getElementById('vip-tier-badge').innerText = tierSelect;
        }

        function downloadVIPPass() {
            alert('Цифровая карта резидента сохранена в ваш Apple / Google Wallet!');
        }

        // Web Audio Synthesizer Atmosphere Toggle
        let audioCtx = null;
        let isAudioPlaying = false;
        let osc1 = null, osc2 = null, gainNode = null;

        function toggleAudioAtmosphere() {
            const bars = document.getElementById('audio-bars');
            const icon = document.getElementById('audio-icon');

            if (!isAudioPlaying) {
                if (!audioCtx) {
                    audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                }

                // Ambient Low Pad Frequencies (Warm Ambient Binaural Synth)
                osc1 = audioCtx.createOscillator();
                osc2 = audioCtx.createOscillator();
                gainNode = audioCtx.createGain();

                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(110, audioCtx.currentTime); // A2

                osc2.type = 'triangle';
                osc2.frequency.setValueAtTime(164.81, audioCtx.currentTime); // E3

                gainNode.gain.setValueAtTime(0.04, audioCtx.currentTime);

                osc1.connect(gainNode);
                osc2.connect(gainNode);
                gainNode.connect(audioCtx.destination);

                osc1.start();
                osc2.start();

                isAudioPlaying = true;
                if (bars) bars.classList.remove('hidden');
                if (icon) icon.classList.add('text-emerald-400');
            } else {
                if (gainNode) gainNode.gain.setTargetAtTime(0, audioCtx.currentTime, 0.1);
                setTimeout(() => {
                    if (osc1) osc1.stop();
                    if (osc2) osc2.stop();
                }, 200);

                isAudioPlaying = false;
                if (bars) bars.classList.add('hidden');
                if (icon) icon.classList.remove('text-emerald-400');
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

        // Global Three.js Lighting Switcher
        let set3DLighting = () => {};

        // THREE.JS 3D KINETIC ORBITAL ASTROLABE CORE STAGE
        window.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('canvas-container');
            if (!container || typeof THREE === 'undefined') return;

            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(50, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.set(0, 0, 18);

            const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            container.appendChild(renderer.domElement);

            // Studio Lighting Setup
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.4);
            scene.add(ambientLight);

            const keyLight = new THREE.DirectionalLight(0xffffff, 2.2);
            keyLight.position.set(12, 18, 15);
            scene.add(keyLight);

            const rimLight = new THREE.DirectionalLight(0xa1a1aa, 1.5);
            rimLight.position.set(-15, -10, -10);
            scene.add(rimLight);

            // Astrolabe Kinetic Group
            const astrolabeGroup = new THREE.Group();

            const chromeMaterial = new THREE.MeshStandardMaterial({
                color: 0xe4e4e7,
                metalness: 0.95,
                roughness: 0.1
            });

            const darkMetalMaterial = new THREE.MeshStandardMaterial({
                color: 0x27272a,
                metalness: 0.8,
                roughness: 0.3
            });

            // Outer Ring 1
            const ring1Geo = new THREE.TorusGeometry(4.5, 0.08, 16, 100);
            const ring1 = new THREE.Mesh(ring1Geo, chromeMaterial);
            astrolabeGroup.add(ring1);

            // Middle Ring 2 (Tilted)
            const ring2Geo = new THREE.TorusGeometry(3.6, 0.1, 16, 100);
            const ring2 = new THREE.Mesh(ring2Geo, darkMetalMaterial);
            ring2.rotation.x = Math.PI / 4;
            astrolabeGroup.add(ring2);

            // Inner Ring 3
            const ring3Geo = new THREE.TorusGeometry(2.8, 0.06, 16, 100);
            const ring3 = new THREE.Mesh(ring3Geo, chromeMaterial);
            ring3.rotation.y = Math.PI / 3;
            astrolabeGroup.add(ring3);

            // Core Refractive Glass Sphere
            const coreGeo = new THREE.IcosahedronGeometry(1.6, 4);
            const coreMaterial = new THREE.MeshPhysicalMaterial({
                color: 0xffffff,
                transmission: 0.92,
                opacity: 1,
                transparent: true,
                roughness: 0.05,
                ior: 1.52,
                reflectivity: 0.9
            });
            const coreMesh = new THREE.Mesh(coreGeo, coreMaterial);
            astrolabeGroup.add(coreMesh);

            // Inner Floating Micro Core
            const innerCoreGeo = new THREE.IcosahedronGeometry(0.7, 2);
            const innerCoreMat = new THREE.MeshStandardMaterial({
                color: 0xffffff,
                metalness: 0.9,
                roughness: 0.1,
                wireframe: true
            });
            const innerCore = new THREE.Mesh(innerCoreGeo, innerCoreMat);
            astrolabeGroup.add(innerCore);

            // Orbiting Satellites (Small spheres on ring paths)
            const satelliteGroup = new THREE.Group();
            for(let i=0; i<5; i++) {
                const satGeo = new THREE.SphereGeometry(0.22, 16, 16);
                const satMesh = new THREE.Mesh(satGeo, chromeMaterial);
                const angle = (i / 5) * Math.PI * 2;
                satMesh.position.set(Math.cos(angle) * 3.6, Math.sin(angle) * 3.6, 0);
                satelliteGroup.add(satMesh);
            }
            satelliteGroup.rotation.x = Math.PI / 4;
            astrolabeGroup.add(satelliteGroup);

            // Position Astrolabe on the right side of hero section
            astrolabeGroup.position.set(3.2, 0.5, 0);
            scene.add(astrolabeGroup);

            // Ambient Accretion Dust Particles
            const particleCount = 600;
            const particleGeo = new THREE.BufferGeometry();
            const positions = new Float32Array(particleCount * 3);
            for(let i=0; i<particleCount*3; i++) {
                positions[i] = (Math.random() - 0.5) * 45;
            }
            particleGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
            const particleMat = new THREE.PointsMaterial({ size: 0.05, color: 0x94a3b8, transparent: true, opacity: 0.45 });
            const particles = new THREE.Points(particleGeo, particleMat);
            scene.add(particles);

            // Dynamic 3D Theme Switcher Functionality
            set3DLighting = function(mode) {
                const btnC = document.getElementById('theme-btn-chrome');
                const btnCy = document.getElementById('theme-btn-cyan');
                const btnP = document.getElementById('theme-btn-purple');

                [btnC, btnCy, btnP].forEach(b => {
                    if (b) b.className = 'px-3 py-1 rounded-full text-xs font-mono bg-zinc-800 text-zinc-400 hover:text-white transition-all cursor-pointer';
                });

                if (mode === 'cyan') {
                    if (btnCy) btnCy.className = 'px-3 py-1 rounded-full text-xs font-mono bg-cyan-400 text-zinc-950 font-bold transition-all cursor-pointer';
                    keyLight.color.setHex(0x22d3ee);
                    rimLight.color.setHex(0x0284c7);
                    particleMat.color.setHex(0x38bdf8);
                } else if (mode === 'purple') {
                    if (btnP) btnP.className = 'px-3 py-1 rounded-full text-xs font-mono bg-indigo-400 text-zinc-950 font-bold transition-all cursor-pointer';
                    keyLight.color.setHex(0xa855f7);
                    rimLight.color.setHex(0x6366f1);
                    particleMat.color.setHex(0xc084fc);
                } else {
                    if (btnC) btnC.className = 'px-3 py-1 rounded-full text-xs font-mono bg-white text-zinc-950 font-bold transition-all cursor-pointer';
                    keyLight.color.setHex(0xffffff);
                    rimLight.color.setHex(0xa1a1aa);
                    particleMat.color.setHex(0x94a3b8);
                }
            };

            // Mouse Physics
            let targetX = 0;
            let targetY = 0;
            window.addEventListener('mousemove', (e) => {
                targetX = (e.clientX / window.innerWidth - 0.5) * 1.8;
                targetY = (e.clientY / window.innerHeight - 0.5) * 1.8;
            });

            // Animation Render Loop
            let clock = new THREE.Clock();
            function animate() {
                requestAnimationFrame(animate);
                const elapsedTime = clock.getElapsedTime();

                // Multi-axis rotation of celestial astrolabe
                ring1.rotation.y = elapsedTime * 0.3;
                ring1.rotation.x = elapsedTime * 0.1;

                ring2.rotation.z = -elapsedTime * 0.4;
                ring2.rotation.y = elapsedTime * 0.2;

                ring3.rotation.x = elapsedTime * 0.5;
                ring3.rotation.z = elapsedTime * 0.3;

                coreMesh.rotation.y = elapsedTime * 0.2;
                innerCore.rotation.y = -elapsedTime * 0.6;
                innerCore.rotation.x = elapsedTime * 0.4;

                satelliteGroup.rotation.z = elapsedTime * 0.5;

                // Subtle floating wave movement
                astrolabeGroup.position.y = 0.5 + Math.sin(elapsedTime * 1.2) * 0.25;

                // Parallax smoothing
                camera.position.x += (targetX - camera.position.x) * 0.05;
                camera.position.y += (-targetY - camera.position.y) * 0.05;

                particles.rotation.y = elapsedTime * 0.015;

                renderer.render(scene, camera);
            }
            animate();

            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            });
        });
    </script>
</body>
</html>
