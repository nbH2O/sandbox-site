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
            @livewire('header')
            <main class="flex justify-center min-h-full my-8 px-3">
                {{ $slot }}
            </main>
        </div>
        <footer class="bg-[#19191c] h-56">
            hi
        </footer>
    </body>
</html>
