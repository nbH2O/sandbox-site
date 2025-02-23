@props([
    'code' => null,
    'title' => null,
    'message' => null
])

<!DOCTYPE html>
<html lang="en" class="dark">
    <head>
        <meta charset="UTF-8" />
        <link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=montserrat:600,700,800" rel="stylesheet" />
        <title>{{ $title }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="bg-body text-body">
        <div class="m-auto py-24 max-w-full w-[40rem]">
            <h1>{{ $code }}</h1>
            <h5>{{ $title }}</h5>
            <p>{{ $message }}</p>
        </div>
    </body>
</html>