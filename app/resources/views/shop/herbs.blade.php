<x-layouts.public title="Erbe e tisane" :menus="$menus" :floating="true">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('legacy/pages/styles/herbs.css') }}">
        <link rel="stylesheet" href="{{ asset('legacy/storefront.css') }}">
    @endpush
    @push('scripts')<script defer src="{{ asset('legacy/storefront.js') }}"></script>@endpush
    <div id="slider" class="grid">
        <div id="bgr" class="bgr" style="background-image: url('{{ asset('legacy/pages/images/herbs/bgr.jpg') }}')"></div>
        <h1 id="title">Erbe &amp;<br>Tisane</h1>
    </div>
    <div id="content"><div class="content-wrap padt4 padb5">
        <p role="status">L'acquisto online non è ancora disponibile.</p>
        @foreach ($categories as $category)
            <section id="{{ $category->tag }}" class="category">
                <div class="title-box txt-cen">
                    <div class="icon legacy-icon inlb bgr-c3" style="--icon: url('{{ asset('legacy/pages/images/herbs/'.$category->tag.'.svg') }}')"></div>
                    <h2 class="title txt-c1 txt-3rem txt-sbold">{{ $category->names }}</h2>
                </div>
                <div class="list mart2">
                    @foreach ($items->get($category->tag, collect()) as $item)
                        <div class="line grid">
                            <div class="name-box">
                                <p class="name">{{ $item->name }}</p>
                                @if ($item->tech)<p class="txt-c1">{{ $item->tech }}</p>@endif
                                <p class="txt-ita">{{ $item->info }}</p>
                                @if ($item->ingredients)<p class="txt-sbold mart10px">Ingredienti: {{ $item->ingredients }}.</p>@endif
                            </div>
                            <div class="qty-box grid2"><p>Quantità <span class="inlb">(in etti):</span></p><input type="number" value="1" class="inp qty" min="1" max="100" disabled aria-label="Quantità per {{ $item->name }}"></div>
                            <div class="price-box"><h1><span class="price">{{ number_format($item->price, 2, ',', '') }}</span> €</h1></div>
                            <button type="button" class="mbtn" disabled aria-label="Aggiunta al carrello non ancora disponibile"><span class="btn-icon legacy-icon bgr-wht" style="--icon: url('{{ asset('legacy/system/resources/icons/ecommerce/cart.svg') }}')"></span></button>
                        </div>
                    @endforeach
                    <div class="overlay bgr"></div>
                    <button type="button" class="show-more">Mostra tutte</button>
                </div>
            </section>
        @endforeach
    </div></div>
</x-layouts.public>
