<footer>
    <div>
        <div id="foot-bgr" class="bgr" style="background-image: url('{{ asset('legacy/app/templates/images/footer/bgr.png') }}')"></div>
        <div id="footer-wrap" class="content-wrap padv5">
            <div id="footer-body" class="grid">
                <div id="foot-logo" class="img cont" style="background-image: url('{{ asset('legacy/app/templates/images/footer/logo.png') }}')"></div>
                <div id="foot-col-pan" class="grid3 grid2-1024w al-top">
                    @foreach ([
                        'Esplora' => ['Contatti' => '/contacts', 'Corsi' => '/courses', 'Novità' => '/blog'],
                        'Prodotti' => ['Negozio' => '/shop', 'Piante' => '/herbs', 'Tisane' => '/herbs#hte', 'Infusi e altro' => '/herbs#inf'],
                    ] as $title => $links)
                        <div class="footer-col">
                            <p class="footer-title txt-wht txt-bold txt-upp">{{ $title }}</p>
                            @foreach ($links as $label => $href)
                                <p class="footer-link"><a href="{{ url($href) }}">{{ $label }}</a></p>
                            @endforeach
                        </div>
                    @endforeach
                    <div id="footer-cont" class="footer-col">
                        <p class="footer-title txt-wht txt-bold txt-upp">Contatti</p>
                        <div class="flex gap1">
                            @foreach ([
                                ['call', 'tel:0462502484', 'Telefono'],
                                ['instagram', 'https://www.instagram.com/la_bottega_delle_erbe_predazzo/', 'Instagram'],
                                ['facebook', 'https://www.facebook.com/La-Bottega-Delle-Erbe-1613952845505325', 'Facebook'],
                                ['mail', 'mailto:online@bottegadelleerbe.com', 'Email'],
                            ] as [$icon, $href, $label])
                                <a href="{{ $href }}" aria-label="{{ $label }}"><span class="footer-soc-icon legacy-icon" style="--icon: url('{{ asset("legacy/system/resources/icons/contacts/{$icon}.svg") }}')"></span></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer-notes" class="txt-cen">
        <p id="footer-notes-txt">Copyright © {{ date('Y') }} La Bottega delle Erbe. P. IVA 01317350229.<br>Sito web realizzato da <a class="txt-wht-h" href="mailto:ismaele.tuffanelli@gmail.com">Ismaele Tuffanelli</a></p>
    </div>
</footer>
