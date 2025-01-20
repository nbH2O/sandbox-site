@props([
    'title' => null,
    'pageTitle' => false, // show title in page on top??
    'containerClass' => null, // inside main
    'actions' => null
])

<!DOCTYPE html>
<html lang="en" class="{{ Auth::user() ? (Auth::user()->theme == 1 ? 'light' : 'dark' ) : 'dark' }}">
    <head>
        <meta charset="UTF-8" />
        <link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=montserrat:600,700,800" rel="stylesheet" />
        <title>{{ $title }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="overflow-x-hidden bg-body text-[#222226] dark:text-[#ededf1]" style="font-family: 'Montserrat', sans-serif;">
        @if (session('userRewarded') !== null)
            <x-modal
                title="{{ __('Daily Reward') }}"
            >
                @if (session('userRewarded') == true)
                    <p>
                        {{ __('You have recieved your daily reward of') }}
                        &nbsp;
                        <span class="font-bold text-primary flex items-center">
                            @svg('ri-vip-diamond-fill', [
                                'class' => 'size-5'
                            ])
                            <span class="ms-1.5 text-lg">2</span>
                        </span>
                    </p>

                    <x-slot name="actions">
                        <x-button x-on:click="open = false" color="green">
                            {{ __('Nice') }}
                        </x-button>
                    </x-slot>
                @else
                    @php
                        // prevent failure prompts until re-login
                        // or until success! yipee
                        session(['userRewardFailed' => now()->toString()]);
                        // put here so user for sure got popup
                    @endphp
                    <p>
                        {{ __("You're email isn't verified!") }}
                    </p>
                    <p class="mt-1">
                        {{ __("If you want to recieve today's daily reward, please verify your email.") }}
                    </p>
                    
                    <x-slot name="actions">
                        <x-button x-on:click="open = false" color="red">
                            {{ __("I won't") }}
                        </x-button>
                        <x-button x-on:click="open = false" color="green">
                            {{ __('I will') }}
                        </x-button>
                    </x-slot>
                @endif
            </x-modal>
        @endif
        <div class="min-h-screen">
            @livewire('header')
            <main class="flex justify-center min-h-full mb-8 {{ $pageTitle && $title ? 'mt-8' : 'mt-12' }} px-3">
                <div class="max-w-full {{ $containerClass }}">
                    @if ($pageTitle && $title)
                        <div class="flex justify-between items-center mb-8">
                            <h2 class="uppercase font-black">{{ $title }}</h2>
                            <div class="flex gap-4">
                                {{ $actions }}
                            </div>
                        </div>
                    @endif
                    <div>
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
        <footer class="px-4 bg-neutral-950/10 dark:bg-black/20 h-44 flex justify-center">
            <div class="max-w-full w-[70rem] flex items-center">
                <div class="basis-3/12">
                    <span class="text-muted">
                        &copy;
                        2023 &mdash; {{ date('Y') }}
                    </span>
                </div>
                <div class="flex gap-4">
                    thej
                </div>
            </div>
        </footer>
    </body>
</html>
