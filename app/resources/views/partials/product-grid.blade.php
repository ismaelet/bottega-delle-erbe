@foreach ($products as $product)
    <div class="item-box al-top">
        <div><a class="item-img img cont" style="background-image: url('{{ $product->image }}')" href="{{ route('shop.product', ['id' => $product->id]) }}" aria-label="{{ $product->name }}"></a></div>
        <p class="item-type txt-upp">{{ $product->typeName }}</p>
        <p class="item-name">{{ $product->name }}</p>
        <div class="item-cart-box">
            <p class="item-price">{{ number_format($product->price, 2, ',', '') }} €</p>
            <button type="button" class="item-cart" disabled aria-label="Aggiunta al carrello non ancora disponibile" title="Aggiunta al carrello non ancora disponibile">
                <span class="icon legacy-icon cen" style="--icon: url('{{ asset('legacy/system/resources/icons/ecommerce/add-to-cart.svg') }}')"></span>
            </button>
        </div>
    </div>
@endforeach
