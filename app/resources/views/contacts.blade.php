<x-layouts.public title="Contatti" :menus="$menus" :floating="true">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('legacy/pages/styles/contacts.css') }}">
    @endpush
    @push('scripts')
        <script defer src="{{ asset('legacy/contacts.js') }}"></script>
    @endpush

    <div id="slider" class="grid">
        <div id="bgr" class="bgr" style="background-image: url('{{ asset('legacy/pages/images/contacts/bgr.jpg') }}')"></div>
        <h1 id="title">Contatti</h1>
    </div>

    <div id="content"><div class="content-wrap"><div id="grid" class="grid2 grid-pad3 al-top">
        <section id="data" class="grid-cell">
            <h2 class="stitle txt-3rem marb2">La Bottega<br>delle Erbe</h2>
            <p class="txt-1rem txt-c3-h"><a href="mailto:online@bottegadelleerbe.com">online@bottegadelleerbe.com</a></p>
            <div class="socials mart2 flex">
                @foreach ([
                    ['call', 'tel:0462502484', 'Telefono'],
                    ['mail', 'mailto:online@bottegadelleerbe.com', 'Email'],
                    ['facebook', 'https://www.facebook.com/La-Bottega-Delle-Erbe-1613952845505325', 'Facebook'],
                    ['instagram', 'https://www.instagram.com/la_bottega_delle_erbe_predazzo/', 'Instagram'],
                ] as [$icon, $href, $label])
                    <a class="social legacy-icon bgr-5 bgr-c3-h" href="{{ $href }}" aria-label="{{ $label }}" style="--icon: url('{{ asset("legacy/system/resources/icons/contacts/{$icon}.svg") }}')"></a>
                @endforeach
            </div>
            <div class="brt1 br-9 marv2"></div>
            <h2 class="txt-2rem marb2">Dove trovarci</h2>
            <p class="data-txt txt-1rem">Via IX Novembre, 8,<br>38037 Predazzo (TN)</p>
            <iframe id="map" class="mart1" title="Mappa della Bottega delle Erbe" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d11023.755404324244!2d11.602886!3d46.3110519!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xbf13f6e1de855131!2sLa%20Bottega%20delle%20Erbe%20-%20Toelettatura%20per%20Piccoli%20Amici!5e0!3m2!1sen!2sbr!4v1627507038655!5m2!1sen!2sbr" width="600" height="450" style="border:0;" allowfullscreen loading="lazy"></iframe>
        </section>

        <section id="form" class="grid-cell">
            <form method="POST" action="{{ route('contacts.send') }}" autocomplete="off">
                @csrf
                <div id="form-anch" class="anchor"></div>
                <h2 class="stitle txt-3rem txt-cen">Scrivici</h2>
                @if (session('contact_sent'))
                    <p class="inp ok" role="status">Messaggio inviato ti risponderemo il prima possibile</p>
                @endif
                @if ($errors->any())
                    <div class="inp err" role="alert">
                        @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                        <p>Puoi scrivere direttamente a <a href="mailto:online@bottegadelleerbe.com" class="txt-bold">online@bottegadelleerbe.com</a>, invece di usare questo modulo.</p>
                    </div>
                @endif
                <div class="form-lbl-box {{ old('name') ? 'focus' : '' }}"><p class="form-lbl"><label for="contact-name">Nome e cognome</label></p></div>
                <input type="text" id="contact-name" name="name" class="form-inp" value="{{ old('name') }}" maxlength="100" required>
                <div class="form-lbl-box {{ old('mail') ? 'focus' : '' }}"><p class="form-lbl"><label for="contact-mail">Indirizzo e-mail</label></p></div>
                <input type="email" id="contact-mail" name="mail" class="form-inp" value="{{ old('mail') }}" maxlength="254" required>
                <div class="form-lbl-box {{ old('text') ? 'focus' : '' }}"><p class="form-lbl"><label for="contact-text">Messaggio</label></p></div>
                <textarea id="contact-text" name="text" class="form-textarea" maxlength="500" required>{{ old('text') }}</textarea>
                <div class="txt-rig mart2"><button type="submit" id="submit" class="mbtn mob-full">Invia</button></div>
            </form>
        </section>
    </div></div></div>
</x-layouts.public>
