<!DOCTYPE html>
<html lang="ru" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ОРБИТА — Космический Бар & Творческое Пространство</title>
    <meta name="description" content="Атмосферный ресторан-бар и креативный хаб. Авторские коктейли, космическая кухня, живые события и DJ-сеты.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Three.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #030308;
            color: #f1f5f9;
            overflow-x: hidden;
        }
        h1, h2, h3, .font-heading {
            font-family: 'Unbounded', sans-serif;
        }
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
    </style>
</head>
<body class="bg-[#030308] text-slate-100 antialiased selection:bg-purple-500 selection:text-white">

    @php
        $loyaltyTiers = [
            ['tier' => 'Спутник', 'cashback' => '5%', 'condition' => 'До 20 000 ₽ / мес'],
            ['tier' => 'Орбита', 'cashback' => '10%', 'condition' => 'От 20 000 ₽ / мес'],
            ['tier' => 'Невесомость', 'cashback' => '15%', 'condition' => 'От 50 000 ₽ / мес + VIP доступ'],
        ];
    @endphp

    <!-- 3D Canvas Background -->
    <div id="canvas-container"></div>

    <div class="content-layer">
        <!-- Navigation Bar -->
        <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" id="navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <a href="#hero" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-purple-600 via-indigo-500 to-cyan-400 p-[2px] animate-spin-slow">
                        <div class="w-full h-full bg-[#030308] rounded-full flex items-center justify-center">
                            <span class="text-cyan-400 font-bold text-lg font-heading">О</span>
                        </div>
                    </div>
                    <span class="text-xl font-black font-heading tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-white via-slate-200 to-slate-400 group-hover:from-purple-400 group-hover:to-cyan-400 transition-all">
                        ОРБИТА
                    </span>
                </a>

                <nav class="hidden md:flex items-center gap-8 bg-white/5 backdrop-blur-xl border border-white/10 px-6 py-2.5 rounded-full shadow-2xl">
                    <a href="#concept" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors">Концепт</a>
                    <a href="#zones" class="text-sm font-medium text-slate-300 hover:text-purple-400 transition-colors">Зоны</a>
                    <a href="#events" class="text-sm font-medium text-slate-300 hover:text-pink-400 transition-colors">События</a>
                    <a href="#menu" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors">Меню</a>
                    <a href="#loyalty" class="text-sm font-medium text-slate-300 hover:text-purple-400 transition-colors">Орбитальность</a>
                    <a href="#contacts" class="text-sm font-medium text-slate-300 hover:text-indigo-400 transition-colors">Контакты</a>
                </nav>

                <div class="flex items-center gap-4">
                    <button onclick="openBookingModal('Главная зона')" class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium rounded-full group bg-gradient-to-br from-purple-600 to-cyan-500 group-hover:from-purple-600 group-hover:to-cyan-500 hover:text-white text-white focus:ring-4 focus:outline-none focus:ring-cyan-800 shadow-lg shadow-cyan-500/30">
                        <span class="relative px-5 py-2 transition-all ease-in duration-75 bg-[#030308] rounded-full group-hover:bg-opacity-0 font-heading text-xs tracking-wider uppercase">
                            Забронировать
                        </span>
                    </button>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section id="hero" class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
            <div class="max-w-5xl mx-auto px-4 text-center relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-purple-500/10 border border-purple-500/30 backdrop-blur-md mb-8">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                    <span class="text-xs uppercase tracking-widest font-semibold text-cyan-300">Интерактивная 3D Вселенная</span>
                </div>

                <h1 class="text-4xl sm:text-6xl md:text-7xl lg:text-8xl font-black font-heading tracking-tight text-white mb-8 leading-none">
                    ПРОСТРАНСТВО <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-pink-500 to-cyan-400 animate-gradient">
                        ВНЕ ПРИТЯЖЕНИЯ
                    </span>
                </h1>

                <p class="text-lg sm:text-xl text-slate-300 max-w-2xl mx-auto mb-10 font-light leading-relaxed">
                    Симбиоз космической эстетики, гастрономии будущего и современной электронной музыки. Погрузитесь в интерактивный 3D мир бара «Орбита».
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <button onclick="openBookingModal('Главная сцена')" class="w-full sm:w-auto px-8 py-4 rounded-full bg-gradient-to-r from-purple-600 via-indigo-600 to-cyan-500 text-white font-heading text-xs tracking-widest uppercase font-bold shadow-xl shadow-purple-600/30 hover:scale-105 transition-all duration-300">
                        Забронировать стол
                    </button>
                    <a href="#menu" class="w-full sm:w-auto px-8 py-4 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 backdrop-blur-xl text-slate-200 font-heading text-xs tracking-widest uppercase font-bold transition-all duration-300">
                        Исследовать меню
                    </a>
                </div>

                <!-- Live stats counter badge -->
                <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-3xl mx-auto">
                    <div class="bg-white/5 border border-white/10 backdrop-blur-md p-4 rounded-2xl">
                        <div class="text-2xl font-black font-heading text-cyan-400">4</div>
                        <div class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Уникальных зоны</div>
                    </div>
                    <div class="bg-white/5 border border-white/10 backdrop-blur-md p-4 rounded-2xl">
                        <div class="text-2xl font-black font-heading text-purple-400">18+</div>
                        <div class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Авторских коктейлей</div>
                    </div>
                    <div class="bg-white/5 border border-white/10 backdrop-blur-md p-4 rounded-2xl">
                        <div class="text-2xl font-black font-heading text-pink-400">3D</div>
                        <div class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Графика Three.js</div>
                    </div>
                    <div class="bg-white/5 border border-white/10 backdrop-blur-md p-4 rounded-2xl">
                        <div class="text-2xl font-black font-heading text-indigo-400">100%</div>
                        <div class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Атмосфера</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Concept Section -->
        <section id="concept" class="py-24 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-xs uppercase tracking-widest font-semibold mb-6">
                            О концепции
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-bold font-heading text-white mb-6 leading-tight">
                            ГДЕ ИСКУССТВО ВСТРЕЧАЕТ <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-purple-400">ТЕХНОЛОГИИ</span>
                        </h2>
                        <p class="text-slate-300 text-lg mb-6 leading-relaxed">
                            «Орбита» — это больше, чем просто бар или ресторан. Это мультимедийное пространство для тех, кто ищет вдохновение, глубокий звук и неповторимую атмосферу.
                        </p>
                        <p class="text-slate-400 text-base mb-8 leading-relaxed">
                            Каждый элемент нашего пространства — от световых партитур до молекулярной подачи напитков — создан для погружения в состояние невесомости.
                        </p>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="border-l-2 border-purple-500 pl-4">
                                <h4 class="font-heading text-white font-bold text-sm">Звук Hi-End</h4>
                                <p class="text-xs text-slate-400 mt-1">Акустическая система минимизирует искажения</p>
                            </div>
                            <div class="border-l-2 border-cyan-500 pl-4">
                                <h4 class="font-heading text-white font-bold text-sm">3D Визуал</h4>
                                <p class="text-xs text-slate-400 mt-1">Динамическое световое оформление</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="relative rounded-3xl overflow-hidden border border-white/10 bg-gradient-to-b from-purple-900/20 to-black/60 p-8 backdrop-blur-xl">
                            <div class="aspect-video rounded-2xl bg-gradient-to-tr from-purple-900/40 via-indigo-900/20 to-cyan-900/40 border border-white/10 flex items-center justify-center relative overflow-hidden group">
                                <div class="text-center p-6 relative z-10">
                                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-cyan-500/20 border border-cyan-400/50 flex items-center justify-center text-cyan-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <h3 class="font-heading font-bold text-white text-xl">Виртуальный Тур 3D</h3>
                                    <p class="text-slate-400 text-xs mt-2">Вращайте орбитную сцену мышкой для лучшего обзора</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Zones Section -->
        <section id="zones" class="py-24 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-400 text-xs uppercase tracking-widest font-semibold mb-4">
                        Локации
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-bold font-heading text-white">ПРОСТРАНСТВА И ЗОНЫ</h2>
                    <p class="text-slate-400 text-base mt-4">Выберите зону для вашего вечера или важного события</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($zones as $zone)
                        <div class="group relative rounded-3xl bg-white/5 border border-white/10 p-6 backdrop-blur-xl hover:bg-white/10 transition-all duration-500 flex flex-col justify-between hover:-translate-y-2">
                            <div>
                                <div class="w-12 h-12 rounded-2xl bg-purple-500/20 border border-purple-500/30 flex items-center justify-center text-purple-300 font-bold font-heading mb-6 group-hover:scale-110 transition-transform">
                                    0{{ $loop->iteration }}
                                </div>
                                <h3 class="text-xl font-bold font-heading text-white mb-2">{{ $zone['name'] }}</h3>
                                <p class="text-slate-400 text-xs leading-relaxed mb-6">{{ $zone['description'] }}</p>
                            </div>
                            <div>
                                <div class="flex items-center justify-between text-xs text-slate-300 pt-4 border-t border-white/10 mb-6">
                                    <span>Вместимость:</span>
                                    <span class="font-semibold text-cyan-400">{{ $zone['capacity'] }}</span>
                                </div>
                                <button onclick="openBookingModal('{{ $zone['name'] }}')" class="w-full py-3 rounded-xl bg-white/10 hover:bg-gradient-to-r hover:from-purple-600 hover:to-cyan-500 text-white font-heading text-xs uppercase tracking-wider transition-all duration-300">
                                    Забронировать
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Menu Section -->
        <section id="menu" class="py-24 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-xs uppercase tracking-widest font-semibold mb-4">
                        Гастрономия
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-bold font-heading text-white">АВТОРСКОЕ МЕНЮ</h2>
                </div>

                <!-- Menu Switcher Tabs -->
                <div class="flex justify-center mb-12">
                    <div class="inline-flex p-1.5 rounded-full bg-white/5 border border-white/10 backdrop-blur-xl">
                        <button id="tab-bar" onclick="switchMenu('bar')" class="px-8 py-3 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 bg-gradient-to-r from-purple-600 to-cyan-500 text-white shadow-lg">
                            Барная карта
                        </button>
                        <button id="tab-kitchen" onclick="switchMenu('kitchen')" class="px-8 py-3 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 text-slate-400 hover:text-white">
                            Кухня
                        </button>
                    </div>
                </div>

                <!-- Bar Menu Items -->
                <div id="menu-bar" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($menu['bar'] as $item)
                        <div class="p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xl hover:border-cyan-500/50 transition-all flex justify-between items-start">
                            <div>
                                <h4 class="font-heading font-bold text-white text-base mb-1">{{ $item['name'] }}</h4>
                                <p class="text-slate-400 text-xs mb-3">{{ $item['desc'] }}</p>
                                <span class="text-[10px] uppercase font-bold tracking-wider px-2.5 py-1 rounded-full bg-purple-500/20 text-purple-300 border border-purple-500/30">
                                    {{ $item['tag'] }}
                                </span>
                            </div>
                            <div class="text-lg font-black font-heading text-cyan-400 whitespace-nowrap ml-4">
                                {{ $item['price'] }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Kitchen Menu Items -->
                <div id="menu-kitchen" class="grid grid-cols-1 md:grid-cols-2 gap-6 hidden">
                    @foreach($menu['kitchen'] as $item)
                        <div class="p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xl hover:border-purple-500/50 transition-all flex justify-between items-start">
                            <div>
                                <h4 class="font-heading font-bold text-white text-base mb-1">{{ $item['name'] }}</h4>
                                <p class="text-slate-400 text-xs mb-3">{{ $item['desc'] }}</p>
                                <span class="text-[10px] uppercase font-bold tracking-wider px-2.5 py-1 rounded-full bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">
                                    {{ $item['tag'] }}
                                </span>
                            </div>
                            <div class="text-lg font-black font-heading text-purple-400 whitespace-nowrap ml-4">
                                {{ $item['price'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Events Section -->
        <section id="events" class="py-24 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-pink-500/10 border border-pink-500/20 text-pink-400 text-xs uppercase tracking-widest font-semibold mb-4">
                        Лайн-ап
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-bold font-heading text-white">ПРЕДСТОЯЩИЕ СОБЫТИЯ</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($events as $event)
                        <div class="rounded-3xl bg-white/5 border border-white/10 p-6 backdrop-blur-xl flex flex-col justify-between hover:border-pink-500/50 transition-all duration-300">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xs font-bold font-heading text-pink-400">{{ $event['date'] }}</span>
                                    <span class="text-xs text-slate-400">{{ $event['category'] }}</span>
                                </div>
                                <h3 class="text-xl font-bold font-heading text-white mb-2">{{ $event['title'] }}</h3>
                                <p class="text-slate-400 text-xs mb-6 leading-relaxed">{{ $event['description'] }}</p>
                            </div>
                            <div class="pt-4 border-t border-white/10 flex items-center justify-between">
                                <span class="text-xs font-semibold text-slate-300">Тег: {{ $event['tag'] }}</span>
                                <button onclick="openBookingModal('Событие: {{ $event['title'] }}')" class="text-xs font-heading font-bold text-cyan-400 hover:text-cyan-300 uppercase">
                                    Записаться &rarr;
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Loyalty Program Section -->
        <section id="loyalty" class="py-24 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-3xl bg-gradient-to-r from-purple-900/40 via-indigo-900/20 to-cyan-900/40 border border-white/10 p-8 sm:p-12 backdrop-blur-2xl">
                    <div class="max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/20 text-purple-300 text-xs uppercase tracking-widest font-semibold mb-6">
                            Программа лояльности
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-bold font-heading text-white mb-6">«ОРБИТАЛЬНОСТЬ»</h2>
                        <p class="text-slate-300 text-base mb-8 leading-relaxed">
                            Копите орбитальные баллы за каждый визит и заказ. Повышайте статус и получайте эксклюзивный доступ к закрытым вечеринкам и комплиментам от шеф-бармена.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-8">
                        @foreach($loyaltyTiers as $tier)
                            <div class="bg-black/40 border border-white/10 rounded-2xl p-6 backdrop-blur-md">
                                <div class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-2">Уровень {{ $loop->iteration }}</div>
                                <h4 class="font-heading font-bold text-xl text-white mb-1">{{ $tier['tier'] }}</h4>
                                <div class="text-cyan-400 font-black font-heading text-2xl mb-2">{{ $tier['cashback'] }}</div>
                                <p class="text-slate-400 text-xs">{{ $tier['condition'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Contacts & Location Section -->
        <section id="contacts" class="py-24 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs uppercase tracking-widest font-semibold mb-6">
                            Контакты
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-bold font-heading text-white mb-8">ЖДЕМ ВАС НА ОРБИТЕ</h2>

                        <div class="space-y-6 text-slate-300">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-purple-500/20 flex items-center justify-center text-purple-400 font-bold">📍</div>
                                <div>
                                    <div class="text-xs text-slate-400 uppercase">Адрес</div>
                                    <div class="font-semibold text-white">г. Москва, ул. Космонавтов, д. 12</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-cyan-500/20 flex items-center justify-center text-cyan-400 font-bold">⏰</div>
                                <div>
                                    <div class="text-xs text-slate-400 uppercase">Режим работы</div>
                                    <div class="font-semibold text-white">Пн - Чт: 18:00 - 02:00 | Пт - Сб: 18:00 - 06:00</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-pink-500/20 flex items-center justify-center text-pink-400 font-bold">📞</div>
                                <div>
                                    <div class="text-xs text-slate-400 uppercase">Телефон для брони</div>
                                    <div class="font-semibold text-white">+7 (495) 888-00-11</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Embedded Interactive Map -->
                    <div class="rounded-3xl overflow-hidden border border-white/10 h-80 sm:h-auto min-h-[300px] relative bg-slate-900">
                        <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A021b36585141b7ddae441b897e9ed2ddf3e0c03490919df434ec9c1a0be5f606&amp;source=constructor" width="100%" height="100%" frameborder="0" class="w-full h-full grayscale opacity-80 hover:opacity-100 hover:grayscale-0 transition-all duration-500"></iframe>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-white/10 py-12 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="text-slate-400 text-xs">
                    © 2026 ОРБИТА БАР. Все права защищены.
                </div>
                <div class="flex items-center gap-6 text-slate-400 text-xs">
                    <a href="#" class="hover:text-cyan-400 transition-colors">Telegram</a>
                    <a href="#" class="hover:text-purple-400 transition-colors">VKontakte</a>
                    <a href="#" class="hover:text-pink-400 transition-colors">Instagram</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Booking Modal -->
    <div id="booking-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md hidden opacity-0 transition-all duration-300">
        <div class="bg-[#0b0c16] border border-white/20 rounded-3xl p-6 sm:p-8 max-w-lg w-full relative shadow-2xl">
            <button onclick="closeBookingModal()" class="absolute top-6 right-6 text-slate-400 hover:text-white font-bold text-xl">&times;</button>
            <h3 class="font-heading font-bold text-2xl text-white mb-2">БРОНИРОВАНИЕ СТОЛА</h3>
            <p id="modal-subtitle" class="text-xs text-slate-400 mb-6">Выберите дату и параметры вашего визита</p>

            <form id="booking-form" onsubmit="submitBooking(event)" class="space-y-4">
                <input type="hidden" id="booking-zone" name="zone" value="Главная зона">

                <div>
                    <label class="block text-xs uppercase font-bold text-slate-400 mb-1">Ваше имя</label>
                    <input type="text" name="name" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-cyan-400 transition-colors" placeholder="Александр">
                </div>

                <div>
                    <label class="block text-xs uppercase font-bold text-slate-400 mb-1">Телефон</label>
                    <input type="tel" name="phone" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-cyan-400 transition-colors" placeholder="+7 (999) 000-00-00">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs uppercase font-bold text-slate-400 mb-1">Дата</label>
                        <input type="date" name="date" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-cyan-400 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs uppercase font-bold text-slate-400 mb-1">Время</label>
                        <input type="time" name="time" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-cyan-400 transition-colors">
                    </div>
                </div>

                <div>
                    <label class="block text-xs uppercase font-bold text-slate-400 mb-1">Количество гостей</label>
                    <select name="guests" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-cyan-400 transition-colors">
                        <option value="1" class="bg-slate-900">1 человек</option>
                        <option value="2" selected class="bg-slate-900">2 человека</option>
                        <option value="4" class="bg-slate-900">4 человека</option>
                        <option value="6" class="bg-slate-900">6+ человек</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-4 mt-2 rounded-xl bg-gradient-to-r from-purple-600 to-cyan-500 text-white font-heading font-bold text-xs uppercase tracking-widest shadow-lg hover:scale-[1.02] transition-transform">
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

    <!-- Interactive Three.js 3D Background Script -->
    <script>
        // --- 3D THREE.JS ANIMATED SCENE ---
        const container = document.getElementById('canvas-container');
        const scene = new THREE.Scene();

        // Add subtle fog for depth
        scene.fog = new THREE.FogExp2(0x030308, 0.015);

        const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.z = 30;

        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        container.appendChild(renderer.domElement);

        // Lighting
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.4);
        scene.add(ambientLight);

        const pointLight1 = new THREE.PointLight(0xa855f7, 3, 50); // Purple glow
        pointLight1.position.set(15, 15, 10);
        scene.add(pointLight1);

        const pointLight2 = new THREE.PointLight(0x06b6d4, 3, 50); // Cyan glow
        pointLight2.position.set(-15, -15, 10);
        scene.add(pointLight2);

        // 3D Objects Group (Orbit System)
        const orbitGroup = new THREE.Group();
        scene.add(orbitGroup);

        // Central Glowing Torus (Orbital Ring)
        const ringGeo = new THREE.TorusGeometry(8, 0.3, 16, 100);
        const ringMat = new THREE.MeshStandardMaterial({
            color: 0x8b5cf6,
            roughness: 0.2,
            metalness: 0.8,
            wireframe: true
        });
        const mainRing = new THREE.Mesh(ringGeo, ringMat);
        orbitGroup.add(mainRing);

        // Secondary Outer Ring
        const ringGeo2 = new THREE.TorusGeometry(12, 0.15, 16, 100);
        const ringMat2 = new THREE.MeshStandardMaterial({
            color: 0x06b6d4,
            roughness: 0.3,
            metalness: 0.9,
            wireframe: true
        });
        const outerRing = new THREE.Mesh(ringGeo2, ringMat2);
        outerRing.rotation.x = Math.PI / 3;
        orbitGroup.add(outerRing);

        // Floating 3D Spheres / Planets
        const spheres = [];
        const sphereGeo = new THREE.IcosahedronGeometry(1.2, 2);
        const colors = [0xa855f7, 0x06b6d4, 0xec4899, 0x6366f1];

        for (let i = 0; i < 12; i++) {
            const mat = new THREE.MeshStandardMaterial({
                color: colors[i % colors.length],
                roughness: 0.2,
                metalness: 0.7,
                flatShading: true
            });
            const sphere = new THREE.Mesh(sphereGeo, mat);

            const radius = 10 + Math.random() * 12;
            const angle = (i / 12) * Math.PI * 2;
            sphere.position.x = Math.cos(angle) * radius;
            sphere.position.y = (Math.random() - 0.5) * 10;
            sphere.position.z = Math.sin(angle) * radius;

            sphere.userData = {
                angle: angle,
                radius: radius,
                speed: 0.003 + Math.random() * 0.005
            };

            spheres.push(sphere);
            orbitGroup.add(sphere);
        }

        // Starfield Particles Background
        const particlesCount = 800;
        const particleGeo = new THREE.BufferGeometry();
        const positions = new Float32Array(particlesCount * 3);

        for (let i = 0; i < particlesCount * 3; i += 3) {
            positions[i] = (Math.random() - 0.5) * 100;
            positions[i + 1] = (Math.random() - 0.5) * 100;
            positions[i + 2] = (Math.random() - 0.5) * 100;
        }

        particleGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        const particleMat = new THREE.PointsMaterial({
            size: 0.15,
            color: 0xffffff,
            transparent: true,
            opacity: 0.8
        });
        const starfield = new THREE.Points(particleGeo, particleMat);
        scene.add(starfield);

        // Mouse Parallax Interaction
        let mouseX = 0;
        let mouseY = 0;
        let targetX = 0;
        let targetY = 0;

        window.addEventListener('mousemove', (e) => {
            mouseX = (e.clientX - window.innerWidth / 2) * 0.001;
            mouseY = (e.clientY - window.innerHeight / 2) * 0.001;
        });

        // Window Resize Handler
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        // Animation Loop
        const clock = new THREE.Clock();

        function animate() {
            requestAnimationFrame(animate);

            const elapsedTime = clock.getElapsedTime();

            // Smooth parallax lerp
            targetX += (mouseX - targetX) * 0.05;
            targetY += (mouseY - targetY) * 0.05;

            orbitGroup.rotation.y = elapsedTime * 0.15 + targetX * 2;
            orbitGroup.rotation.x = Math.sin(elapsedTime * 0.1) * 0.2 + targetY * 2;

            // Animate spheres on orbit
            spheres.forEach((s) => {
                s.userData.angle += s.userData.speed;
                s.position.x = Math.cos(s.userData.angle) * s.userData.radius;
                s.position.z = Math.sin(s.userData.angle) * s.userData.radius;
                s.rotation.x += 0.01;
                s.rotation.y += 0.01;
            });

            starfield.rotation.y = elapsedTime * 0.02;

            renderer.render(scene, camera);
        }

        animate();

        // --- PAGE INTERACTIVE LOGIC ---
        function switchMenu(type) {
            const barMenu = document.getElementById('menu-bar');
            const kitchenMenu = document.getElementById('menu-kitchen');
            const tabBar = document.getElementById('tab-bar');
            const tabKitchen = document.getElementById('tab-kitchen');

            if (type === 'bar') {
                barMenu.classList.remove('hidden');
                kitchenMenu.classList.add('hidden');
                tabBar.className = "px-8 py-3 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 bg-gradient-to-r from-purple-600 to-cyan-500 text-white shadow-lg";
                tabKitchen.className = "px-8 py-3 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 text-slate-400 hover:text-white";
            } else {
                kitchenMenu.classList.remove('hidden');
                barMenu.classList.add('hidden');
                tabKitchen.className = "px-8 py-3 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 bg-gradient-to-r from-purple-600 to-cyan-500 text-white shadow-lg";
                tabBar.className = "px-8 py-3 rounded-full text-xs font-heading font-bold uppercase tracking-wider transition-all duration-300 text-slate-400 hover:text-white";
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
                    alert('Ошибка при бронировании. Проверьте введенные данные.');
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
