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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Three.js for 3D Studio Stage -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #09090b;
            color: #f4f4f5;
            overflow-x: hidden;
        }

        .font-display {
            font-family: 'Syne', sans-serif;
        }

        /* Glassmorphism custom classes */
        .glass-card {
            background: rgba(24, 24, 27, 0.6);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 2rem;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .glass-card:hover {
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
        }

        .glass-pill {
            background: rgba(39, 39, 42, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 9999px;
        }

        .glass-button {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.03) 100%);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 9999px;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .glass-button:hover {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.22) 0%, rgba(255, 255, 255, 0.08) 100%);
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px -5px rgba(255, 255, 255, 0.15);
        }

        .gradient-text {
            background: linear-gradient(135deg, #ffffff 0%, #a1a1aa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .accent-gradient-text {
            background: linear-gradient(135deg, #f4f4f5 0%, #71717a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Ambient Glow Backgrounds */
        .ambient-glow-1 {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(161, 161, 170, 0.08) 0%, rgba(0, 0, 0, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        .ambient-glow-2 {
            position: absolute;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(63, 63, 70, 0.12) 0%, rgba(0, 0, 0, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        /* Custom Smooth Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #09090b;
        }
        ::-webkit-scrollbar-thumb {
            background: #27272a;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #3f3f46;
        }

        /* Floating keyframe */
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(1deg); }
        }
        .animate-float {
            animation: floatSlow 8s ease-in-out infinite;
        }
    </style>
</head>
<body class="relative bg-zinc-950 text-zinc-100 antialiased selection:bg-zinc-700 selection:text-white">

    <!-- Ambient Glow effects -->
    <div class="ambient-glow-1 top-0 left-1/4 -translate-x-1/2"></div>
    <div class="ambient-glow-2 top-[30vh] right-0"></div>

    <!-- 3D WebGL Canvas Stage -->
    <div id="canvas-container" class="fixed inset-0 z-0 pointer-events-none opacity-85"></div>

    <!-- Floating Navigation Bar -->
    <header class="fixed top-6 inset-x-0 z-50 flex justify-center px-4">
        <nav class="glass-pill px-6 py-3.5 flex items-center justify-between gap-8 max-w-5xl w-full shadow-2xl">
            <!-- Brand Logo -->
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-2xl bg-zinc-800 border border-zinc-700 flex items-center justify-center transition-transform group-hover:scale-105 duration-300">
                    <svg class="w-5 h-5 text-zinc-100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9" stroke-dasharray="2 2" />
                        <circle cx="12" cy="12" r="4" fill="currentColor" />
                    </svg>
                </div>
                <div>
                    <span class="font-display font-bold text-lg tracking-wider text-white block leading-none">ОРБИТА</span>
                    <span class="text-[10px] text-zinc-400 tracking-widest uppercase mt-0.5 block">Фэнси-бар</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-zinc-300">
                <a href="#concept" class="hover:text-white transition-colors">Концепт</a>
                <a href="#zones" class="hover:text-white transition-colors">Зоны и Атмосфера</a>
                <a href="#menu" class="hover:text-white transition-colors">Меню & Бар</a>
                <a href="#location" class="hover:text-white transition-colors">Локация</a>
            </div>

            <!-- Booking Action -->
            <div class="flex items-center gap-3">
                <button onclick="openBookingModal()" class="glass-button px-6 py-2.5 text-sm font-semibold text-white flex items-center gap-2 group cursor-pointer">
                    <span>Забронировать</span>
                    <svg class="w-4 h-4 text-zinc-300 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <!-- Main Content Container -->
    <main class="relative z-10 pt-32 pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-32">

        <!-- HERO SECTION -->
        <section class="min-h-[82vh] flex flex-col justify-center items-center text-center relative py-12">

            <!-- Floating Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-zinc-900/80 border border-zinc-800 backdrop-blur-xl mb-8 animate-float">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-medium text-zinc-300 tracking-wide uppercase">Исторический особняк XVIII века // Проект Вани Дмитриенко</span>
            </div>

            <!-- Main Heading -->
            <h1 class="font-display text-5xl sm:text-7xl lg:text-8xl font-extrabold tracking-tight max-w-5xl text-balance leading-[1.08] mb-8">
                Пространство <span class="gradient-text">абсолютной</span> эстетики и вкуса
            </h1>

            <p class="text-lg sm:text-xl text-zinc-400 max-w-2xl font-light leading-relaxed mb-10">
                Дневной камерный фэнси-бар с авторской кухней, превращающийся вечерними часами в эпицентр современной миксологии и электронного звучания.
            </p>

            <!-- Hero Action Buttons -->
            <div class="flex flex-wrap items-center justify-center gap-4 w-full max-w-md">
                <button onclick="openBookingModal()" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-zinc-100 text-zinc-950 font-bold text-base hover:bg-white transition-all shadow-xl hover:shadow-zinc-200/10 cursor-pointer">
                    Забронировать стол
                </button>
                <a href="#zones" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-zinc-900/80 border border-zinc-800 text-zinc-200 font-semibold text-base hover:bg-zinc-800/80 transition-all backdrop-blur-xl text-center">
                    Исследовать зоны
                </a>
            </div>

            <!-- Quick Metrics Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-20 w-full max-w-4xl">
                <div class="glass-card p-6 text-center">
                    <div class="font-display text-3xl font-bold text-white mb-1">12:00</div>
                    <div class="text-xs text-zinc-400 uppercase tracking-wider">Открытие кухни</div>
                </div>
                <div class="glass-card p-6 text-center">
                    <div class="font-display text-3xl font-bold text-white mb-1">330 м²</div>
                    <div class="text-xs text-zinc-400 uppercase tracking-wider">Пространства</div>
                </div>
                <div class="glass-card p-6 text-center">
                    <div class="font-display text-3xl font-bold text-white mb-1">3 Зоны</div>
                    <div class="text-xs text-zinc-400 uppercase tracking-wider">С разными режимами</div>
                </div>
                <div class="glass-card p-6 text-center">
                    <div class="font-display text-3xl font-bold text-white mb-1">4.9 ★</div>
                    <div class="text-xs text-zinc-400 uppercase tracking-wider">Рейтинг гостей</div>
                </div>
            </div>
        </section>

        <!-- CONCEPT BENTO GRID SECTION -->
        <section id="concept" class="space-y-10 scroll-mt-28">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <h2 class="text-xs font-semibold uppercase tracking-widest text-zinc-500">Философия проекта</h2>
                <p class="font-display text-3xl sm:text-4xl font-bold text-white">Двухфазная трансформация</p>
                <p class="text-zinc-400 text-sm">От спокойного дневного коворкинга до атмосферного ночного бара</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Bento Card 1: Large -->
                <div class="md:col-span-2 glass-card p-8 sm:p-10 flex flex-col justify-between relative overflow-hidden group">
                    <div class="absolute -right-16 -bottom-16 w-64 h-64 rounded-full bg-zinc-800/20 blur-3xl group-hover:bg-zinc-700/30 transition-all duration-500"></div>
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-zinc-800/80 border border-zinc-700 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-zinc-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="font-display text-2xl font-bold text-white mb-3">Дневной протокол // 12:00 – 18:00</h3>
                        <p class="text-zinc-400 leading-relaxed max-w-xl text-sm sm:text-base">
                            Светлое лаконичное пространство с авторским меню, спешелти кофе и винтажными винами. Идеальная локация для деловых встреч, лекций и тихой работы.
                        </p>
                    </div>
                    <div class="mt-8 flex items-center gap-4 text-xs font-semibold text-zinc-400">
                        <span class="px-3 py-1.5 rounded-full bg-zinc-800/90 border border-zinc-700">Спешелти кофе</span>
                        <span class="px-3 py-1.5 rounded-full bg-zinc-800/90 border border-zinc-700">Тихий коворкинг</span>
                        <span class="px-3 py-1.5 rounded-full bg-zinc-800/90 border border-zinc-700">Ланч-меню</span>
                    </div>
                </div>

                <!-- Bento Card 2 -->
                <div class="glass-card p-8 flex flex-col justify-between relative overflow-hidden group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-zinc-800/80 border border-zinc-700 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-zinc-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </div>
                        <h3 class="font-display text-2xl font-bold text-white mb-3">Ночной Матрикс // 18:00 – 03:00</h3>
                        <p class="text-zinc-400 leading-relaxed text-sm">
                            Мягкий свет, авторская миксология, сет-диджеи и камерные перформансы. Пространство погружается в ритм ночного города.
                        </p>
                    </div>
                    <div class="mt-8 flex items-center gap-2 text-xs font-semibold text-zinc-300">
                        <span>Акустический Sound-design</span>
                        <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </div>
        </section>

        <!-- ATMOSPHERE & ZONES SECTION -->
        <section id="zones" class="space-y-12 scroll-mt-28">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h2 class="text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-2">Локации и Залы</h2>
                    <p class="font-display text-3xl sm:text-4xl font-bold text-white">Зонирование Орбиты</p>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="selectZone('main')" id="btn-zone-main" class="px-5 py-2.5 rounded-full text-sm font-semibold bg-zinc-100 text-zinc-950 transition-all cursor-pointer">
                        Главный Бар
                    </button>
                    <button onclick="selectZone('lounge')" id="btn-zone-lounge" class="px-5 py-2.5 rounded-full text-sm font-semibold bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white transition-all cursor-pointer">
                        Лаунж Галерея
                    </button>
                    <button onclick="selectZone('vip')" id="btn-zone-vip" class="px-5 py-2.5 rounded-full text-sm font-semibold bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white transition-all cursor-pointer">
                        VIP Сигарная
                    </button>
                </div>
            </div>

            <!-- Dynamic Zone Cards Container -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

                <!-- Zone Interactive Display Card -->
                <div class="lg:col-span-7 glass-card p-8 sm:p-10 space-y-8 relative overflow-hidden">
                    <div id="zone-tag" class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-zinc-800 border border-zinc-700 text-zinc-300">
                        Емкость: 40 гостей
                    </div>

                    <div class="space-y-4">
                        <h3 id="zone-title" class="font-display text-3xl sm:text-4xl font-bold text-white">Главный Барный Зал</h3>
                        <p id="zone-desc" class="text-zinc-400 text-base leading-relaxed">
                            Центр притяжения с контактной барной стойкой из натурального сланца, дизайнерским светом и высокими потолками исторического особняка.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-zinc-800/80">
                        <div>
                            <span class="text-xs text-zinc-500 uppercase block mb-1">Атмосфера</span>
                            <span id="zone-vibe" class="text-sm font-medium text-zinc-200">Динамичная / Диджей-сеты</span>
                        </div>
                        <div>
                            <span class="text-xs text-zinc-500 uppercase block mb-1">Депозит</span>
                            <span id="zone-deposit" class="text-sm font-medium text-zinc-200">От 3 000 ₽ / чел</span>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button onclick="openBookingModalWithZone()" class="glass-button px-6 py-3 text-sm font-semibold text-white flex items-center gap-2 cursor-pointer">
                            Забронировать стол в этой зоне
                        </button>
                    </div>
                </div>

                <!-- Zone Visual Interactive Sphere Preview -->
                <div class="lg:col-span-5 glass-card p-8 flex flex-col justify-center items-center text-center h-full min-h-[320px] relative">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-tr from-zinc-800 to-zinc-600 border border-zinc-500/30 flex items-center justify-center shadow-2xl animate-float mb-6">
                        <svg class="w-12 h-12 text-zinc-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/>
                        </svg>
                    </div>
                    <p class="text-xs text-zinc-400 uppercase tracking-widest font-semibold">3D Сцена Пространства</p>
                    <p class="text-xs text-zinc-500 mt-1">Интерактивный угол обзора 360°</p>
                </div>
            </div>
        </section>

        <!-- MENU & COCKTAILS SHOWCASE -->
        <section id="menu" class="space-y-12 scroll-mt-28">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <h2 class="text-xs font-semibold uppercase tracking-widest text-zinc-500">Гастрономия и Миксология</h2>
                <p class="font-display text-3xl sm:text-4xl font-bold text-white">Авторское Меню</p>
            </div>

            <!-- Menu Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Cocktails Card -->
                <div class="glass-card p-8 space-y-6">
                    <div class="flex justify-between items-center pb-4 border-b border-zinc-800">
                        <h3 class="font-display text-xl font-bold text-white flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-zinc-300"></span>
                            Авторские Коктейли
                        </h3>
                        <span class="text-xs text-zinc-500 uppercase">Mixology</span>
                    </div>

                    <div class="space-y-6">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h4 class="font-semibold text-zinc-100">Orbita Signal #1</h4>
                                <p class="text-xs text-zinc-400 mt-0.5">Джин на лемонграссе, кордиал из белого персика, юдзу</p>
                            </div>
                            <span class="font-display font-bold text-zinc-200">890 ₽</span>
                        </div>

                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h4 class="font-semibold text-zinc-100">Midnight Eclipse</h4>
                                <p class="text-xs text-zinc-400 mt-0.5">Бурбон, выпаренный порто, ежевичный биттер, дымчатый дуб</p>
                            </div>
                            <span class="font-display font-bold text-zinc-200">950 ₽</span>
                        </div>

                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h4 class="font-semibold text-zinc-100">Zero Gravity</h4>
                                <p class="text-xs text-zinc-400 mt-0.5">Текила, кордиал из маракуйи, содовая из жасмина</p>
                            </div>
                            <span class="font-display font-bold text-zinc-200">850 ₽</span>
                        </div>
                    </div>
                </div>

                <!-- Food Card -->
                <div class="glass-card p-8 space-y-6">
                    <div class="flex justify-between items-center pb-4 border-b border-zinc-800">
                        <h3 class="font-display text-xl font-bold text-white flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-zinc-500"></span>
                            Авторская Кухня
                        </h3>
                        <span class="text-xs text-zinc-500 uppercase">Kitchen</span>
                    </div>

                    <div class="space-y-6">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h4 class="font-semibold text-zinc-100">Тартар из тунца с авокадо</h4>
                                <p class="text-xs text-zinc-400 mt-0.5">Понзу из юдзу, хрустящий чипс из нори</p>
                            </div>
                            <span class="font-display font-bold text-zinc-200">1 100 ₽</span>
                        </div>

                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h4 class="font-semibold text-zinc-100">Утиная грудка с соусом из вишни</h4>
                                <p class="text-xs text-zinc-400 mt-0.5">Пюре из пастернака, запеченный пак-чой</p>
                            </div>
                            <span class="font-display font-bold text-zinc-200">1 450 ₽</span>
                        </div>

                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <h4 class="font-semibold text-zinc-100">Трюфельный ризотто</h4>
                                <p class="text-xs text-zinc-400 mt-0.5">Белые грибы, стружка свежего черного трюфеля</p>
                            </div>
                            <span class="font-display font-bold text-zinc-200">1 250 ₽</span>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- LOCATION & HOURS SECTION -->
        <section id="location" class="glass-card p-8 sm:p-12 scroll-mt-28 relative overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-zinc-800 text-zinc-300">
                        Центр Москвы // Китай-город
                    </div>
                    <h2 class="font-display text-3xl sm:text-5xl font-bold text-white">Ждем вас на Орбите</h2>
                    <p class="text-zinc-400 text-sm sm:text-base leading-relaxed">
                        Исторический особняк XVIII века по адресу ул. Яузская, 1/15. Удобная парковка, отдельный впуск и камерный внутренний двор.
                    </p>

                    <div class="space-y-4 pt-2">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-zinc-800 border border-zinc-700 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-zinc-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <span class="text-xs text-zinc-500 uppercase block">Адрес</span>
                                <span class="text-sm font-semibold text-white">ул. Яузская, 1/15, Москва</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-zinc-800 border border-zinc-700 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-zinc-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <span class="text-xs text-zinc-500 uppercase block">Режим работы</span>
                                <span class="text-sm font-semibold text-white">Вс-Чт: 12:00–00:00 | Пт-Сб: 12:00–03:00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl overflow-hidden bg-zinc-900 border border-zinc-800 p-8 flex flex-col justify-center items-center text-center h-80 relative">
                    <div class="w-16 h-16 rounded-2xl bg-zinc-800 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-zinc-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-white mb-1">Интерактивная карта</h3>
                    <p class="text-xs text-zinc-400 max-w-xs mb-6">Метро Китай-город / Таганская (7 минут пешком)</p>
                    <a href="https://yandex.ru/maps" target="_blank" class="glass-button px-6 py-2.5 text-xs font-semibold text-white">
                        Открыть в Яндекс.Картах
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="border-t border-zinc-900 bg-zinc-950 py-12 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6 text-xs text-zinc-500">
            <div class="flex items-center gap-3">
                <span class="font-display font-bold text-white text-sm">ОРБИТА</span>
                <span>© 2025 Все права защищены.</span>
            </div>
            <div class="flex items-center gap-6">
                <a href="#" class="hover:text-zinc-300 transition-colors">Политика конфиденциальности</a>
                <a href="#" class="hover:text-zinc-300 transition-colors">Правила посещения</a>
            </div>
        </div>
    </footer>

    <!-- BOOKING MODAL DRAWER -->
    <div id="booking-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/80 backdrop-blur-md transition-opacity duration-300">
        <div class="glass-card max-w-lg w-full p-8 sm:p-10 relative space-y-6 border-zinc-700 shadow-2xl">
            <!-- Close Button -->
            <button onclick="closeBookingModal()" class="absolute top-6 right-6 w-10 h-10 rounded-full bg-zinc-800/80 border border-zinc-700 flex items-center justify-center text-zinc-400 hover:text-white transition-colors cursor-pointer">
                ✕
            </button>

            <div>
                <span class="text-xs font-semibold uppercase tracking-widest text-zinc-400">Онлайн Бронирование</span>
                <h3 class="font-display text-2xl font-bold text-white mt-1">Резерв стола</h3>
            </div>

            <form id="booking-form" onsubmit="handleBookingSubmit(event)" class="space-y-4">
                <div>
                    <label class="block text-xs text-zinc-400 uppercase mb-1">Имя</label>
                    <input type="text" required id="book-name" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-zinc-500 transition-colors" placeholder="Иван Иванов">
                </div>

                <div>
                    <label class="block text-xs text-zinc-400 uppercase mb-1">Телефон</label>
                    <input type="tel" required id="book-phone" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-zinc-500 transition-colors" placeholder="+7 (999) 000-00-00">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-zinc-400 uppercase mb-1">Дата</label>
                        <input type="date" required id="book-date" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-zinc-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs text-zinc-400 uppercase mb-1">Время</label>
                        <select required id="book-time" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-zinc-500 transition-colors">
                            <option value="18:00">18:00</option>
                            <option value="19:00">19:00</option>
                            <option value="20:00">20:00</option>
                            <option value="21:00">21:00</option>
                            <option value="22:00">22:00</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-zinc-400 uppercase mb-1">Гости</label>
                        <input type="number" min="1" max="10" value="2" required id="book-guests" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-zinc-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs text-zinc-400 uppercase mb-1">Зона</label>
                        <select id="book-zone" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-zinc-500 transition-colors">
                            <option value="Главный Бар">Главный Бар</option>
                            <option value="Лаунж Галерея">Лаунж Галерея</option>
                            <option value="VIP Сигарная">VIP Сигарная</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 rounded-xl bg-zinc-100 text-zinc-950 font-bold text-sm hover:bg-white transition-all cursor-pointer mt-4">
                    Подтвердить бронирование
                </button>
            </form>

            <div id="booking-success" class="hidden text-center py-8 space-y-3">
                <div class="w-12 h-12 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center mx-auto text-xl">✓</div>
                <h4 class="font-display text-xl font-bold text-white">Стол успешно забронирован!</h4>
                <p class="text-xs text-zinc-400">Наш менеджер свяжется с вами для подтверждения детали брони.</p>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        // Set default date input
        document.getElementById('book-date').value = new Date().toISOString().split('T')[0];

        // Zone Switcher Data
        const zonesData = {
            main: {
                tag: 'Емкость: 40 гостей',
                title: 'Главный Барный Зал',
                desc: 'Центр притяжения с контактной барной стойкой из натурального сланца, дизайнерским светом и высокими потолками исторического особняка.',
                vibe: 'Динамичная / Диджей-сеты',
                deposit: 'От 3 000 ₽ / чел'
            },
            lounge: {
                tag: 'Емкость: 25 гостей',
                title: 'Лаунж Галерея',
                desc: 'Камерный балкон с мягкими глубокими креслами, приватной акустикой и видом на центральную сцену.',
                vibe: 'Уединенный / Лаунж',
                deposit: 'От 4 000 ₽ / чел'
            },
            vip: {
                tag: 'Емкость: 12 гостей',
                title: 'VIP Сигарная',
                desc: 'Закрытый загородный зал с собственной винной комнатой, вытяжкой и персональным обслуживанием.',
                vibe: 'Приватная / Премиум',
                deposit: 'От 6 000 ₽ / чел'
            }
        };

        function selectZone(zoneKey) {
            const data = zonesData[zoneKey];
            if (!data) return;

            document.getElementById('zone-tag').innerText = data.tag;
            document.getElementById('zone-title').innerText = data.title;
            document.getElementById('zone-desc').innerText = data.desc;
            document.getElementById('zone-vibe').innerText = data.vibe;
            document.getElementById('zone-deposit').innerText = data.deposit;

            // Update button styles
            ['main', 'lounge', 'vip'].forEach(key => {
                const btn = document.getElementById(`btn-zone-${key}`);
                if (key === zoneKey) {
                    btn.className = 'px-5 py-2.5 rounded-full text-sm font-semibold bg-zinc-100 text-zinc-950 transition-all cursor-pointer';
                } else {
                    btn.className = 'px-5 py-2.5 rounded-full text-sm font-semibold bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white transition-all cursor-pointer';
                }
            });
        }

        // Modal Controls
        function openBookingModal() {
            document.getElementById('booking-modal').classList.remove('hidden');
        }

        function openBookingModalWithZone() {
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

        // Three.js Studio Scene Initialization
        window.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('canvas-container');
            if (!container || typeof THREE === 'undefined') return;

            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.z = 15;

            const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            container.appendChild(renderer.domElement);

            // Lighting
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.4);
            scene.add(ambientLight);

            const pointLight1 = new THREE.PointLight(0xffffff, 1.2, 50);
            pointLight1.position.set(10, 10, 10);
            scene.add(pointLight1);

            const pointLight2 = new THREE.PointLight(0x71717a, 1.5, 50);
            pointLight2.position.set(-10, -10, -5);
            scene.add(pointLight2);

            // Smooth Metallic Torus Knot Geometry
            const geometry = new THREE.TorusKnotGeometry(4, 1.2, 128, 32);
            const material = new THREE.MeshStandardMaterial({
                color: 0x27272a,
                roughness: 0.2,
                metalness: 0.8,
                wireframe: false
            });

            const torusKnot = new THREE.Mesh(geometry, material);
            scene.add(torusKnot);

            // Floating particles field
            const particlesGeo = new THREE.BufferGeometry();
            const count = 400;
            const posArray = new Float32Array(count * 3);
            for(let i=0; i<count*3; i++) {
                posArray[i] = (Math.random() - 0.5) * 40;
            }
            particlesGeo.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
            const particlesMat = new THREE.PointsMaterial({
                size: 0.05,
                color: 0x71717a,
                transparent: true,
                opacity: 0.5
            });
            const particleMesh = new THREE.Points(particlesGeo, particlesMat);
            scene.add(particleMesh);

            // Mouse parallax
            let mouseX = 0;
            let mouseY = 0;
            window.addEventListener('mousemove', (e) => {
                mouseX = (e.clientX / window.innerWidth) - 0.5;
                mouseY = (e.clientY / window.innerHeight) - 0.5;
            });

            // Render loop
            function animate() {
                requestAnimationFrame(animate);

                torusKnot.rotation.x += 0.003;
                torusKnot.rotation.y += 0.005;

                torusKnot.position.x += (mouseX * 2 - torusKnot.position.x) * 0.05;
                torusKnot.position.y += (-mouseY * 2 - torusKnot.position.y) * 0.05;

                particleMesh.rotation.y -= 0.001;

                renderer.render(scene, camera);
            }
            animate();

            // Resize handling
            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            });
        });
    </script>
</body>
</html>
