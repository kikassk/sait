<!DOCTYPE html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ОРБИТА — Бар & Творческое Пространство</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#070709] text-gray-100 font-sans selection:bg-[#e5c158] selection:text-black min-h-screen relative overflow-x-hidden">

    <!-- Ambient Glowing Orbs background -->
    <div class="fixed top-[-100px] left-[-100px] glow-orb-gold z-0 animate-pulse-glow"></div>
    <div class="fixed top-[40%] right-[-150px] glow-orb-purple z-0 animate-pulse-glow" style="animation-delay: 1.5s;"></div>
    <div class="fixed bottom-[-100px] left-[20%] glow-orb-pink z-0 animate-pulse-glow" style="animation-delay: 3s;"></div>

    <!-- Header Navigation -->
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 glass-panel border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#e5c158] via-purple-600 to-pink-500 p-[2px] animate-spin-slow">
                    <div class="w-full h-full bg-[#070709] rounded-full flex items-center justify-center">
                        <span class="text-[#e5c158] font-black text-sm">O</span>
                    </div>
                </div>
                <span class="font-extrabold text-2xl tracking-widest uppercase bg-gradient-to-r from-white via-gray-200 to-[#e5c158] bg-clip-text text-transparent group-hover:scale-105 transition-transform">
                    ОРБИТА
                </span>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium tracking-wide">
                <a href="#about" class="text-gray-300 hover:text-[#e5c158] transition-colors">О нас</a>
                <a href="#space" class="text-gray-300 hover:text-[#e5c158] transition-colors">Пространство</a>
                <a href="#events" class="text-gray-300 hover:text-[#e5c158] transition-colors">События</a>
                <a href="#menu" class="text-gray-300 hover:text-[#e5c158] transition-colors">Меню</a>
                <a href="#loyalty" class="text-gray-300 hover:text-[#e5c158] transition-colors">Орбитальность</a>
                <a href="#contacts" class="text-gray-300 hover:text-[#e5c158] transition-colors">Контакты</a>
            </nav>

            <div class="flex items-center gap-4">
                <button onclick="openBookingModal()" class="relative group px-6 py-2.5 rounded-full text-sm font-semibold tracking-wide text-black overflow-hidden transition-all duration-300 transform hover:scale-105">
                    <span class="absolute inset-0 bg-gradient-to-r from-[#e5c158] via-amber-300 to-[#e5c158] group-hover:opacity-90"></span>
                    <span class="relative z-10 flex items-center gap-2 uppercase tracking-wider text-xs font-bold">
                        Забронировать
                    </span>
                </button>
            </div>
        </div>
    </header>

    <main class="relative z-10 pt-20">
        <!-- Hero Section -->
        <section class="min-h-[90vh] flex items-center justify-center relative px-4 sm:px-6 lg:px-8 py-20 overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-gradient-to-b from-[#070709]/60 via-[#070709]/80 to-[#070709]"></div>
                <img src="https://images.unsplash.com/photo-1514933651103-005eec06c04b?auto=format&fit=crop&w=1920&q=80" alt="Orbita Bar Interior" class="w-full h-full object-cover opacity-25 filter blur-[2px] scale-105">
            </div>

            <div class="max-w-5xl mx-auto text-center relative z-10 space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-panel text-[#e5c158] text-xs font-bold uppercase tracking-widest border border-[#e5c158]/30">
                    <span class="w-2 h-2 rounded-full bg-[#e5c158] animate-ping"></span>
                    Исторический особняк на Яузской
                </div>

                <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold uppercase tracking-tight text-white leading-tight">
                    Двигайся вместе с <br>
                    <span class="bg-gradient-to-r from-[#e5c158] via-purple-400 to-pink-500 bg-clip-text text-transparent">Орбитой</span>
                </h1>

                <p class="max-w-2xl mx-auto text-gray-300 text-lg sm:text-xl font-light leading-relaxed">
                    Днём — фэнси-бар с яркой кухней и творческими событиями.<br>
                    Ночью — пространство с актуальным звуком и авторскими коктейлями.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <button onclick="openBookingModal()" class="w-full sm:w-auto px-8 py-4 rounded-full bg-gradient-to-r from-[#e5c158] to-amber-500 text-black font-extrabold text-sm uppercase tracking-wider hover:opacity-95 shadow-lg shadow-[#e5c158]/20 transition-all transform hover:-translate-y-1">
                        Забронировать стол
                    </button>
                    <a href="#menu" class="w-full sm:w-auto px-8 py-4 rounded-full glass-panel border border-white/20 text-white font-bold text-sm uppercase tracking-wider hover:border-[#e5c158] hover:text-[#e5c158] transition-all">
                        Изучить меню
                    </a>
                </div>

                <!-- Live Indicators -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 pt-12 max-w-3xl mx-auto">
                    <div class="glass-card p-4 rounded-2xl text-left border border-white/5">
                        <span class="text-xs text-gray-400 uppercase tracking-wider block mb-1">Режим работы</span>
                        <p class="text-sm font-semibold text-white">Вс-Чт: 12:00 — 00:00</p>
                        <p class="text-sm font-semibold text-[#e5c158]">Пт-Сб: 12:00 — 03:00</p>
                    </div>
                    <div class="glass-card p-4 rounded-2xl text-left border border-white/5">
                        <span class="text-xs text-gray-400 uppercase tracking-wider block mb-1">Локация</span>
                        <p class="text-sm font-semibold text-white">ул. Яузская 1/15</p>
                        <p class="text-xs text-gray-400">м. Китай-город / Таганская</p>
                    </div>
                    <div class="glass-card p-4 rounded-2xl text-left border border-white/5 col-span-2 md:col-span-1">
                        <span class="text-xs text-gray-400 uppercase tracking-wider block mb-1">Атмосфера</span>
                        <p class="text-sm font-semibold text-white">Авторская кухня & Коктейли</p>
                        <p class="text-xs text-purple-400">Live dj sets & квартирники</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Concept Section -->
        <section id="about" class="py-24 px-4 sm:px-6 lg:px-8 relative">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full glass-panel text-xs text-purple-400 font-semibold tracking-widest uppercase">
                            О концепции
                        </div>
                        <h2 class="text-3xl sm:text-5xl font-extrabold text-white leading-tight uppercase">
                            Творческий кластер <br>
                            <span class="text-[#e5c158]">& Бар-Трансформер</span>
                        </h2>
                        <p class="text-gray-300 leading-relaxed text-base sm:text-lg">
                            ОРБИТА — место, где звезды тусуются не на небе, а за соседним столиком.
                            Здесь вдохновение встречается со вкусом: авторская кухня с азиатскими мотивами, свежая барная карта, мастер-классы, джемы с молодыми артистами и уютные акустические концерты.
                        </p>
                        <div class="p-6 rounded-2xl glass-card border-l-4 border-l-[#e5c158] space-y-2">
                            <p class="text-sm italic text-gray-300">
                                «Я давно мечтал о пространстве, в котором смогу делиться тем, что мне важно. Место, в котором можно создавать новое, искать друзей и соратников, куда можно приехать за свежими идеями и просто круто провести время.»
                            </p>
                            <span class="text-xs font-bold text-[#e5c158] block uppercase tracking-wider">— Автор и создатель Ваня Дмитриенко</span>
                        </div>
                    </div>

                    <div class="relative grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <img src="https://images.unsplash.com/photo-1572116469696-31de0f17cc34?auto=format&fit=crop&w=600&q=80" alt="Cocktail" class="rounded-3xl object-cover h-64 w-full shadow-2xl glass-card">
                            <div class="p-6 rounded-3xl glass-panel border border-white/10 text-center">
                                <span class="text-4xl font-extrabold text-[#e5c158] block">4</span>
                                <span class="text-xs text-gray-400 uppercase tracking-widest">Уникальные зоны</span>
                            </div>
                        </div>
                        <div class="space-y-4 pt-8">
                            <div class="p-6 rounded-3xl glass-panel border border-white/10 text-center">
                                <span class="text-4xl font-extrabold text-purple-400 block">100+</span>
                                <span class="text-xs text-gray-400 uppercase tracking-widest">Мероприятий в год</span>
                            </div>
                            <img src="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=600&q=80" alt="Live Event" class="rounded-3xl object-cover h-64 w-full shadow-2xl glass-card">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Interactive Zones (Space) -->
        <section id="space" class="py-24 px-4 sm:px-6 lg:px-8 bg-black/40 relative">
            <div class="max-w-7xl mx-auto space-y-12">
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <span class="text-xs font-bold uppercase tracking-widest text-[#e5c158] glass-panel px-4 py-1.5 rounded-full">Пространство</span>
                    <h2 class="text-3xl sm:text-5xl font-extrabold text-white uppercase">Атмосферные зоны особняка</h2>
                    <p class="text-gray-400 text-sm sm:text-base">Каждая локация создана под свое настроение: от живых выступлений и громких танцев до уединенных бесед у камина.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($zones as $zone)
                        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between h-full group hover:border-[#e5c158]/50 transition-all">
                            <div class="space-y-4">
                                <div class="w-12 h-12 rounded-2xl bg-[#e5c158]/10 text-[#e5c158] flex items-center justify-center group-hover:bg-[#e5c158] group-hover:text-black transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $zone['icon'] }}"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs text-purple-400 font-bold uppercase tracking-wider block mb-1">{{ $zone['badge'] }}</span>
                                    <h3 class="text-xl font-bold text-white">{{ $zone['name'] }}</h3>
                                    <span class="text-xs text-gray-400 font-medium block mt-1">Вместимость: {{ $zone['capacity'] }}</span>
                                </div>
                                <p class="text-gray-300 text-sm leading-relaxed">{{ $zone['description'] }}</p>
                            </div>
                            <button onclick="openBookingModalWithZone('{{ $zone['name'] }}')" class="mt-6 w-full py-2.5 rounded-xl border border-white/10 text-xs font-bold uppercase tracking-wider text-gray-300 hover:text-black hover:bg-[#e5c158] hover:border-[#e5c158] transition-all">
                                Забронировать зону
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Events Section -->
        <section id="events" class="py-24 px-4 sm:px-6 lg:px-8 relative">
            <div class="max-w-7xl mx-auto space-y-12">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-purple-400 glass-panel px-4 py-1.5 rounded-full">Афиша</span>
                        <h2 class="text-3xl sm:text-5xl font-extrabold text-white uppercase mt-4">Ближайшие события</h2>
                    </div>
                    <p class="text-gray-400 text-sm max-w-md">Каждую неделю у нас проходят живые сеты, квартирники, культурные маркеты и встречи с приглашенными гостями.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($events as $event)
                        <div class="glass-card rounded-3xl overflow-hidden flex flex-col justify-between group">
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ $event['image'] }}" alt="{{ $event['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#070709] via-transparent to-transparent"></div>
                                <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-black/60 backdrop-blur-md text-[#e5c158] border border-white/10">
                                    {{ $event['tag'] }}
                                </span>
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                                <div>
                                    <span class="text-xs text-purple-400 font-bold block mb-1">{{ $event['date'] }}</span>
                                    <h3 class="text-lg font-bold text-white group-hover:text-[#e5c158] transition-colors">{{ $event['title'] }}</h3>
                                    <p class="text-xs text-gray-400 mt-2 leading-relaxed">{{ $event['description'] }}</p>
                                </div>
                                <button onclick="openBookingModal()" class="w-full py-2 rounded-xl bg-white/5 hover:bg-[#e5c158] text-white hover:text-black font-semibold text-xs uppercase tracking-wider transition-all">
                                    Попасть на событие
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Menu Section (Interactive) -->
        <section id="menu" class="py-24 px-4 sm:px-6 lg:px-8 bg-black/50 relative">
            <div class="max-w-6xl mx-auto space-y-12">
                <div class="text-center space-y-4">
                    <span class="text-xs font-bold uppercase tracking-widest text-[#e5c158] glass-panel px-4 py-1.5 rounded-full">В нашем меню</span>
                    <h2 class="text-3xl sm:text-5xl font-extrabold text-white uppercase">Авторская Кухня & Бар</h2>
                    <p class="text-gray-400 text-sm max-w-xl mx-auto">Яркий гастрономический стиль smart-casual и миксология высочайшего уровня.</p>

                    <!-- Tab Switcher -->
                    <div class="inline-flex p-1.5 rounded-full glass-panel border border-white/10 mt-6">
                        <button id="tab-kitchen" onclick="switchMenu('kitchen')" class="px-8 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all bg-[#e5c158] text-black">
                            Меню Кухни
                        </button>
                        <button id="tab-bar" onclick="switchMenu('bar')" class="px-8 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all text-gray-400 hover:text-white">
                            Барная Карта
                        </button>
                    </div>
                </div>

                <!-- Kitchen Menu Grid -->
                <div id="menu-kitchen" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($menu['kitchen'] as $item)
                        <div class="glass-card p-6 rounded-2xl flex justify-between items-start gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-bold text-white">{{ $item['name'] }}</h3>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-purple-500/20 text-purple-300 border border-purple-500/30">{{ $item['tag'] }}</span>
                                </div>
                                <p class="text-xs text-gray-400 leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                            <span class="text-lg font-extrabold text-[#e5c158] whitespace-nowrap">{{ $item['price'] }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Bar Menu Grid (Hidden by default) -->
                <div id="menu-bar" class="grid grid-cols-1 md:grid-cols-2 gap-6 hidden">
                    @foreach($menu['bar'] as $item)
                        <div class="glass-card p-6 rounded-2xl flex justify-between items-start gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-bold text-white">{{ $item['name'] }}</h3>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-500/20 text-amber-300 border border-amber-500/30">{{ $item['tag'] }}</span>
                                </div>
                                <p class="text-xs text-gray-400 leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                            <span class="text-lg font-extrabold text-[#e5c158] whitespace-nowrap">{{ $item['price'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Loyalty Program (Орбитальность) -->
        <section id="loyalty" class="py-24 px-4 sm:px-6 lg:px-8 relative">
            <div class="max-w-7xl mx-auto">
                <div class="glass-panel p-8 sm:p-12 rounded-3xl border border-white/10 relative overflow-hidden bg-gradient-to-r from-purple-900/30 via-[#070709] to-amber-900/30">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center relative z-10">
                        <div class="space-y-6">
                            <span class="text-xs font-bold uppercase tracking-widest text-amber-400 glass-panel px-4 py-1.5 rounded-full">Бонусы & Привилегии</span>
                            <h2 class="text-3xl sm:text-5xl font-extrabold text-white uppercase leading-tight">
                                Система <br>
                                <span class="bg-gradient-to-r from-[#e5c158] to-purple-400 bg-clip-text text-transparent">Орбитальность</span>
                            </h2>
                            <p class="text-gray-300 text-sm sm:text-base leading-relaxed">
                                Набирай баллы и поднимайся по 4 уровням, открывая новые возможности: закрытые мероприятия, лимитированный мерч, скидки в баре и эксклюзивные приглашения.
                            </p>
                            <a href="https://t.me/orbitabar_bot" target="_blank" rel="noopener" class="inline-flex items-center gap-3 px-8 py-4 rounded-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-extrabold text-xs uppercase tracking-widest hover:opacity-90 shadow-xl transition-all transform hover:scale-105">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0zm5.56 8.16l-1.97 9.28c-.15.68-.55.84-1.12.52l-3.05-2.25-1.47 1.42c-.16.16-.3.3-.62.3l.22-3.11 5.66-5.11c.25-.22-.05-.34-.38-.12l-7 4.41-3.02-.95c-.66-.21-.67-.66.14-.98l11.8-4.55c.55-.2 1.03.13.84.94z"/></svg>
                                Зарегистрироваться в Telegram-боте
                            </a>
                        </div>

                        <!-- Level Badges -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-5 rounded-2xl glass-card border border-white/10 space-y-2">
                                <div class="w-8 h-8 rounded-full bg-gray-700/50 flex items-center justify-center font-bold text-xs text-gray-300">L1</div>
                                <h4 class="text-white font-bold text-sm">Спутник</h4>
                                <p class="text-[11px] text-gray-400">Приветственный бонус и кэшбэк 5% с первого визита.</p>
                            </div>
                            <div class="p-5 rounded-2xl glass-card border border-purple-500/30 space-y-2">
                                <div class="w-8 h-8 rounded-full bg-purple-600/30 flex items-center justify-center font-bold text-xs text-purple-300">L2</div>
                                <h4 class="text-white font-bold text-sm">Планета</h4>
                                <p class="text-[11px] text-gray-400">Кэшбэк 8%, коктейль в подарок в день рождения.</p>
                            </div>
                            <div class="p-5 rounded-2xl glass-card border border-pink-500/30 space-y-2">
                                <div class="w-8 h-8 rounded-full bg-pink-600/30 flex items-center justify-center font-bold text-xs text-pink-300">L3</div>
                                <h4 class="text-white font-bold text-sm">Созвездие</h4>
                                <p class="text-[11px] text-gray-400">Кэшбэк 12% + бронь депозитных столов без очереди.</p>
                            </div>
                            <div class="p-5 rounded-2xl glass-card border border-[#e5c158]/50 space-y-2">
                                <div class="w-8 h-8 rounded-full bg-[#e5c158]/30 flex items-center justify-center font-bold text-xs text-[#e5c158]">L4</div>
                                <h4 class="text-white font-bold text-sm">Галактика</h4>
                                <p class="text-[11px] text-gray-400">Кэшбэк 15%, доступ на секретные закрытые ивенты.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contacts & Location Map -->
        <section id="contacts" class="py-24 px-4 sm:px-6 lg:px-8 bg-black/60 relative">
            <div class="max-w-7xl mx-auto space-y-12">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Contact Details -->
                    <div class="space-y-6 lg:col-span-1">
                        <span class="text-xs font-bold uppercase tracking-widest text-[#e5c158] glass-panel px-4 py-1.5 rounded-full">Контакты</span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-white uppercase">Ждем вас в гости</h2>

                        <div class="space-y-4 text-sm text-gray-300">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-[#e5c158] shrink-0 mt-1">📍</div>
                                <div>
                                    <strong class="text-white block">Адрес:</strong>
                                    г. Москва, ул. Яузская 1/15<br>
                                    <span class="text-xs text-gray-400">м. Китай-город, м. Таганская</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-[#e5c158] shrink-0 mt-1">🕒</div>
                                <div>
                                    <strong class="text-white block">Время работы:</strong>
                                    Вс – Чт: 12:00 — 00:00<br>
                                    Пт – Сб: 12:00 — 03:00
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-[#e5c158] shrink-0 mt-1">📞</div>
                                <div>
                                    <strong class="text-white block">Телефон:</strong>
                                    <a href="tel:+74951410555" class="text-[#e5c158] hover:underline">+7 (495) 141-05-55</a>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-[#e5c158] shrink-0 mt-1">✉️</div>
                                <div>
                                    <strong class="text-white block">Email:</strong>
                                    <a href="mailto:orbita.yauza@gmail.com" class="text-gray-300 hover:text-white">orbita.yauza@gmail.com</a>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 flex gap-4">
                            <a href="https://yandex.ru/maps/org/orbita/200600732534/" target="_blank" rel="noopener" class="w-full py-3 rounded-2xl glass-card text-center text-xs font-bold uppercase tracking-wider text-[#e5c158] hover:bg-[#e5c158] hover:text-black transition-all">
                                Построить маршрут
                            </a>
                        </div>
                    </div>

                    <!-- Yandex Map Frame Mockup / Container -->
                    <div class="lg:col-span-2 rounded-3xl overflow-hidden glass-card border border-white/10 min-h-[350px] relative">
                        <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Aa51483f6d6e1bdd5fd51fccd95c1ec128ee72b0b3000d23fd9abd084b712a3df&amp;source=constructor" width="100%" height="100%" frameborder="0" class="min-h-[400px] w-full filter contrast-125"></iframe>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/10 py-12 px-4 sm:px-6 lg:px-8 bg-black/90 relative z-10 text-xs text-gray-500">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <span class="font-extrabold text-white text-lg tracking-widest">ОРБИТА</span>
                <span>© {{ date('Y') }} Все права защищены.</span>
            </div>
            <div class="flex gap-6">
                <a href="#about" class="hover:text-gray-300">О нас</a>
                <a href="#space" class="hover:text-gray-300">Залы</a>
                <a href="#menu" class="hover:text-gray-300">Меню</a>
                <a href="#contacts" class="hover:text-gray-300">Контакты</a>
            </div>
        </div>
    </footer>

    <!-- Booking Modal -->
    <div id="booking-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="glass-panel w-full max-w-lg rounded-3xl border border-white/10 p-6 sm:p-8 relative shadow-2xl transform scale-95 transition-transform duration-300" id="booking-modal-card">
            <button onclick="closeBookingModal()" class="absolute top-6 right-6 text-gray-400 hover:text-white text-xl font-bold">✕</button>

            <h3 class="text-2xl font-extrabold text-white uppercase mb-2">Бронирование стола</h3>
            <p class="text-xs text-gray-400 mb-6">Заполните форму, и мы оперативно подтвердим вашу бронь.</p>

            <form id="booking-form" onsubmit="submitBooking(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-300 mb-1">Ваше имя *</label>
                    <input type="text" name="name" required placeholder="Иван" class="w-full px-4 py-3 rounded-xl bg-black/50 border border-white/10 text-white text-sm focus:border-[#e5c158] focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-gray-300 mb-1">Телефон *</label>
                        <input type="tel" name="phone" required placeholder="+7 (999) 000-00-00" class="w-full px-4 py-3 rounded-xl bg-black/50 border border-white/10 text-white text-sm focus:border-[#e5c158] focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-gray-300 mb-1">Гости *</label>
                        <select name="guests" required class="w-full px-4 py-3 rounded-xl bg-black/50 border border-white/10 text-white text-sm focus:border-[#e5c158] focus:outline-none">
                            <option value="1">1 человек</option>
                            <option value="2" selected>2 человека</option>
                            <option value="3">3 человека</option>
                            <option value="4">4 человека</option>
                            <option value="5">5+ человек</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-gray-300 mb-1">Дата *</label>
                        <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 rounded-xl bg-black/50 border border-white/10 text-white text-sm focus:border-[#e5c158] focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-gray-300 mb-1">Время *</label>
                        <select name="time" required class="w-full px-4 py-3 rounded-xl bg-black/50 border border-white/10 text-white text-sm focus:border-[#e5c158] focus:outline-none">
                            <option value="12:00">12:00</option>
                            <option value="14:00">14:00</option>
                            <option value="16:00">16:00</option>
                            <option value="18:00">18:00</option>
                            <option value="20:00" selected>20:00</option>
                            <option value="22:00">22:00</option>
                            <option value="00:00">00:00</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-300 mb-1">Локация / Зона</label>
                    <select id="booking-zone-select" name="zone" class="w-full px-4 py-3 rounded-xl bg-black/50 border border-white/10 text-white text-sm focus:border-[#e5c158] focus:outline-none">
                        <option value="Главный Бар">Главный Бар</option>
                        <option value="Сцена & Танцпол">Сцена & Танцпол</option>
                        <option value="Каминная Гостиная">Каминная Гостиная</option>
                        <option value="Балконная Галерея">Балконная Галерея</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase text-gray-300 mb-1">Пожелания</label>
                    <textarea name="comment" rows="2" placeholder="Особые пожелания или поводы" class="w-full px-4 py-3 rounded-xl bg-black/50 border border-white/10 text-white text-sm focus:border-[#e5c158] focus:outline-none"></textarea>
                </div>

                <div id="booking-message" class="hidden text-xs p-3 rounded-xl font-medium"></div>

                <button type="submit" id="booking-submit-btn" class="w-full py-4 rounded-2xl bg-gradient-to-r from-[#e5c158] to-amber-500 text-black font-extrabold text-xs uppercase tracking-widest hover:opacity-90 transition-all">
                    Затвердить бронирование
                </button>
            </form>
        </div>
    </div>

    <!-- Frontend Interactive Logic Script -->
    <script>
        function switchMenu(category) {
            const kitchenEl = document.getElementById('menu-kitchen');
            const barEl = document.getElementById('menu-bar');
            const tabKitchen = document.getElementById('tab-kitchen');
            const tabBar = document.getElementById('tab-bar');

            if (category === 'kitchen') {
                kitchenEl.classList.remove('hidden');
                barEl.classList.add('hidden');
                tabKitchen.className = 'px-8 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all bg-[#e5c158] text-black';
                tabBar.className = 'px-8 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all text-gray-400 hover:text-white';
            } else {
                kitchenEl.classList.add('hidden');
                barEl.classList.remove('hidden');
                tabBar.className = 'px-8 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all bg-[#e5c158] text-black';
                tabKitchen.className = 'px-8 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all text-gray-400 hover:text-white';
            }
        }

        function openBookingModal() {
            const modal = document.getElementById('booking-modal');
            const card = document.getElementById('booking-modal-card');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }

        function openBookingModalWithZone(zoneName) {
            const select = document.getElementById('booking-zone-select');
            if (select) {
                for (let option of select.options) {
                    if (option.value === zoneName) {
                        option.selected = true;
                        break;
                    }
                }
            }
            openBookingModal();
        }

        function closeBookingModal() {
            const modal = document.getElementById('booking-modal');
            const card = document.getElementById('booking-modal-card');
            modal.classList.add('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
        }

        async function submitBooking(event) {
            event.preventDefault();
            const form = event.target;
            const submitBtn = document.getElementById('booking-submit-btn');
            const msgBox = document.getElementById('booking-message');

            submitBtn.disabled = true;
            submitBtn.innerText = 'ОТПРАВКА...';

            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('{{ route("bookings.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                msgBox.classList.remove('hidden', 'bg-red-500/20', 'text-red-300', 'bg-emerald-500/20', 'text-emerald-300');

                if (response.ok && result.success) {
                    msgBox.classList.add('bg-emerald-500/20', 'text-emerald-300');
                    msgBox.innerText = result.message;
                    form.reset();
                    setTimeout(() => {
                        closeBookingModal();
                        msgBox.classList.add('hidden');
                    }, 2500);
                } else {
                    msgBox.classList.add('bg-red-500/20', 'text-red-300');
                    msgBox.innerText = result.message || 'Ошибка бронирования. Проверьте введенные данные.';
                }
            } catch (err) {
                msgBox.classList.remove('hidden');
                msgBox.classList.add('bg-red-500/20', 'text-red-300');
                msgBox.innerText = 'Произошла ошибка при отправке. Попробуйте еще раз.';
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerText = 'ЗАТВЕРДИТЬ БРОНИРОВАНИЕ';
            }
        }
    </script>
</body>
</html>
