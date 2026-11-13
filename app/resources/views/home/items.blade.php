<div id="items">
    <div id="items-bgr" class="bgr bot" style="background-image: url('{{ asset('legacy/pages/images/home/items/bgr.jpg') }}')"></div>
    <div class="overlay bgr"></div>
    <div class="content-wrap">
        <div class="title-box">
            <h1 id="items-title" class="txt-c1 txt-upp"><span class="load ld-rig ld-del3 inlb" style="font-size: .8em;">I Nostri</span><br><span class="load ld-lef inlb">Prodotti</span></h1>
            <div class="title-line inlb bgr-c1 load ld-lef ld-del3"></div>
            <p id="items-stitle" class="txt-c3 txt-ita load ld-rig ld-del6">Integratori, tinture, oli e molto altro</p>
        </div>
        <p class="cart-unavailable" role="status">L'acquisto online non è ancora disponibile.</p>
        <div id="items-grid" class="grid5 grid4-1440w grid3-768w grid2-480w marv2 bgr-f">
            @include('partials.product-grid')
        </div>
        <div class="load ld-lef ld-del3">
            <x-button :href="url('/shop')" variant="primary"><span class="bgr bgr-c3"></span><span class="btn-icon legacy-icon bgr-f" style="--icon: url('{{ asset('legacy/system/resources/icons/ecommerce/cart.svg') }}')"></span><span class="btn-txt">Tutti i prodotti</span></x-button>
        </div>
    </div>
</div>
