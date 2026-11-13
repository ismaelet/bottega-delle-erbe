<x-layouts.public title="Negozio" :menus="$menus" :floating="true">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('legacy/app/elements/item_grid/styles/element_item_grid.css') }}">
        <link rel="stylesheet" href="{{ asset('legacy/app/elements/shop/styles/element_shop.css') }}">
        <link rel="stylesheet" href="{{ asset('legacy/pages/styles/shop.css') }}">
        <link rel="stylesheet" href="{{ asset('legacy/storefront.css') }}">
    @endpush
    @push('scripts')
        <script defer src="{{ asset('legacy/storefront.js') }}"></script>
    @endpush
    <section id="head">
        <div id="bgr" class="bgr" style="background-image: url('{{ asset('legacy/pages/images/shop/bgr.jpg') }}')"></div>
        <div id="title-box" class="txt-cen cenY rel pado5">
            <h1 id="title" class="marb4 txt-c1">Prodott<span style="letter-spacing: 0;">i</span></h1>
            <div id="srch-pan" class="mwid650">
                <form method="GET" action="{{ route('shop.index') }}#body" class="grid">
                    <div class="srch_cell left"><input type="text" name="search" class="srch_inp" placeholder="Cerca un prodotto" value="{{ $search }}" maxlength="30"></div>
                    <div class="srch_cell right"><button type="submit" class="srch_btn mbtn" aria-label="Cerca"><span class="icon legacy-icon bgr-f" style="--icon: url('{{ asset('legacy/system/resources/icons/actions/search.svg') }}')"></span></button></div>
                </form>
            </div>
        </div>
        <a href="#body" class="nav-arr pos-br bot wht scroll" aria-label="Vai ai prodotti"></a>
    </section>
    <div id="body" class="content-wrap padt3">
        <div class="shop-title-box"><h2 class="shop-title txt-light">I NOSTRI <span class="txt-c3 txt-bold">PRODOTTI</span></h2></div>
        <p role="status">L'acquisto online non è ancora disponibile.</p>
        <div id="store"><div id="store-tbl">
            <form method="GET" action="{{ route('shop.index') }}#body" id="filter-sec">
                <input type="hidden" name="sort" value="{{ $sort }}">
                <button type="button" id="filter-text" aria-expanded="false">Filtra la ricerca<span class="search-ddown-ico"></span></button>
                <div id="search-sec"><div id="search-mob-box" class="padb3">
                    <div class="marb2"><div id="search-inp-box" class="gallery">
                        <input type="text" id="search-inp" class="inlb" name="search" value="{{ $search }}" placeholder="Cerca un prodotto" maxlength="30">
                        <button type="submit" id="search-ico" class="inlb clickable" aria-label="Cerca"></button>
                    </div></div>
                    <div class="srch-box"><p class="srch-title">Filtra</p>
                        @foreach ([['Esigenze', 'use', $uses, 'name', $use], ['Tipologie', 'type', $types, 'names', $type]] as [$label, $field, $options, $nameField, $selected])
                            <div>
                                <input type="checkbox" id="filter-{{ $field }}" class="hide category-cbx" @checked($selected !== '')>
                                <label class="category-title-box" for="filter-{{ $field }}"><p class="category-title"><span class="category-ico legacy-icon bgr-2" style="--icon: url('{{ asset('legacy/system/resources/icons/navigation/arrow1-down.svg') }}')"></span>{{ $label }}</p></label>
                                <div class="category-ddown">
                                    @foreach ($options as $option)
                                        <label><input type="radio" class="filter-option category-cbx hide" name="{{ $field }}" value="{{ $option->tag }}" @checked($selected === $option->tag)><p class="type-title">{{ $option->$nameField }}</p></label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <noscript><button type="submit" class="mbtn">Applica filtri</button></noscript>
                    @if ($search || $type || $use)<p class="remove-filter clickable padt1"><a href="{{ route('shop.index') }}#body"><span class="txt-bold txt-blk">x</span> rimuovi filtro</a></p>@endif
                </div></div>
            </form>
            <section id="items-sec" class="padb3"><div id="items" class="items_panel">
                <form action="{{ route('shop.index') }}#body" method="GET" id="sort_box">
                    <input type="hidden" name="type" value="{{ $type }}"><input type="hidden" name="use" value="{{ $use }}"><input type="hidden" name="search" value="{{ $search }}">
                    <label><input type="radio" class="sort-cbx hide" name="sort" value="new" @checked($sort === 'new')><span class="sort_txt clickable">Nuovi</span></label>
                    <span class="sort_txt">·</span>
                    <label><input type="radio" class="sort-cbx hide" name="sort" value="pop" @checked($sort === 'pop')><span class="sort_txt clickable">Popolari</span></label>
                    <noscript><button type="submit" class="mbtn">Ordina</button></noscript>
                </form>
                <div class="grid5 grid4-1440w grid3-1024w grid2-480w">@include('partials.product-grid', ['products' => $products])</div>
                @if ($products->isEmpty())<p id="store-empty">Nessun articolo trovato</p>@endif
                @if ($products->lastPage() > 1)
                    <div id="page-box" class="txt-cen mart3">
                        @php($firstPage = max(1, min($products->currentPage() - 2, $products->lastPage() - 4)))
                        @for ($page = $firstPage; $page <= min($products->lastPage(), $firstPage + 4); $page++)
                            <a class="page_txt clickable {{ $page === $products->currentPage() ? 'select disabled' : '' }}" href="{{ $products->url($page) }}#body">{{ $page }}</a>
                        @endfor
                    </div>
                @endif
            </div></section>
        </div></div>
    </div>
</x-layouts.public>
