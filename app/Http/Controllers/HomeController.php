<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $events = [
            [
                'title' => 'Джем с молодыми артистами',
                'date' => 'Пятница, 21:00',
                'category' => 'Музыка',
                'description' => 'Живой звук, импровизации и новые голоса сцены в теплой атмосфере нашей гостиной.',
                'tag' => 'Live Sound',
                'image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'Ночной сет: Orbital Beats',
                'date' => 'Суббота, 23:00',
                'category' => 'Вечеринка',
                'description' => 'Танцы до утра под актуальный электронный звук от резидентов проекта.',
                'tag' => 'Night Party',
                'image' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'Джаз & Авторские Коктейли',
                'date' => 'Воскресенье, 19:00',
                'category' => 'Вечер',
                'description' => 'Уютный камерный вечер с классическими и авторскими коктейлями от наших шеф-барменов.',
                'tag' => 'Atmosphere',
                'image' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'Творческий Маркет & Коворкинг',
                'date' => 'Четверг, 14:00',
                'category' => 'Днем',
                'description' => 'Встреча креаторов, просмотр новинок локальных брендов и свежесваренный спешелти кофе.',
                'tag' => 'Daytime',
                'image' => 'https://images.unsplash.com/photo-1527192491265-7e15c55b1ed2?auto=format&fit=crop&w=800&q=80'
            ]
        ];

        $zones = [
            [
                'id' => 'main-bar',
                'name' => 'Главный Бар',
                'capacity' => 'до 50 гостей',
                'description' => 'Сердце пространства с динамической подсветкой, контактной стойкой и лучшими авторскими миксами.',
                'badge' => 'Актвный ритм',
                'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1'
            ],
            [
                'id' => 'stage',
                'name' => 'Сцена & Танцпол',
                'capacity' => 'до 80 гостей',
                'description' => 'Пространство с качественным звуком, живыми выступлениями, джемами и ночными сетами артистов.',
                'badge' => 'Живой звук',
                'icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3'
            ],
            [
                'id' => 'fireplace',
                'name' => 'Каминная Гостиная',
                'capacity' => 'до 20 гостей',
                'description' => 'Уютный мягкий уголок с теплой подсветкой для романтических вечеров и задушевных разговоров.',
                'badge' => 'Chilled & Cozy',
                'icon' => 'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z'
            ],
            [
                'id' => 'gallery',
                'name' => 'Балконная Галерея',
                'capacity' => 'до 25 гостей',
                'description' => 'Панорамный вид на весь особняк сверху. Прекрасный выбор для камерных банкетов и праздников.',
                'badge' => 'VIP View',
                'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z'
            ]
        ];

        $loyaltyTiers = [
            ['tier' => 'Спутник', 'cashback' => '5%', 'condition' => 'До 20 000 ₽ / мес', 'perk' => 'Приветственный коктейль'],
            ['tier' => 'Орбита', 'cashback' => '10%', 'condition' => 'От 20 000 ₽ / мес', 'perk' => 'Приоритет бронирования'],
            ['tier' => 'Невесомость', 'cashback' => '15%', 'condition' => 'От 50 000 ₽ / мес', 'perk' => 'Закрытые VIP ивенты & Персональный менеджер'],
        ];

        $menu = [
            'kitchen' => [
                [
                    'name' => 'Роти с креветкой и трюфелем',
                    'price' => '890 ₽',
                    'desc' => 'Хрустящий хэнд-мейд роти, тигровые креветки, трюфельный крем и свежие травы.',
                    'tag' => 'Хит'
                ],
                [
                    'name' => 'Кампанелли с говядиной',
                    'price' => '940 ₽',
                    'desc' => 'Паста собственного приготовления, томленая рваная говядина в сливочном соусе пулькоги.',
                    'tag' => 'Chef special'
                ],
                [
                    'name' => 'Кацу Сандо с креветками',
                    'price' => '780 ₽',
                    'desc' => 'Японский сэндвич на молочном хлебе с хрустящей котлетой из сочных сочных креветок.',
                    'tag' => 'Smart casual'
                ],
                [
                    'name' => 'Зеленый салат с авокадо',
                    'price' => '650 ₽',
                    'desc' => 'Микс азиатской зелени, спелое авокадо, цукини и домашний заправка из йогурта и лайма.',
                    'tag' => 'Light'
                ],
                [
                    'name' => 'Куриный шницель с пюре из батата',
                    'price' => '820 ₽',
                    'desc' => 'Золотистая панировка, нежное филе, шелковистое пюре из батата и пряное масло.',
                    'tag' => 'Main'
                ],
                [
                    'name' => 'Чизкейк Сан-Себастьян с черникой',
                    'price' => '580 ₽',
                    'desc' => 'Нежнейшая опаленная текстура с черничным кули и ванильным кремом.',
                    'tag' => 'Dessert'
                ],
            ],
            'bar' => [
                [
                    'name' => 'Орбита T-15',
                    'price' => '850 ₽',
                    'desc' => 'Джин на цветках анчана, кордиал из белого персика, игристое, легкое свечение.',
                    'tag' => 'Signature'
                ],
                [
                    'name' => 'Яузский Бульвар',
                    'price' => '820 ₽',
                    'desc' => 'Бурбон, выдержанный на какао-нибсах, красный вермут, ликер амаро и апельсиновая цедра.',
                    'tag' => 'Strong & Rich'
                ],
                [
                    'name' => 'Лимонад Брусника / Те Гуань Инь',
                    'price' => '450 ₽',
                    'desc' => 'Свежая таежная брусника, китайский улун Те Гуань Инь, натуральный сок лайма.',
                    'tag' => 'Non-Alcoholic'
                ],
                [
                    'name' => 'Лимонад Ананас / Личи / Чили',
                    'price' => '450 ₽',
                    'desc' => 'Тропический ананас, нежный личи и согревающая нотка острого перца чили.',
                    'tag' => 'Fresh'
                ],
                [
                    'name' => 'Матча-Тоник Тропик',
                    'price' => '490 ₽',
                    'desc' => 'Премиальный зеленый чай матча, эссенция маракуйи и крафтовый тоник.',
                    'tag' => 'Energy'
                ],
            ]
        ];

        return view('welcome', compact('events', 'zones', 'menu', 'loyaltyTiers'));
    }

    public function menu()
    {
        $categories = [
            'author-cocktails' => [
                'title' => 'Авторская Миксология',
                'subtitle' => 'Футуристические коктейли на основе локальных ботаникалов и редких дистиллятов',
                'badge' => 'Orbita Mixology Lab',
                'items' => [
                    [
                        'name' => 'Орбита T-15 Kinetic',
                        'volume' => '140 мл',
                        'price' => '950 ₽',
                        'tags' => ['Signature', 'Luminescent'],
                        'desc' => 'Джин на цветках анчана, кордиал из белого персика, игристое, легкая фруктовая кислинка.',
                        'profile' => ['Свежесть' => 90, 'Крепость' => 60, 'Сладость' => 45],
                        'image' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Яузский Негрони 2.0',
                        'volume' => '110 мл',
                        'price' => '890 ₽',
                        'tags' => ['Bittersweet', 'Barrel Aged'],
                        'desc' => 'Выдержанный джин на лимоннике, дубовый амаро, вермут на таежных ягодах и цедра апельсина.',
                        'profile' => ['Свежесть' => 40, 'Крепость' => 85, 'Сладость' => 50],
                        'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Квантовый Эликсир',
                        'volume' => '150 мл',
                        'price' => '920 ₽',
                        'tags' => ['Molecular', 'Citrus'],
                        'desc' => 'Текила инфьюз с лемонграссом, каффир-лайм, кокосовая вода и дымная икра из мескаля.',
                        'profile' => ['Свежесть' => 95, 'Крепость' => 70, 'Сладость' => 30],
                        'image' => 'https://images.unsplash.com/photo-1536935338788-846bb9981813?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Черная Дыра (Black Hole)',
                        'volume' => '120 мл',
                        'price' => '880 ₽',
                        'tags' => ['Strong', 'Smoky'],
                        'desc' => 'Торфяной виски, черничный кордиал, растительный уголь, ликер из черной смородины.',
                        'profile' => ['Свежесть' => 30, 'Крепость' => 90, 'Сладость' => 40],
                        'image' => 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?auto=format&fit=crop&w=800&q=80'
                    ]
                ]
            ],
            'gastronomy' => [
                'title' => 'Гастрономия & Авторские Тапас',
                'subtitle' => 'Блюда в стиле азиатского фьюжн и европейского модерна',
                'badge' => 'Chef Kitchen',
                'items' => [
                    [
                        'name' => 'Роти с тигровой креветкой и трюфелем',
                        'weight' => '210 г',
                        'price' => '890 ₽',
                        'tags' => ['Хит', 'Seafood'],
                        'desc' => 'Хрустящий хэнд-мейд роти, тигровые креветки, трюфельный крем, кинза и соус понзу.',
                        'profile' => ['Сытность' => 75, 'Пряность' => 50],
                        'image' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Кампанелли с томленой говядиной',
                        'weight' => '320 г',
                        'price' => '940 ₽',
                        'tags' => ['Chef Special', 'Warm'],
                        'desc' => 'Домашняя паста кампанелли, рваная говяжья грудинка в соусе пулькоги и пармезан.',
                        'profile' => ['Сытность' => 95, 'Пряность' => 60],
                        'image' => 'https://images.unsplash.com/photo-1621996346565-e3def6164286?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Кацу Сандо с хрустящей креветкой',
                        'weight' => '240 г',
                        'price' => '780 ₽',
                        'tags' => ['Street Gourmet'],
                        'desc' => 'Японский молочный хлеб, сочная котлета из тигровых креветок, капустный слау и соус тонкацу.',
                        'profile' => ['Сытность' => 80, 'Пряность' => 40],
                        'image' => 'https://images.unsplash.com/photo-1509722747041-616f39b57569?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Тартар из тунца с авокадо и юдзу',
                        'weight' => '180 г',
                        'price' => '850 ₽',
                        'tags' => ['Raw & Fresh'],
                        'desc' => 'Дикий желтоперый тунец, спелое авокадо, икра тобико, заправка из сока юдзу и кунжутного масла.',
                        'profile' => ['Сытность' => 50, 'Пряность' => 30],
                        'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80'
                    ]
                ]
            ],
            'zero-proof' => [
                'title' => 'Безалкогольные Эликсиры',
                'subtitle' => 'Освежающие авторские лимонады, тоники и чайные настои',
                'badge' => 'Zero Proof / 0.0%',
                'items' => [
                    [
                        'name' => 'Брусника / Те Гуань Инь',
                        'volume' => '350 мл',
                        'price' => '450 ₽',
                        'tags' => ['Organic', 'Refreshing'],
                        'desc' => 'Свежая таежная брусника, элитный улун Те Гуань Инь, натуральный сок лайма и мята.',
                        'profile' => ['Свежесть' => 100, 'Сладость' => 35],
                        'image' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Ананас / Личи / Чили',
                        'volume' => '350 мл',
                        'price' => '450 ₽',
                        'tags' => ['Exotic Spice'],
                        'desc' => 'Сочный ананас, пюре из плодов личи и едва уловимая согревающая искорка перца чили.',
                        'profile' => ['Свежесть' => 85, 'Сладость' => 60],
                        'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?auto=format&fit=crop&w=800&q=80'
                    ],
                    [
                        'name' => 'Матча-Тоник Тропик',
                        'volume' => '300 мл',
                        'price' => '490 ₽',
                        'tags' => ['Superfood', 'Energy'],
                        'desc' => 'Японский церемониальный чай матча, маракуйя и крафтовый тоник с бодрящими пузырьками.',
                        'profile' => ['Свежесть' => 90, 'Сладость' => 40],
                        'image' => 'https://images.unsplash.com/photo-1536935338788-846bb9981813?auto=format&fit=crop&w=800&q=80'
                    ]
                ]
            ]
        ];

        return view('menu', compact('categories'));
    }

    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|string',
            'guests' => 'required|integer|min:1|max:20',
            'zone' => 'required|string',
            'comment' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ваш стол успешно забронирован! Наш менеджер свяжется с вами для подтверждения.',
            'booking' => $booking
        ]);
    }
}
