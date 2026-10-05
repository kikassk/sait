<!DOCTYPE html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ОРБИТА — Гастрономия & Миксология | Меню</title>
    <meta name="description" content="Полное меню фэнси-бара ОРБИТА: авторские коктейли, фьюжн тапас, классика и безалкогольные эликсиры.">

    <!-- Premium Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Unbounded:wght@400;600;700;800;900&family=JetBrains+Mono:wght@300;400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-color: #050508;
            --card-border: rgba(255, 255, 255, 0.08);
            --card-bg: linear-gradient(135deg, rgba(20, 20, 26, 0.85) 0%, rgba(10, 10, 14, 0.95) 100%);
            --headline-gradient: linear-gradient(135deg, #ffffff 0%, #a1a1aa 50%, #52525b 100%);
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-color);
            color: #f4f4f5;
            overflow-x: hidden;
            letter-spacing: -0.01em;
        }

        .font-display { font-family: 'Unbounded', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        .art-card-glass {
            background: var(--card-bg);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid var(--card-border);
            border-radius: 2rem;
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.8);
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .art-card-glass:hover {
            border-color: rgba(255, 255, 255, 0.22);
            transform: translateY(-4px);
            box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.95);
        }

        .art-card-pill {
            background: rgba(18, 18, 24, 0.88);
            backdrop-filter: blur(28px);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 9999px;
        }

        .art-button-primary {
            background: linear-gradient(135deg, #ffffff 0%, #e4e4e7 100%);
            color: #09090b;
            font-weight: 700;
            border-radius: 9999px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            letter-spacing: 0.05em;
        }

        .art-button-primary:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 14px 35px rgba(255, 255, 255, 0.28);
        }

        .gradient-headline {
            background: var(--headline-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .icon-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.85rem;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.14);
            color: #f4f4f5;
        }
    </style>
</head>
<body class="relative text-zinc-100 antialiased selection:bg-zinc-800 selection:text-white min-h-screen flex flex-col justify-between">

    <!-- Background Ambient Glow -->
    <div class="fixed w-[700px] h-[700px] rounded-full bg-zinc-800/15 top-[-100px] left-1/2 -translate-x-1/2 blur-[150px] pointer-events-none z-0"></div>

    <!-- FLOATING NAVIGATION BAR -->
    <header class="fixed top-6 inset-x-0 z-50 flex justify-center px-4">
        <nav class="art-card-pill px-6 sm:px-8 py-3.5 flex items-center justify-between gap-6 max-w-6xl w-full shadow-2xl">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-3.5 group">
                <div class="w-10 h-10 rounded-2xl bg-zinc-900/90 border border-zinc-700/80 flex items-center justify-center transition-transform group-hover:scale-105">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9" stroke-dasharray="2 2"/>
                        <circle cx="12" cy="12" r="4" fill="currentColor"/>
                    </svg>
                </div>
                <div>
                    <span class="font-display font-extrabold text-xl tracking-wider text-white block leading-none">ОРБИТА</span>
                    <span class="text-[9px] text-zinc-400 tracking-widest uppercase mt-0.5 block font-mono">Яузская 1/15</span>
                </div>
            </a>

            <!-- Navigation Action -->
            <div class="flex items-center gap-4">
                <a href="/" class="text-xs font-mono text-zinc-300 hover:text-white transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Главная</span>
                </a>

                <button onclick="openBookingModal()" class="art-button-primary px-6 py-2.5 text-xs font-bold uppercase tracking-wider cursor-pointer">
                    Забронировать стол
                </button>
            </div>
        </nav>
    </header>

    <!-- MAIN CONTENT -->
    <main class="relative z-10 pt-36 pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-16 flex-grow w-full">

        <!-- HEADER SECTION -->
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-zinc-900/90 border border-zinc-700/80 text-xs font-mono text-emerald-400 uppercase tracking-widest">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span>GASTRONOMY & MIXOLOGY MENU</span>
            </div>
            <h1 class="font-display text-4xl sm:text-6xl font-black text-white tracking-tight">
                МЕНЮ <span class="gradient-headline">ОРБИТА</span>
            </h1>
            <p class="text-zinc-400 text-sm sm:text-base leading-relaxed">
                Инновационная миксология, локальные ингредиенты и авторская кухня в историческом особняке XVIII века.
            </p>
        </div>

        <!-- FILTER & SEARCH BAR -->
        <div class="art-card-glass p-4 sm:p-6 flex flex-col md:flex-row items-center justify-between gap-4 max-w-5xl mx-auto">
            <!-- Category Tabs -->
            <div class="flex flex-wrap items-center justify-center gap-2 w-full md:w-auto">
                <button onclick="filterCategory('all')" id="tab-all" class="category-tab px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider bg-white text-zinc-950 transition-all cursor-pointer">
                    Все позиции
                </button>
                <button onclick="filterCategory('author-cocktails')" id="tab-author-cocktails" class="category-tab px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white transition-all cursor-pointer">
                    Миксология
                </button>
                <button onclick="filterCategory('gastronomy')" id="tab-gastronomy" class="category-tab px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white transition-all cursor-pointer">
                    Гастрономия
                </button>
                <button onclick="filterCategory('zero-proof')" id="tab-zero-proof" class="category-tab px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white transition-all cursor-pointer">
                    Zero Proof (0%)
                </button>
            </div>

            <!-- Live Search Input -->
            <div class="relative w-full md:w-72">
                <input type="text" id="menu-search" oninput="searchMenu()" placeholder="Поиск блюда или ингредиента..." class="w-full bg-zinc-900/90 border border-zinc-800 rounded-full px-4 py-2.5 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-zinc-500 transition-colors pl-9">
                <svg class="w-4 h-4 text-zinc-500 absolute left-3 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>

        <!-- CATEGORIES GRID -->
        <div id="menu-sections-container" class="space-y-20">
            @foreach($categories as $catKey => $category)
                <section id="category-{{ $catKey }}" class="menu-category-block space-y-8">
                    <div class="flex items-center justify-between border-b border-zinc-800/80 pb-4">
                        <div>
                            <span class="px-3 py-1 rounded-full text-[10px] font-mono bg-zinc-800 text-zinc-300 border border-zinc-700 uppercase tracking-widest">{{ $category['badge'] }}</span>
                            <h2 class="font-display text-2xl sm:text-3xl font-extrabold text-white mt-2">{{ $category['title'] }}</h2>
                            <p class="text-xs text-zinc-400 mt-1 font-mono">{{ $category['subtitle'] }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                        @foreach($category['items'] as $item)
                            <div class="menu-item-card art-card-glass overflow-hidden flex flex-col sm:flex-row justify-between group" data-name="{{ mb_strtolower($item['name']) }}" data-desc="{{ mb_strtolower($item['desc']) }}">

                                <!-- Card Image -->
                                @if(isset($item['image']))
                                    <div class="sm:w-2/5 h-48 sm:h-auto relative overflow-hidden shrink-0">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        <div class="absolute inset-0 bg-gradient-to-t sm:bg-gradient-to-r from-transparent via-transparent to-zinc-950/80"></div>
                                    </div>
                                @endif

                                <!-- Card Content -->
                                <div class="p-6 sm:p-8 flex-grow flex flex-col justify-between space-y-4">
                                    <div>
                                        <div class="flex items-start justify-between gap-3 mb-2">
                                            <h3 class="font-display text-lg font-bold text-white group-hover:text-emerald-400 transition-colors">{{ $item['name'] }}</h3>
                                            <span class="font-mono font-extrabold text-base text-white shrink-0 bg-zinc-900 px-3 py-1 rounded-full border border-zinc-800">{{ $item['price'] }}</span>
                                        </div>

                                        <p class="text-xs text-zinc-400 leading-relaxed">{{ $item['desc'] }}</p>
                                    </div>

                                    <div class="space-y-3 pt-3 border-t border-zinc-800/80">
                                        <!-- Tags & Volume/Weight -->
                                        <div class="flex items-center justify-between text-[11px] font-mono text-zinc-400">
                                            <div class="flex items-center gap-1.5 flex-wrap">
                                                @foreach($item['tags'] as $tag)
                                                    <span class="px-2.5 py-0.5 rounded-full bg-zinc-800/80 text-zinc-300 border border-zinc-700/60">{{ $tag }}</span>
                                                @endforeach
                                            </div>
                                            <span class="text-zinc-500 font-bold shrink-0">{{ $item['volume'] ?? $item['weight'] ?? '' }}</span>
                                        </div>

                                        <!-- Flavor Profile Pills -->
                                        @if(isset($item['profile']))
                                            <div class="flex items-center gap-3 pt-1">
                                                @foreach($item['profile'] as $profName => $profValue)
                                                    <div class="flex items-center gap-1.5 text-[10px] font-mono text-zinc-400">
                                                        <span>{{ $profName }}:</span>
                                                        <div class="w-12 h-1.5 bg-zinc-800 rounded-full overflow-hidden">
                                                            <div class="h-full bg-white rounded-full" style="width: {{ $profValue }}%"></div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="border-t border-zinc-900 bg-zinc-950 py-12 relative z-10 mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-1 text-center md:text-left">
                <span class="font-display font-black text-xl text-white">ОРБИТА</span>
                <p class="text-xs text-zinc-500">Гастрономия & Авторская Миксология // Москва, Яузская 1/15</p>
            </div>
            <a href="/" class="text-xs font-mono text-zinc-400 hover:text-white transition-colors">← Вернуться на главную страницу</a>
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

    <!-- JAVASCRIPT -->
    <script>
        document.getElementById('book-date').value = new Date().toISOString().split('T')[0];

        function filterCategory(catKey) {
            const sections = document.querySelectorAll('.menu-category-block');
            const tabs = document.querySelectorAll('.category-tab');

            tabs.forEach(tab => {
                tab.className = 'category-tab px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider bg-zinc-900 border border-zinc-800 text-zinc-400 hover:text-white transition-all cursor-pointer';
            });

            const activeTab = document.getElementById(`tab-${catKey}`);
            if (activeTab) {
                activeTab.className = 'category-tab px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider bg-white text-zinc-950 transition-all cursor-pointer';
            }

            sections.forEach(sec => {
                if (catKey === 'all' || sec.id === `category-${catKey}`) {
                    sec.style.display = 'block';
                } else {
                    sec.style.display = 'none';
                }
            });
        }

        function searchMenu() {
            const query = document.getElementById('menu-search').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.menu-item-card');

            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const desc = card.getAttribute('data-desc') || '';
                if (name.includes(query) || desc.includes(query)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function openBookingModal() {
            document.getElementById('booking-modal').classList.remove('hidden');
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
    </script>
</body>
</html>
