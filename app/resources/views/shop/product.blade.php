<x-layouts.public :title="$product->name" :menus="$menus">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('legacy/pages/styles/item/article.css') }}">
        <link rel="stylesheet" href="{{ asset('legacy/storefront.css') }}">
    @endpush
    @push('scripts')<script defer src="{{ asset('legacy/storefront.js') }}"></script>@endpush
    <div class="main-wrap">
        <div id="item">
            <div id="left-block" class="block"><div class="img-box"><img src="{{ $product->image }}" alt="Immagine prodotto" id="image"></div></div>
            <div id="right-block" class="block grid">
                <h1 id="title" class="txt-c1">{{ $product->name }}</h1>
                <h1 id="stitle" class="txt-light txt-a">{{ $product->typeName }}</h1>
                <div id="price-box" class="mart3 marb3"><h1 id="price" class="txt-c1">{{ number_format($product->price, 2, ',', '') }}<span style="font-size: .8em">€</span></h1></div>
                <div id="qty-box" class="field"><p class="txt-bold txt-1rem"><label for="qty">Quantità:</label></p><input type="number" id="qty" class="inp txt-bold" value="1" min="1" disabled></div>
                <div class="marb3">
                    <button type="button" id="submit" class="mbtn bgr-c4-full" disabled>
                        <span class="cart-icon btn-icon legacy-icon bgr-f" style="--icon: url('{{ asset('legacy/system/resources/icons/ecommerce/cart.svg') }}')" aria-hidden="true"></span>
                        <span class="btn-txt"><strong>Aggiungi al carrello</strong></span>
                    </button>
                    <p role="status">L'acquisto online non è ancora disponibile.</p>
                </div>
                <section id="infos" class="marb2">
                    @php($infos = array_filter(['Descrizione' => $product->info, "Modi d'uso" => $product->methods, 'Sostanze funzionali' => $product->ingredients, 'Avvertenze' => $product->warnings]))
                    <div class="titles flex marb1">
                        @foreach ($infos as $label => $text)<button type="button" class="title {{ $loop->first ? 'active' : '' }}" data-info="{{ $loop->index }}">{{ $label }}</button>@endforeach
                    </div>
                    <div class="texts">@foreach ($infos as $label => $text)<p class="{{ $loop->first ? 'active' : '' }}" data-info="{{ $loop->index }}">{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $text))) !!}</p>@endforeach</div>
                </section>
                <p class="txt-09rem mart10px marb1 bgr-f3 pad1">{{ str_replace(', ', ' · ', $product->tech) }}</p>
            </div>
        </div>
    </div>
</x-layouts.public>
