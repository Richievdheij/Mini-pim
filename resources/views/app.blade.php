<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Cookiebot Script -->
    <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js"
            data-cbid="eb5a8a84-458d-49ac-ba40-eee70b46fe14"
            data-blockingmode="auto"
            type="text/javascript"></script>

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', 'resources/sass/app.scss', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<body class="font-sans antialiased">
@inertia
</body>
</html>
