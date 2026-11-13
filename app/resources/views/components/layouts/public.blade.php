@props(['title' => null, 'menus', 'floating' => false, 'scheme' => 'light'])

<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Da 35 anni la tua erboristeria di fiducia! Da noi trovi professionalità, qualità ed i nostri prodotti formulati per ogni tua esigenza di salute.">
    <title>{{ $title ? $title.' | Bottega delle Erbe' : 'Bottega delle Erbe | Erboristeria Predazzo' }}</title>
    <link rel="icon" href="{{ asset('legacy/app/resources/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('legacy/public.css') }}">
    @foreach (['animations', 'colors', 'elements', 'grids', 'load', 'main', 'position', 'sizes', 'texts'] as $stylesheet)
        <link rel="stylesheet" href="{{ asset("legacy/system/styles/{$stylesheet}.css") }}">
    @endforeach
    <link rel="stylesheet" href="{{ asset('legacy/app/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy/app/templates/styles/header.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy/app/templates/styles/footer.css') }}">
    @stack('styles')
    <script defer src="{{ asset('legacy/public.js') }}"></script>
    @stack('scripts')
</head>
<body>
    @include('partials.public-header', ['floating' => $floating, 'scheme' => $scheme])
    <main>{{ $slot }}</main>
    @include('partials.public-footer')
</body>
</html>
