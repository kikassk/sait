<!DOCTYPE html>
<html lang="ru" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ОРБИТА — Future Cyber Lounge & Cocktail Bar</title>
    <meta name="description" content="Ультрасовременное пространственное заведение с живой 3D-графикой, авторской миксологией и аудиовидео перформансами.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,600;0,700;1,300&display=swap" rel="stylesheet">

    <!-- Three.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    @vite(['resources/css/app.css'])

    <style>
        :root {
            --color-neon-cyan: #06b6d4;
            --color-neon-purple: #a855f7;
            --color-neon-pink: #ec4899;
            --color-cyber-dark: #020205;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--color-cyber-dark);
            color: #f1f5f9;
            overflow-x: hidden;
            cursor: default;
        }

        h1, h2, h3, h4, .font-heading {
            font-family: 'Unbounded', sans-serif;
        }

        /* Custom Cyber Cursor */
        #cyber-cursor {
            pointer-events: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 24px;
            height: 24px;
            border: 2px solid var(--color-neon-cyan);
            border-radius: 50%;
            z-index: 9999;
            transition: transform 0.1s ease-out, border-color 0.2s, background-color 0.2s;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.6);
        }
        #cyber-cursor-dot {
            pointer-events: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 6px;
            height: 6px;
            background: #fff;
            border-radius: 50%;
            z-index: 10000;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 10px #fff;
        }

        /* Background 3D Canvas */
        #canvas-container {
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

        /* Glassmorphism Ultra Styling */
        .glass-card {
            background: rgba(10, 12, 24, 0.55);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.7);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .glass-card:hover {
            border-color: rgba(6, 182, 212, 0.4);
            box-shadow: 0 20px 50px rgba(6, 182, 212, 0.2);
            transform: translateY(-4px);
        }

        .glass-nav {
            background: rgba(2, 2, 5, 0.7);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Neon Glow Utility */
        .glow-cyan { text-shadow: 0 0 25px rgba(6, 182, 212, 0.75); }
        .glow-purple { text-shadow: 0 0 25px rgba(168, 85, 247, 0.75); }
        .glow-pink { text-shadow: 0 0 25px rgba(236, 72, 153, 0.75); }

        .border-glow-cyan:hover {
            box-shadow: 0 0 25px rgba(6, 182, 212, 0.4);
        }

        /* Hologram Grid Accent */
        .holo-grid {
            background-size: 40px 40px;
            background-image:
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #020205;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e1b4b;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a855f7;
        }
    </style>
</head>
<body class="bg-[#020205] text-slate-100 antialiased selection:bg-cyan-500 selection:text-black holo-grid">

    <!-- Custom Cursor Elements -->
    <div id="cyber-cursor"></div>
    <div id="cyber-cursor-dot"></div>

    <!-- 3D WebGL Canvas Background -->
    <div id="canvas-container"></div>

    <div class="content-layer">

        <!-- Navigation Bar -->
        <header class="fixed top-0 left-0 right-0 z-50 glass-nav transition-all duration-300" id="navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <!-- Brand Logo -->
                <a href="#hero" class="flex items-center gap-3.5 group">
                    <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-tr from-cyan-500 via-purple-600 to-pink-500 p-[2px] shadow-lg shadow-cyan-500/20 group-hover:shadow-pink-500/40 transition-all duration-300 group-hover:scale-105">
                        <div class="w-full h-full bg-[#020205] rounded-[14px] flex items-center justify-center relative overflow-hidden">
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-purple-400 font-black text-2xl font-heading">О</span>
                            <div class="absolute inset-0 bg-cyan-400/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                    </div>
                    <div>
                        <span class="text-xl font-black font-heading tracking-widest text-white group-hover:text-cyan-400 transition-colors">
                            ОРБИТА
                        </span>
                        <div class="text-[9px] uppercase tracking-[0.25em] text-cyan-400 font-bold flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-ping"></span>
                            Cyber Lounge Bar
                        </div>
                    </div>
                </a>

                <!-- Nav Links -->
                <nav class="hidden lg:flex items-center gap-8 bg-black/50 border border-white/10 px-8 py-3 rounded-full shadow-2xl backdrop-blur-2xl">
                    <a href="#concept" class="text-xs font-semibold uppercase tracking-wider text-slate-300 hover:text-cyan-400 transition-colors flex items-center gap-1">Концепция</a>
                    <a href="#zones" class="text-xs font-semibold uppercase tracking-wider text-slate-300 hover:text-purple-400 transition-colors">Зоны</a>
                    <a href="#menu" class="text-xs font-semibold uppercase tracking-wider text-slate-300 hover:text-pink-400 transition-colors">Миксология</a>
                    <a href="#events" class="text-xs font-semibold uppercase tracking-wider text-slate-300 hover:text-cyan-400 transition-colors">Афиша</a>
                    <a href="#loyalty" class="text-xs font-semibold uppercase tracking-wider text-slate-300 hover:text-purple-400 transition-colors">Лояльность</a>
                    <a href="#contacts" class="text-xs font-semibold uppercase tracking-wider text-slate-300 hover:text-indigo-400 transition-colors">Контакты</a>
                </nav>

                <!-- Audio Switcher & Booking Action -->
                <div class="flex items-center gap-4">
                    <!-- Audio FX Toggle -->
                    <button id="audio-toggle" onclick="toggleAudioSynth()" class="px-3.5 py-2 rounded-full bg-white/5 border border-white/10 text-[11px] font-bold font-heading text-slate-300 hover:text-cyan-400 hover:border-cyan-500/40 transition-all flex items-center gap-2">
                        <span id="audio-icon">🔇</span>
                        <span id="audio-status" class="hidden sm:inline">SOUND: OFF</span>
                    </button>

                    <button onclick="openBookingModal('Главная сцена')" class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-xs font-bold font-heading rounded-full group bg-gradient-to-r from-cyan-500 via-purple-600 to-pink-500 text-white shadow-xl shadow-cyan-500/20 hover:shadow-cyan-500/50 transition-all duration-300 hover:scale-105">
                        <span class="relative px-6 py-2.5 transition-all ease-in duration-75 bg-[#020205] rounded-full group-hover:bg-opacity-0 uppercase tracking-wider">
                            Забронировать
                        </span>
                    </button>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section id="hero" class="relative min-h-screen flex items-center justify-center pt-28 pb-16 overflow-hidden">
            <div class="max-w-6xl mx-auto px-4 text-center relative z-10">
                <!-- Status Badge -->
                <div class="inline-flex items-center gap-3 px-6 py-2 rounded-full bg-white/5 border border-cyan-500/30 backdrop-blur-2xl mb-8 shadow-2xl">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-cyan-400"></span>
                    </span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-300 to-pink-400 font-heading">
                        УЛЬТРАСОВРЕМЕННЫЙ 3D КИБЕР-ЛАУНЖ
                    </span>
                </div>

                <!-- Main Title -->
                <h1 class="text-4xl sm:text-7xl md:text-8xl lg:text-9xl font-black font-heading tracking-tight text-white mb-8 leading-[0.92]">
                    ПРОСТРАНСТВО <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500 glow-cyan">
                        НЕВЕСОМОСТИ
                    </span>
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-2xl text-slate-300 max-w-3xl mx-auto mb-10 font-light leading-relaxed">
                    Авторская молекулярная миксология, объемный 3D-звук и реактивные голографические инсталляции в самом центре столицы.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-5">
                    <button onclick="openBookingModal('Главная сцена')" class="w-full sm:w-auto px-10 py-4.5 rounded-full bg-gradient-to-r from-cyan-500 via-purple-600 to-pink-500 text-white font-heading text-xs tracking-widest uppercase font-bold shadow-2xl shadow-cyan-500/40 hover:scale-105 hover:shadow-cyan-500/60 transition-all duration-300">
                        Забронировать визит
                    </button>
                    <a href="#menu" class="w-full sm:w-auto px-10 py-4.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 backdrop-blur-2xl text-slate-200 font-heading text-xs tracking-widest uppercase font-bold transition-all duration-300 border-glow-cyan">
                        Карта коктейлей
                    </a>
                </div>

                <!-- Event Live Countdown Badge -->
                <div class="mt-16 glass-card max-w-2xl mx-auto p-6 rounded-3xl border border-purple-500/30 flex flex-col sm:flex-row items-center justify-between gap-4 text-left">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-purple-500/20 border border-purple-500/40 flex items-center justify-center text-2xl animate-pulse">
                            🎧
                        </div>
                        <div>
                            <div class="text-[10px] uppercase font-bold tracking-widest text-purple-400 font-heading">БЛИЖАЙШИЙ DJ-СЕТ</div>
                            <div class="text-sm font-bold text-white font-heading">CYBER SOUNDS: DJ ORBITAL</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 font-heading font-black text-cyan-400 text-xl tracking-wider bg-black/40 px-5 py-2.5 rounded-2xl border border-white/10">
                        <span id="countdown-timer">02д 14ч 38м</span>
                    </div>
                </div>

                <!-- Key Metrics Grid -->
                <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-5 max-w-4xl mx-auto">
                    <div class="glass-card p-6 rounded-3xl text-center">
                        <div class="text-3xl sm:text-4xl font-black font-heading text-cyan-400 mb-1">4</div>
                        <div class="text-[11px] uppercase font-bold text-slate-400 tracking-wider">Атмосферных Зоны</div>
                    </div>
                    <div class="glass-card p-6 rounded-3xl text-center">
                        <div class="text-3xl sm:text-4xl font-black font-heading text-purple-400 mb-1">25+</div>
                        <div class="text-[11px] uppercase font-bold text-slate-400 tracking-wider">Авторских Напитков</div>
                    </div>
                    <div class="glass-card p-6 rounded-3xl text-center">
                        <div class="text-3xl sm:text-4xl font-black font-heading text-pink-400 mb-1">WebGL</div>
                        <div class="text-[11px] uppercase font-bold text-slate-400 tracking-wider">Interactive 3D Engine</div>
                    </div>
                    <div class="glass-card p-6 rounded-3xl text-center">
                        <div class="text-3xl sm:text-4xl font-black font-heading text-indigo-400 mb-1">4.9 ★</div>
                        <div class="text-[11px] uppercase font-bold text-slate-400 tracking-wider">Отзывы Гостей</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Concept & Interactive 3D Model Viewport -->
        <section id="concept" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-6">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 text-xs uppercase tracking-widest font-bold mb-6">
                            ФИЛОСОФИЯ «ОРБИТЫ»
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-black font-heading text-white mb-6 leading-tight">
                            СИМБИОЗ ТЕХНОЛОГИЙ И <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-500">ГАСТРОНОМИИ</span>
                        </h2>
                        <p class="text-slate-300 text-base sm:text-lg mb-6 leading-relaxed font-light">
                            «Орбита» — это больше чем бар. Это интерактивный артефакт будущего, где вкус коктейлей синхронизируется с динамической световой и звуковой волной.
                        </p>
                        <p class="text-slate-400 text-sm mb-8 leading-relaxed">
                            Каждый коктейль подается с использованием элементов сухой заморозки, пищевых неоновых фракций и натуральных аромаэссенций.
                        </p>

                        <div class="grid grid-cols-2 gap-6 border-t border-white/10 pt-8">
                            <div class="glass-card p-5 rounded-2xl">
                                <div class="text-cyan-400 font-heading font-bold text-base mb-1">Spatial Audio</div>
                                <div class="text-xs text-slate-400">Звуковые сферы над каждым столом</div>
                            </div>
                            <div class="glass-card p-5 rounded-2xl">
                                <div class="text-pink-400 font-heading font-bold text-base mb-1">Cyber-Visual Art</div>
                                <div class="text-xs text-slate-400">3D проекции и реакции на звук</div>
                            </div>
                        </div>
                    </div>

                    <!-- Interactive 3D Viewer Card -->
                    <div class="lg:col-span-6">
                        <div class="glass-card rounded-3xl p-8 relative overflow-hidden border border-cyan-500/30">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-cyan-400 animate-ping"></span>
                                    <span class="text-xs font-heading font-bold uppercase tracking-wider text-cyan-300">3D АРТЕФАКТ ОРБИТЫ</span>
                                </div>
                                <span class="text-[10px] text-slate-400 uppercase tracking-widest">Интерактивный Viewport</span>
                            </div>

                            <div class="aspect-square sm:aspect-video rounded-2xl relative bg-black/80 border border-white/10 overflow-hidden flex items-center justify-center">
                                <div id="card-3d-viewport" class="w-full h-full cursor-grab"></div>
                                <div class="absolute bottom-4 left-4 right-4 bg-black/70 backdrop-blur-md px-4 py-2.5 rounded-xl text-[11px] text-slate-300 flex justify-between items-center border border-white/10 pointer-events-none">
                                    <span class="flex items-center gap-2">
                                        <span class="text-cyan-400">🖱️</span> Вращайте 3D-модель
                                    </span>
                                    <span class="text-purple-400 font-bold font-heading">ORBITAL CORE v2</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Lounge Zones Section -->
        <section id="zones" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-purple-500/10 border border-purple-500/30 text-purple-400 text-xs uppercase tracking-widest font-bold mb-4">
                        ПРОСТРАНСТВА
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black font-heading text-white">ЗОНЫ И ЛОКАЦИИ</h2>
                    <p class="text-slate-400 text-sm mt-4">Каждая зона запрограммирована под свое уникальное световое и акустическое сопровождение</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($zones as $zone)
                        <div class="glass-card rounded-3xl p-7 flex flex-col justify-between hover:border-cyan-500/50 group">
                            <div>
                                <div class="flex justify-between items-center mb-6">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-cyan-500/30 to-purple-600/30 border border-cyan-500/40 flex items-center justify-center text-cyan-300 font-bold font-heading text-lg group-hover:scale-110 transition-transform">
                                        0{{ $loop->iteration }}
                                    </div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-white/5 border border-white/10 text-slate-300">
                                        {{ $zone['badge'] ?? 'Zone' }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold font-heading text-white mb-3 group-hover:text-cyan-400 transition-colors">{{ $zone['name'] }}</h3>
                                <p class="text-slate-400 text-xs leading-relaxed mb-6">{{ $zone['description'] }}</p>
                            </div>
                            <div>
                                <div class="flex items-center justify-between text-xs text-slate-300 pt-4 border-t border-white/10 mb-6">
                                    <span>Вместимость:</span>
                                    <span class="font-bold text-cyan-400 font-heading">{{ $zone['capacity'] }}</span>
                                </div>
                                <button onclick="openBookingModal('{{ $zone['name'] }}')" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-purple-600 to-cyan-500 hover:from-purple-500 hover:to-cyan-400 text-white font-heading text-xs font-bold uppercase tracking-wider shadow-lg transition-all duration-300">
                                    Забронировать
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Menu & Mixology Section with Interactive Filter -->
        <section id="menu" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-pink-500/10 border border-pink-500/30 text-pink-400 text-xs uppercase tracking-widest font-bold mb-4">
                        ГАСТРОНОМИЯ & МИКСОЛОГИЯ
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black font-heading text-white">АВТОРСКОЕ МЕНЮ</h2>
                </div>

                <!-- Category Switch Tabs -->
                <div class="flex justify-center mb-12">
                    <div class="inline-flex p-1.5 rounded-full bg-black/70 border border-white/10 backdrop-blur-2xl">
                        <button id="tab-bar" onclick="switchMenu('bar')" class="px-8 py-3.5 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 bg-gradient-to-r from-cyan-500 via-purple-600 to-pink-500 text-white shadow-xl">
                            Коктейльная карта
                        </button>
                        <button id="tab-kitchen" onclick="switchMenu('kitchen')" class="px-8 py-3.5 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 text-slate-400 hover:text-white">
                            Кухня & Гастрономия
                        </button>
                    </div>
                </div>

                <!-- Cocktail Menu Grid -->
                <div id="menu-bar" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($menu['bar'] as $item)
                        <div class="glass-card p-6 rounded-3xl hover:border-cyan-500/60 transition-all flex justify-between items-start group">
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <h4 class="font-heading font-bold text-white text-base group-hover:text-cyan-400 transition-colors">{{ $item['name'] }}</h4>
                                </div>
                                <p class="text-slate-400 text-xs mb-4 font-light leading-relaxed">{{ $item['desc'] }}</p>
                                <span class="text-[10px] uppercase font-bold tracking-wider px-3 py-1 rounded-full bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">
                                    {{ $item['tag'] }}
                                </span>
                            </div>
                            <div class="text-xl font-black font-heading text-cyan-400 whitespace-nowrap ml-4 bg-white/5 px-4 py-2 rounded-2xl border border-white/10">
                                {{ $item['price'] }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Kitchen Menu Grid -->
                <div id="menu-kitchen" class="grid grid-cols-1 md:grid-cols-2 gap-6 hidden">
                    @foreach($menu['kitchen'] as $item)
                        <div class="glass-card p-6 rounded-3xl hover:border-purple-500/60 transition-all flex justify-between items-start group">
                            <div>
                                <h4 class="font-heading font-bold text-white text-base mb-2 group-hover:text-purple-400 transition-colors">{{ $item['name'] }}</h4>
                                <p class="text-slate-400 text-xs mb-4 font-light leading-relaxed">{{ $item['desc'] }}</p>
                                <span class="text-[10px] uppercase font-bold tracking-wider px-3 py-1 rounded-full bg-purple-500/20 text-purple-300 border border-purple-500/30">
                                    {{ $item['tag'] }}
                                </span>
                            </div>
                            <div class="text-xl font-black font-heading text-purple-400 whitespace-nowrap ml-4 bg-white/5 px-4 py-2 rounded-2xl border border-white/10">
                                {{ $item['price'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Events & Lineup Section -->
        <section id="events" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-purple-500/10 border border-purple-500/30 text-purple-400 text-xs uppercase tracking-widest font-bold mb-4">
                        СОБЫТИЯ
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black font-heading text-white">АФИША & ЛАЙН-АП</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($events as $event)
                        <div class="glass-card rounded-3xl p-7 flex flex-col justify-between hover:border-pink-500/50 transition-all duration-300 group">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xs font-bold font-heading text-pink-400 bg-pink-500/10 px-3 py-1 rounded-full border border-pink-500/20">{{ $event['date'] }}</span>
                                    <span class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-white/5 border border-white/10 text-slate-300">
                                        {{ $event['category'] }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold font-heading text-white mb-2 group-hover:text-pink-400 transition-colors">{{ $event['title'] }}</h3>
                                <p class="text-slate-400 text-xs mb-6 leading-relaxed font-light">{{ $event['description'] }}</p>
                            </div>
                            <div class="pt-4 border-t border-white/10 flex items-center justify-between">
                                <span class="text-xs font-semibold text-slate-400">Хедлайнер: {{ $event['tag'] }}</span>
                                <button onclick="openBookingModal('Событие: {{ $event['title'] }}')" class="text-xs font-heading font-bold text-cyan-400 hover:text-cyan-300 uppercase tracking-wider flex items-center gap-1">
                                    Билет &rarr;
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Loyalty Calculator Section -->
        <section id="loyalty" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="glass-card rounded-3xl border border-purple-500/30 p-8 sm:p-14 relative overflow-hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        <div class="lg:col-span-6">
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-purple-500/20 text-purple-300 text-xs uppercase tracking-widest font-bold mb-6">
                                ПРОГРАММА ЛОЯЛЬНОСТИ
                            </div>
                            <h2 class="text-3xl sm:text-5xl font-black font-heading text-white mb-6">«ОРБИТАЛЬНОСТЬ»</h2>
                            <p class="text-slate-300 text-base mb-8 leading-relaxed font-light">
                                Каждое посещение повышает ваш персональный орбитальный коэффициент. Получайте бесплатные коктейли, приоритетную бронь и приглашения на закрытые ивенты.
                            </p>

                            <!-- Loyalty Interactive Calculator Slider -->
                            <div class="bg-black/60 border border-white/10 rounded-2xl p-6 backdrop-blur-xl">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-bold text-slate-300 uppercase tracking-wider font-heading">Расчет кэшбэка в месяц</span>
                                    <span id="calc-budget-text" class="text-cyan-400 font-black font-heading text-lg">30 000 ₽</span>
                                </div>
                                <input type="range" id="loyalty-slider" min="5000" max="100000" step="5000" value="30000" oninput="updateLoyaltyCalc(this.value)" class="w-full accent-cyan-400 h-2 bg-slate-800 rounded-lg cursor-pointer my-4">

                                <div class="grid grid-cols-2 gap-4 border-t border-white/10 pt-4">
                                    <div>
                                        <div class="text-[10px] text-slate-400 uppercase font-bold">Ваш Статус:</div>
                                        <div id="calc-status" class="text-purple-400 font-heading font-bold text-base">Орбита</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] text-slate-400 uppercase font-bold">Кэшбэк на счет:</div>
                                        <div id="calc-cashback" class="text-cyan-400 font-heading font-bold text-base">3 000 ₽ / мес</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Loyalty Cards Tiers -->
                        <div class="lg:col-span-6 grid grid-cols-1 gap-4">
                            @foreach($loyaltyTiers as $tier)
                                <div class="glass-card p-6 rounded-2xl border border-white/10 flex items-center justify-between hover:border-cyan-500/40 transition-all">
                                    <div>
                                        <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider mb-1">Уровень {{ $loop->iteration }}</div>
                                        <h4 class="font-heading font-bold text-lg text-white mb-1">{{ $tier['tier'] }}</h4>
                                        <div class="text-xs text-slate-300">{{ $tier['perk'] }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-black font-heading text-cyan-400">{{ $tier['cashback'] }}</div>
                                        <div class="text-[10px] text-slate-400 uppercase">{{ $tier['condition'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Location & Contact -->
        <section id="contacts" class="py-28 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/30 text-indigo-400 text-xs uppercase tracking-widest font-bold mb-6">
                            ЛОКАЦИЯ
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-black font-heading text-white mb-8">ЖДЕМ ВАС НА ОРБИТЕ</h2>

                        <div class="space-y-6 text-slate-300">
                            <div class="flex items-start gap-5 glass-card p-5 rounded-2xl">
                                <div class="w-12 h-12 rounded-2xl bg-purple-500/20 border border-purple-500/30 flex items-center justify-center text-purple-400 font-bold text-xl">📍</div>
                                <div>
                                    <div class="text-xs text-slate-400 uppercase font-bold tracking-wider">Адрес</div>
                                    <div class="font-semibold text-white text-base">г. Москва, ул. Космонавтов, д. 12</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-5 glass-card p-5 rounded-2xl">
                                <div class="w-12 h-12 rounded-2xl bg-cyan-500/20 border border-cyan-500/30 flex items-center justify-center text-cyan-400 font-bold text-xl">⏰</div>
                                <div>
                                    <div class="text-xs text-slate-400 uppercase font-bold tracking-wider">Режим работы</div>
                                    <div class="font-semibold text-white text-base">Пн - Чт: 18:00 - 02:00 | Пт - Сб: 18:00 - 06:00</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-5 glass-card p-5 rounded-2xl">
                                <div class="w-12 h-12 rounded-2xl bg-pink-500/20 border border-pink-500/30 flex items-center justify-center text-pink-400 font-bold text-xl">📞</div>
                                <div>
                                    <div class="text-xs text-slate-400 uppercase font-bold tracking-wider">Телефон для брони</div>
                                    <div class="font-semibold text-white text-base">+7 (495) 888-00-11</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map Container -->
                    <div class="rounded-3xl overflow-hidden border border-white/10 h-80 sm:h-auto min-h-[360px] relative bg-slate-900 shadow-2xl">
                        <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A021b36585141b7ddae441b897e9ed2ddf3e0c03490919df434ec9c1a0be5f606&amp;source=constructor" width="100%" height="100%" frameborder="0" class="w-full h-full opacity-80 hover:opacity-100 transition-opacity"></iframe>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-white/10 py-12 relative bg-black/40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="text-slate-400 text-xs font-light">
                    © 2026 ОРБИТА CYBER LOUNGE. Все права защищены.
                </div>
                <div class="flex items-center gap-6 text-slate-400 text-xs font-semibold">
                    <a href="#" class="hover:text-cyan-400 transition-colors">Telegram</a>
                    <a href="#" class="hover:text-purple-400 transition-colors">VKontakte</a>
                    <a href="#" class="hover:text-pink-400 transition-colors">Instagram</a>
                </div>
            </div>
        </footer>

    </div>

    <!-- Booking Modal -->
    <div id="booking-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-2xl hidden opacity-0 transition-all duration-300">
        <div class="bg-[#0b0c16] border border-cyan-500/40 rounded-3xl p-6 sm:p-10 max-w-lg w-full relative shadow-2xl">
            <button onclick="closeBookingModal()" class="absolute top-6 right-6 text-slate-400 hover:text-white font-bold text-2xl">&times;</button>
            <h3 class="font-heading font-bold text-2xl text-white mb-2">БРОНИРОВАНИЕ СТОЛА</h3>
            <p id="modal-subtitle" class="text-xs text-slate-400 mb-6">Выберите параметры вашего посещения</p>

            <form id="booking-form" onsubmit="submitBooking(event)" class="space-y-4">
                <input type="hidden" id="booking-zone" name="zone" value="Главная сцена">

                <div>
                    <label class="block text-xs uppercase font-bold text-slate-400 mb-1">Ваше имя</label>
                    <input type="text" name="name" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3.5 text-white text-sm focus:outline-none focus:border-cyan-400 transition-colors" placeholder="Александр">
                </div>

                <div>
                    <label class="block text-xs uppercase font-bold text-slate-400 mb-1">Телефон</label>
                    <input type="tel" name="phone" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3.5 text-white text-sm focus:outline-none focus:border-cyan-400 transition-colors" placeholder="+7 (999) 000-00-00">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs uppercase font-bold text-slate-400 mb-1">Дата</label>
                        <input type="date" name="date" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3.5 text-white text-sm focus:outline-none focus:border-cyan-400 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs uppercase font-bold text-slate-400 mb-1">Время</label>
                        <input type="time" name="time" required class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3.5 text-white text-sm focus:outline-none focus:border-cyan-400 transition-colors">
                    </div>
                </div>

                <div>
                    <label class="block text-xs uppercase font-bold text-slate-400 mb-1">Количество гостей</label>
                    <select name="guests" class="w-full bg-white/5 border border-white/10 rounded-2xl px-4 py-3.5 text-white text-sm focus:outline-none focus:border-cyan-400 transition-colors">
                        <option value="1" class="bg-slate-900">1 человек</option>
                        <option value="2" selected class="bg-slate-900">2 человека</option>
                        <option value="4" class="bg-slate-900">4 человека</option>
                        <option value="6" class="bg-slate-900">6+ человек</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-4 mt-2 rounded-2xl bg-gradient-to-r from-cyan-500 via-purple-600 to-pink-500 text-white font-heading font-bold text-xs uppercase tracking-widest shadow-xl hover:scale-[1.02] transition-transform">
                    Подтвердить бронирование
                </button>
            </form>

            <div id="booking-success" class="hidden text-center py-8">
                <div class="w-16 h-16 bg-cyan-500/20 text-cyan-400 rounded-full flex items-center justify-center mx-auto mb-4 font-bold text-2xl">✓</div>
                <h4 class="font-heading font-bold text-xl text-white mb-2">БРОНЬ ПОДТВЕРЖДЕНА!</h4>
                <p class="text-slate-300 text-xs">Мы свяжемся с вами в течение 10 минут для подтверждения деталей.</p>
            </div>
        </div>
    </div>

    <!-- Scripts section for Custom Cursor, Web Audio, Three.js 3D Background & Viewport -->
    <script>
        // --- 1. CUSTOM CYBER CURSOR SCRIPT ---
        const cursor = document.getElementById('cyber-cursor');
        const cursorDot = document.getElementById('cyber-cursor-dot');

        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
            cursorDot.style.left = e.clientX + 'px';
            cursorDot.style.top = e.clientY + 'px';
        });

        document.querySelectorAll('a, button, input, select').forEach(elem => {
            elem.addEventListener('mouseenter', () => {
                cursor.style.transform = 'translate(-50%, -50%) scale(1.8)';
                cursor.style.borderColor = '#ec4899';
                cursor.style.backgroundColor = 'rgba(236, 72, 153, 0.1)';
            });
            elem.addEventListener('mouseleave', () => {
                cursor.style.transform = 'translate(-50%, -50%) scale(1)';
                cursor.style.borderColor = '#06b6d4';
                cursor.style.backgroundColor = 'transparent';
            });
        });


        // --- 2. WEB AUDIO AMBIENT SYNTH & SOUND FX ---
        let audioCtx = null;
        let ambientOsc = null;
        let isAudioOn = false;

        function toggleAudioSynth() {
            if (!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }

            if (!isAudioOn) {
                // Play ambient drone
                ambientOsc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                ambientOsc.type = 'sine';
                ambientOsc.frequency.setValueAtTime(110, audioCtx.currentTime); // Low A note
                gain.gain.setValueAtTime(0.04, audioCtx.currentTime);
                ambientOsc.connect(gain);
                gain.connect(audioCtx.destination);
                ambientOsc.start();

                isAudioOn = true;
                document.getElementById('audio-icon').innerText = '🔊';
                document.getElementById('audio-status').innerText = 'SOUND: ON';
            } else {
                if (ambientOsc) ambientOsc.stop();
                isAudioOn = false;
                document.getElementById('audio-icon').innerText = '🔇';
                document.getElementById('audio-status').innerText = 'SOUND: OFF';
            }
        }


        // --- 3. FULLSCREEN THREE.JS 3D BACKGROUND ---
        const container = document.getElementById('canvas-container');
        const scene = new THREE.Scene();
        scene.fog = new THREE.FogExp2(0x020205, 0.015);

        const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.z = 30;

        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        container.appendChild(renderer.domElement);

        // Lighting
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.7);
        scene.add(ambientLight);

        const cyanLight = new THREE.PointLight(0x06b6d4, 5, 70);
        cyanLight.position.set(25, 20, 20);
        scene.add(cyanLight);

        const purpleLight = new THREE.PointLight(0xa855f7, 5, 70);
        purpleLight.position.set(-25, -20, 20);
        scene.add(purpleLight);

        const pinkLight = new THREE.PointLight(0xec4899, 4, 60);
        pinkLight.position.set(0, 15, -15);
        scene.add(pinkLight);

        // 3D Orbital Mesh Group
        const orbitGroup = new THREE.Group();
        scene.add(orbitGroup);

        // Central Multi-Layer Torus Knot Core
        const knotGeo = new THREE.TorusKnotGeometry(6.5, 1.4, 128, 32);
        const knotMat = new THREE.MeshStandardMaterial({
            color: 0x06b6d4,
            metalness: 0.9,
            roughness: 0.1,
            flatShading: false
        });
        const knotWireMat = new THREE.MeshBasicMaterial({
            color: 0xec4899,
            wireframe: true,
            transparent: true,
            opacity: 0.4
        });

        const torusKnot = new THREE.Mesh(knotGeo, knotMat);
        const torusKnotWire = new THREE.Mesh(knotGeo, knotWireMat);
        torusKnot.add(torusKnotWire);
        orbitGroup.add(torusKnot);

        // Orbital Concentric Glow Rings
        const ringGeo1 = new THREE.TorusGeometry(15, 0.2, 16, 120);
        const ringMat1 = new THREE.MeshStandardMaterial({ color: 0x06b6d4, metalness: 0.95, roughness: 0.05 });
        const ring1 = new THREE.Mesh(ringGeo1, ringMat1);
        ring1.rotation.x = Math.PI / 3;
        orbitGroup.add(ring1);

        const ringGeo2 = new THREE.TorusGeometry(19, 0.15, 16, 120);
        const ringMat2 = new THREE.MeshStandardMaterial({ color: 0xa855f7, metalness: 0.95, roughness: 0.05 });
        const ring2 = new THREE.Mesh(ringGeo2, ringMat2);
        ring2.rotation.y = Math.PI / 4;
        orbitGroup.add(ring2);

        // Floating Kinetic Polyhedron Crystals
        const floatingObjects = [];
        const geoms = [
            new THREE.DodecahedronGeometry(1.6, 0),
            new THREE.OctahedronGeometry(1.5, 0),
            new THREE.IcosahedronGeometry(1.7, 0)
        ];
        const colors = [0x06b6d4, 0xa855f7, 0xec4899, 0x6366f1];

        for (let i = 0; i < 20; i++) {
            const g = geoms[i % geoms.length];
            const m = new THREE.MeshStandardMaterial({
                color: colors[i % colors.length],
                metalness: 0.85,
                roughness: 0.15,
                flatShading: true
            });
            const mesh = new THREE.Mesh(g, m);

            const radius = 13 + Math.random() * 18;
            const angle = (i / 20) * Math.PI * 2;
            mesh.position.x = Math.cos(angle) * radius;
            mesh.position.y = (Math.random() - 0.5) * 16;
            mesh.position.z = Math.sin(angle) * radius;

            mesh.userData = {
                angle: angle,
                radius: radius,
                speed: 0.002 + Math.random() * 0.003,
                rotX: (Math.random() - 0.5) * 0.02,
                rotY: (Math.random() - 0.5) * 0.02
            };

            floatingObjects.push(mesh);
            orbitGroup.add(mesh);
        }

        // Starfield Particles
        const particleCount = 1500;
        const particleGeo = new THREE.BufferGeometry();
        const positions = new Float32Array(particleCount * 3);

        for (let i = 0; i < particleCount * 3; i += 3) {
            positions[i] = (Math.random() - 0.5) * 140;
            positions[i + 1] = (Math.random() - 0.5) * 140;
            positions[i + 2] = (Math.random() - 0.5) * 140;
        }

        particleGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        const particleMat = new THREE.PointsMaterial({
            size: 0.2,
            color: 0xffffff,
            transparent: true,
            opacity: 0.8
        });
        const starfield = new THREE.Points(particleGeo, particleMat);
        scene.add(starfield);

        // Smooth Mouse Parallax
        let mouseX = 0, mouseY = 0;
        let targetX = 0, targetY = 0;

        window.addEventListener('mousemove', (e) => {
            mouseX = (e.clientX - window.innerWidth / 2) * 0.001;
            mouseY = (e.clientY - window.innerHeight / 2) * 0.001;
        });

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        const clock = new THREE.Clock();

        function animate() {
            requestAnimationFrame(animate);

            const elapsedTime = clock.getElapsedTime();

            targetX += (mouseX - targetX) * 0.05;
            targetY += (mouseY - targetY) * 0.05;

            orbitGroup.rotation.y = elapsedTime * 0.22 + targetX * 2.5;
            orbitGroup.rotation.x = Math.sin(elapsedTime * 0.2) * 0.25 + targetY * 2.5;

            torusKnot.rotation.x = elapsedTime * 0.35;
            torusKnot.rotation.y = elapsedTime * 0.45;

            floatingObjects.forEach((obj) => {
                obj.userData.angle += obj.userData.speed;
                obj.position.x = Math.cos(obj.userData.angle) * obj.userData.radius;
                obj.position.z = Math.sin(obj.userData.angle) * obj.userData.radius;
                obj.rotation.x += obj.userData.rotX;
                obj.rotation.y += obj.userData.rotY;
            });

            starfield.rotation.y = elapsedTime * 0.012;

            renderer.render(scene, camera);
        }

        animate();


        // --- 4. CONCEPT 3D MODEL VIEWPORT ---
        const cardViewport = document.getElementById('card-3d-viewport');
        if (cardViewport) {
            const cardScene = new THREE.Scene();
            const cardCamera = new THREE.PerspectiveCamera(50, cardViewport.clientWidth / cardViewport.clientHeight, 0.1, 100);
            cardCamera.position.z = 7;

            const cardRenderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
            cardRenderer.setSize(cardViewport.clientWidth, cardViewport.clientHeight);
            cardRenderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            cardViewport.appendChild(cardRenderer.domElement);

            const cardLight1 = new THREE.PointLight(0x06b6d4, 4, 30);
            cardLight1.position.set(5, 5, 5);
            cardScene.add(cardLight1);

            const cardLight2 = new THREE.PointLight(0xec4899, 4, 30);
            cardLight2.position.set(-5, -5, 5);
            cardScene.add(cardLight2);

            const cardGeo = new THREE.IcosahedronGeometry(2.2, 1);
            const cardMat = new THREE.MeshStandardMaterial({
                color: 0x06b6d4,
                metalness: 0.95,
                roughness: 0.05
            });
            const cardWireMat = new THREE.MeshBasicMaterial({ color: 0xec4899, wireframe: true });

            const cardMesh = new THREE.Mesh(cardGeo, cardMat);
            const cardWire = new THREE.Mesh(cardGeo, cardWireMat);
            cardMesh.add(cardWire);
            cardScene.add(cardMesh);

            let isDragging = false;
            let previousMousePosition = { x: 0, y: 0 };

            cardViewport.addEventListener('mousedown', (e) => {
                isDragging = true;
                previousMousePosition = { x: e.clientX, y: e.clientY };
            });

            window.addEventListener('mouseup', () => isDragging = false);

            cardViewport.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                const deltaX = e.clientX - previousMousePosition.x;
                const deltaY = e.clientY - previousMousePosition.y;

                cardMesh.rotation.y += deltaX * 0.01;
                cardMesh.rotation.x += deltaY * 0.01;

                previousMousePosition = { x: e.clientX, y: e.clientY };
            });

            function animateCard() {
                requestAnimationFrame(animateCard);
                if (!isDragging) {
                    cardMesh.rotation.y += 0.01;
                    cardMesh.rotation.x += 0.005;
                }
                cardRenderer.render(cardScene, cardCamera);
            }
            animateCard();
        }


        // --- 5. INTERACTIVE LOYALTY CALCULATOR ---
        function updateLoyaltyCalc(val) {
            const budgetText = document.getElementById('calc-budget-text');
            const statusText = document.getElementById('calc-status');
            const cashbackText = document.getElementById('calc-cashback');

            const formatted = new Intl.NumberFormat('ru-RU').format(val) + ' ₽';
            budgetText.innerText = formatted;

            let status = 'Спутник (5%)';
            let percent = 0.05;

            if (val >= 50000) {
                status = 'Невесомость (15%)';
                percent = 0.15;
            } else if (val >= 20000) {
                status = 'Орбита (10%)';
                percent = 0.10;
            }

            const cashbackAmount = Math.round(val * percent);
            statusText.innerText = status;
            cashbackText.innerText = new Intl.NumberFormat('ru-RU').format(cashbackAmount) + ' ₽ / мес';
        }


        // --- 6. TABS & MODAL LOGIC ---
        function switchMenu(type) {
            const barMenu = document.getElementById('menu-bar');
            const kitchenMenu = document.getElementById('menu-kitchen');
            const tabBar = document.getElementById('tab-bar');
            const tabKitchen = document.getElementById('tab-kitchen');

            if (type === 'bar') {
                barMenu.classList.remove('hidden');
                kitchenMenu.classList.add('hidden');
                tabBar.className = "px-8 py-3.5 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 bg-gradient-to-r from-cyan-500 via-purple-600 to-pink-500 text-white shadow-xl";
                tabKitchen.className = "px-8 py-3.5 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 text-slate-400 hover:text-white";
            } else {
                kitchenMenu.classList.remove('hidden');
                barMenu.classList.add('hidden');
                tabKitchen.className = "px-8 py-3.5 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 bg-gradient-to-r from-cyan-500 via-purple-600 to-pink-500 text-white shadow-xl";
                tabBar.className = "px-8 py-3.5 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 text-slate-400 hover:text-white";
            }
        }

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
                    alert('Ошибка при бронировании.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Произошла ошибка отправки.');
            });
        }
    </script>
</body>
</html>
