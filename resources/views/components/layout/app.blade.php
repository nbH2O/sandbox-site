<!DOCTYPE html>
<html lang="en" class="dark">
    <head>
        <meta charset="UTF-8" />
        <link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=montserrat:500,600,700,800" rel="stylesheet" />
        <title>Title</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="bg-body text-[#222226] dark:text-[#ededf1]" style="font-family: 'Montserrat', sans-serif;">
        <div class="min-h-screen">
            <header class="text-[#ededf1] z-10 bg-[#19191c] h-12 shadow px-2 overflow-hidden flex">
                <div class="flex justify-between max-w-full w-[70rem] mx-auto">
                    <div class="flex">
                        <img class="max-h-full p-2.5 me-4" src="https://web.archive.org/web/20230905100829im_/https://blog.brkcdn.com/2023/04/full_final_trademark_o--1-.png" />
                        <nav class="flex">
                            <x-one-off.header.link
                                title="{{ __('Worlds') }}"
                                icon="ri-planet-fill"
                                href="{{ route('worlds') }}"
                            />
                            <x-one-off.header.link
                                title="{{ __('Market') }}"
                                icon="ri-shopping-basket-fill"
                                href="{{ route('market') }}"
                            />
                            <x-one-off.header.link
                                title="{{ __('Members') }}"
                                icon="ri-user-5-fill"
                                href="{{ route('members') }}"
                                active="true"
                            />
                        </nav>
                    </div>
                    
                        @if (Auth::user())
                        @else
                            <div class="flex items-center gap-2">
                                <x-one-off.header.badged-icon 
                                    icon="ri-chat-4-line"
                                    label="hi"
                                    badgeColor="red"
                                />
                                <x-one-off.header.badged-icon 
                                    icon="ri-notification-2-line"
                                    label="77"
                                    badgeColor="red"
                                />
                                <x-button color="blue" size="sm" outerClass="w-9">
                                    <x-ri-login-box-line class="size-5" />
                                </x-button>
                                <x-button color="primary" size="sm" class="flex gap-1.5" outerClass="group">
                                    <x-ri-user-5-line class="-ms-1.5 size-5 group-hover:animate-bounce" />
                                    <span class="font-bold">{{ __('Join') }}</span>
                                </x-button>
                            </div>
                        @endif
    
                </div>
            </header>
            <main class="flex justify-center min-h-full my-8 px-3">
                {{ $slot }}
            </main>
        </div>
        <footer class="bg-[#19191c] h-56">
            hi
        </footer>
    </body>
</html>
