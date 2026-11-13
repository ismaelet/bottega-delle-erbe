<x-layouts.public title="Lista dei prodotti" :menus="$menus">
    @push('styles')<link rel="stylesheet" href="{{ asset('legacy/pages/styles/shop/list.css') }}">@endpush
    <div class="content-wrap padv5">
        <h1 class="txt-3rem txt-cen marb5">Lista dei prodotti</h1>
        <div id="list">
            @php($letter = null)
            @foreach ($products as $product)
                @php($nextLetter = mb_strtoupper(mb_substr($product->name, 0, 1)))
                @if ($nextLetter !== $letter)
                    @php($letter = $nextLetter)
                    <h3 class="letter txt-25px txt-bold mart1">{{ $letter }}</h3>
                @endif
                <p class="marv10px txt-09rem"><a href="{{ route('shop.product', ['id' => $product->id]) }}" class="txt-c2-h">{{ $product->name }}</a></p>
            @endforeach
        </div>
    </div>
</x-layouts.public>
