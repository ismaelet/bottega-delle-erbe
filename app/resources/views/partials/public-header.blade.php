@php
    $links = [
        ['Home', '/', null],
        ['Prodotti', '/shop', 'shop'],
        ['Esigenze', null, 'uses'],
        ['Erbe e Altro', '/herbs', 'herbs'],
        ['Corsi', '/courses', null],
        ['Novità', '/blog', null],
        ['Contatti', '/contacts', null],
    ];
@endphp
<header class="gallery {{ $scheme }} {{ $floating ? 'floating' : '' }}">
    <div id="h-pan">
        <div id="h-bgr" class="bgr"></div>
        <div id="h-nav-lef" class="h-nav-bar inlb txt-lef al-mid">
            <form id="h-srch" class="inlb" method="GET" action="{{ url('/shop') }}#body">
                <input type="checkbox" id="h-srch-cbx" class="hide">
                <label for="h-srch-cbx" id="h-srch-ico-box" class="br-c1 al-mid">
                    <span class="bgr bgr-c1"></span>
                    <span id="h-srch-ico" class="icon legacy-icon {{ $scheme === 'dark' ? 'txt-wht' : 'txt-3' }}" style="--icon: url('{{ asset('legacy/system/resources/icons/actions/search.svg') }}')"></span>
                </label>
                <div id="h-srch-inp-box"><input type="text" id="h-srch-inp" name="search" placeholder="Cerca un prodotto o tag"></div>
                <div id="h-search-logo"><img src="{{ asset('legacy/app/resources/logo/logo_bro.png') }}" alt="La Bottega delle Erbe"></div>
            </form>
        </div><div id="h-nav-cen" class="h-nav-bar inlb txt-cen al-mid"></div><div id="h-nav-rig" class="h-nav-bar inlb txt-rig al-mid">
            <div class="h-nav-box desk inlb al-mid">
                @foreach ($links as [$label, $href, $menu])
                    <div class="h-link {{ $menu ? 'megamenu-open' : '' }}" @if ($menu) data-megamenu="{{ $menu }}" @endif>
                        <p class="h-link-txt {{ ($label === 'Home' && request()->routeIs('home')) || ($label === 'Novità' && request()->routeIs('blog.index')) || ($label === 'Corsi' && request()->routeIs('courses.index')) ? 'active' : '' }}">
                            @if ($href)<a href="{{ url($href) }}">{{ $label }}</a>@else {{ $label }} @endif
                        </p>
                    </div>
                @endforeach
                <a href="{{ url('/cart') }}" id="h-cart" class="h-link al-mid" aria-label="Carrello">
                    <span class="icon bgr legacy-icon" style="--icon: url('{{ asset('legacy/system/resources/icons/ecommerce/bag.svg') }}')"></span>
                </a>
            </div>
            <div id="h-mob-pan" class="txt-rig mob">
                <input type="checkbox" id="h-cbxM" class="hide">
                <label id="h-icoM-box" for="h-cbxM" aria-label="Menu">
                    <span id="h-icoM-line1" class="h-icoM-line"><span class="h-icoM-rot"></span></span>
                    <span id="h-icoM-line2" class="h-icoM-line"><span class="h-icoM-rot"></span></span>
                    <span id="h-icoM-line3" class="h-icoM-line"><span class="h-icoM-rot"></span></span>
                </label>
                <nav id="h-navM" class="txt-lef mob">
                    <div id="h-navM-bgr" class="bgr"></div>
                    <div id="h-contM">
                        <div class="h-linkM"><a href="{{ url('/login') }}"><p class="h-linkM-txt txt-upp">Login</p></a></div>
                        @foreach ($links as [$label, $href, $menu])
                            @if ($menu)
                                <label class="h-linkM">
                                    <input type="checkbox" class="h-dropM-cbx hide">
                                    <a><p class="h-linkM-txt txt-upp"><span class="h-linkM-bgr bgr bgr-c1"></span>{{ $label }} <span class="h-dropM-ico">&#x25BC;</span></p></a>
                                    <div class="h-dropM">
                                        @foreach ($menus[$menu]['categories'] as $category)
                                            <p class="h-dropM-link txt-wht-h bgr-c3-h"><a href="{{ url($category['link']) }}">{{ $category['title'] }}</a></p>
                                        @endforeach
                                    </div>
                                </label>
                            @else
                                <div class="h-linkM"><a href="{{ url($href) }}"><p class="h-linkM-txt txt-upp">{{ $label }}</p></a></div>
                            @endif
                        @endforeach
                        <div class="h-lineM bgr-c1"></div>
                    </div>
                </nav>
            </div>
        </div>
        @foreach ($menus as $name => $menu)
            <div id="megamenu-{{ $name }}" class="megamenu {{ $menu['link'] ? 'no-padding' : '' }}" style="--menu-size: {{ $menu['size'] }}">
                <div class="wrap">
                    @foreach ($menu['categories'] as $category)
                        <div class="category">
                            <h3><a href="{{ url($category['link']) }}">{{ $category['title'] }}</a></h3>
                            <div class="links">
                                @foreach ($category['items'] as $item)
                                    <p><a class="inlb txt-c2-h" href="{{ url('/shop/item') }}?id={{ $item->id }}">{{ $item->name }}</a></p>
                                @endforeach
                                @if ($category['more'])
                                    <p><a class="inlb txt-c2-h" href="{{ url($category['link']) }}"><strong>Mostra tutti</strong></a></p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($menu['link'])<p class="general-link"><a href="{{ url($menu['link']) }}">Lista alfabetica</a></p>@endif
            </div>
        @endforeach
    </div>
</header>
