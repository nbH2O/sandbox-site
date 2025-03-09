@php
    $content = [
        0 => [
            'color' => 'green',
            'title' => __('Create Your Unique Identity'),
            'message' => __('Design your perfect avatar with endless customization options. Mix and match outfits, accessories, and styles to stand out—your look, your way!'),
            'image' => url('images/brand/economy.png'),
            'link' => [
                'href' => url('market'),
                'text' => __('View Market')
            ]
        ],
        1 => [
            'color' => 'primary',
            'title' => __('Trade, Collect, and Build Your Fortune'),
            'message' => __('Discover a dynamic player-driven economy where you can buy, sell, and trade unique items. Find rare collectibles, strike the best deals, and climb the ranks of the marketplace!'),
            'image' => url('images/brand/economy.png'),
            'link' => [
                'href' => url('market'),
                'text' => __('View Market')
            ]
        ],
        2 => [
            'color' => 'yellow',
            'title' => __('Meet, Chat, and Connect'),
            'message' => __('Join a vibrant community where players come together to socialize, trade, and express themselves. Make new friends, chat in real time, and shape the world with your creativity!'),
            'image' => url('images/brand/economy.png'),
            'link' => [
                'href' => url('members'),
                'text' => __('View Members')
            ]
        ]
    ];
@endphp

<!doctype HTML>
<html class="dark" style="color-scheme: dark;">
    <head>
        <!-- Basic Meta Tags -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="title" content="Lunoba">
        <meta name="description" content="Participate!">
        <meta name="keywords" content="Lunoba, participate, community, engagement, events">
        <meta name="author" content="Lunoba">
        <meta name="robots" content="index, follow">

        <!-- Open Graph (Facebook, LinkedIn, etc.) -->
        <meta property="og:title" content="Lunoba">
        <meta property="og:description" content="Participate!">
        <!--<meta property="og:image" content="https://lunoba.com/og-image.jpg">-->
        <meta property="og:url" content="https://lunoba.com">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Lunoba">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Lunoba">
        <meta name="twitter:description" content="Participate!">
        <!--<meta name="twitter:image" content="https://lunoba.com/twitter-image.jpg">-->
        <meta name="twitter:site" content="@Lunoba">
        
        <!-- Favicon -->
        <link rel="icon" href="https://lunoba.com/favicon.ico" type="image/x-icon">

        <!-- Canonical URL -->
        <link rel="canonical" href="https://lunoba.com">

        <title>Lunoba</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=montserrat:600,700,800" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            #heroSection {
                background-image: url("{{ url('images/brand/hero.png') }}");
                background-repeat: no-repeat;
                background-position: bottom;
                background-size: contain;
            }
        </style>
    </head>
    <body class="bg-body overflow-x-hidden">
        <div id="heroSection" class="bg-[#01acff]">
            <div class="w-full h-screen flex flex-col  px-3 md:px-10 py-3 md:py-4 bg-gradient-to-b from-black/20 to-10% to-transparent">
                <header class="flex justify-between h-10 items-center">
                    <img src="/images/logo/large.png" class="h-full" />
                    <x-button href="{{ route('login') }}" class="font-black" color="transparent" size="lg">
                        @svg('ri-login-box-fill', [
                            'class' => 'size-6 me-2 mb-0.5'
                        ])
                        {{__('Log in') }}
                    </x-button>
                </header>
                <main class="grow flex gap-10  md:items-center w-full">
                    <div class="basis-full flex flex-col justify-center md:justify-start gap-4 md:basis-1/2">
                        <h1 class="text-5xl md:text-6xl">{{ __('Express Yourself, Connect, and Trade Freely!') }}</h1>
                        <p class="text-lg">
                            {{ __('Customize your avatar with endless possibilities, meet new friends, and dive into a thriving player-driven economy.') }}
                            {{ __('Trade, collect, and express your style—your journey starts here!') }}
                        </p>
                        <div class="flex">
                            <x-button href="{{ route('register') }}" size="xl" class="bg-white text-[#01acff] font-black">
                                @svg('ri-user-5-fill', [
                                    'class' => 'size-7 me-3 -ms-1.5 mb-0.5'
                                ])
                                {{ __('Join') }}
                            </x-button> 
                        </div>
                    </div>
                </main>
                <div class="flex justify-center py-2">
                    @svg('ri-arrow-down-s-fill', [
                        'class' => 'size-10'
                    ])
                </div>
            </div>
        </div>
        <div class="px-3 py-8 md:px-10 md:py-12 flex flex-col gap-12">
            @foreach($content as $c)
                <div class="flex flex-col md:flex-row gap-10">
                    <div class="basis-full md:basis-1/2 md:order-1 h-96 bg-{{ $c['color'] ?? 'header' }}">
                        <img class="w-full" src="{{ $c['image'] }}" >
                    </div>
                    <div class="basis-full md:basis-1/2 flex flex-col justify-between gap-4">
                        <div class="flex flex-col gap-4">
                            <h3>{{ $c['title'] }}</h3>
                            <p>{{ $c['message'] }}</p>
                        </div>
                        <div class="flex">
                            <x-button href="{{ $c['link']['href'] }}">{{ $c['link']['text'] }}</x-button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="h-96 flex flex-col items-center justify-center text-center">
            <h2 class="mb-10">{{ __('Ready to get started?') }}</h2>
            <x-button href="{{ route('register') }}" color="green" size="lg">
                @svg('ri-user-5-fill', [
                    'class' => 'size-6 me-2 -ms-1 mb-0.5'
                ])
                {{ __('Join') }}
            </x-button>
        </div>
    </body>
</html>