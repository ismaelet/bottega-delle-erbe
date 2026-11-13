<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Offline | Bottega delle Erbe</title>
    <link rel="icon" href="{{ asset('legacy/app/resources/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('legacy/public.css') }}">
    @foreach (['colors', 'grids', 'main', 'position', 'sizes', 'texts'] as $stylesheet)
        <link rel="stylesheet" href="{{ asset("legacy/system/styles/{$stylesheet}.css") }}">
    @endforeach
    <link rel="stylesheet" href="{{ asset('legacy/offline.css') }}">
</head>
<body>
    <main>
        <div id="bgr" class="bgr"></div>
        <div class="grid hei100">
            <div class="txt-cen">
                <img src="{{ asset('legacy/app/resources/logo/logo.png') }}" id="logo" class="inlb" alt="La Bottega delle Erbe">
                <h1 id="title" class="txt-wht mart1 txt-upp txt-bold">Sito Offline</h1>
                <p class="txt-wht txt-12rem mwid650 pado2 mart1">Il nostro sito è al momento in offline per un aggiornamento. Torneremo attivi non appena possibile.</p>
            </div>
        </div>
        <form id="login" class="wid100 txt-cen" method="POST" action="{{ url('/offline') }}">
            @csrf
            <button type="submit" id="login-txt" class="clickable txt-09rem"><span class="btn-txt txt-c1 br-c1 brb1 brb-dashed">Login come amministratore</span></button>
        </form>
    </main>
</body>
</html>
