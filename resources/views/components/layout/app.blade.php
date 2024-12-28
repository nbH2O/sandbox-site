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
            <header class="text-[#ededf1] z-10 bg-[#19191c] h-12 shadow overflow-hidden px-40 flex justify-between">
                <div class="flex">
                    <img class="max-h-full p-2.5 me-4" src="https://web.archive.org/web/20230905100829im_/https://blog.brkcdn.com/2023/04/full_final_trademark_o--1-.png" />
                    <nav class="flex">
                        <x-one-off.header-link
                            title="{{ __('Games') }}"
                        />
                        <x-one-off.header-link
                            title="{{ __('Market') }}"
                        />
                        <x-one-off.header-link
                            title="{{ __('Members') }}"
                            active="true"
                        />
                    </nav>
                </div>
            </header>
            <main class="flex justify-center min-h-full my-8">
                {{ $slot }}
            </main>
        </div>
        <footer class="bg-[#19191c] h-56">
            hi
        </footer>
    </body>
</html>
