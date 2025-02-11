<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Google Consent Mode -->
    <script data-cookieconsent="ignore">
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("consent", "default", {
            ad_personalization: "denied",
            ad_storage: "denied",
            ad_user_data: "denied",
            analytics_storage: "denied",
            functionality_storage: "denied",
            personalization_storage: "denied",
            security_storage: "granted",
            wait_for_update: 500,
        });
        gtag("set", "ads_data_redaction", true);
        gtag("set", "url_passthrough", false);
    </script>

    <!-- Cookiebot Script -->
    <script
        id="Cookiebot"
        src="https://consent.cookiebot.com/uc.js"
        data-cbid="eb5a8a84-458d-49ac-ba40-eee70b46fe14"
        data-blockingmode="auto"
        type="text/javascript">
    </script>

    <!-- Cookie Declaration Script -->
    <script
        id="CookieDeclaration"
        src="https://consent.cookiebot.com/eb5a8a84-458d-49ac-ba40-eee70b46fe14/cd.js"
        type="text/javascript"
        async>
    </script>

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', 'resources/sass/app.scss', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<body class="font-sans antialiased">
@inertia
</body>
</html>
