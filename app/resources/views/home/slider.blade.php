<div id="slider">
    <div id="slider-bgr" class="bgr desk480" style="background-image: url('{{ asset('legacy/pages/images/home/slider/bgr.jpg') }}')"></div>
    <div id="slider-bgr-mob" class="bgr mob480" style="background-image: url('{{ asset('legacy/pages/images/home/slider/bgr_mob.jpg') }}')"></div>
    <div id="slider-det" style="background-image: url('{{ asset('legacy/pages/images/home/slider/det.png') }}')"></div>
    <div class="body cenY rel">
        <div class="content grid">
            <div id="slider-title-box">
                <img src="{{ asset('legacy/app/resources/logo/logo_wht.png') }}" alt="" class="logo load ld-rig ld-del3">
                <h1 id="slider-title" class="txt-upp txt-c1 marb4 load ld-lef">La Bottega<br>delle Erbe<br><span class="txt-f txt-thin">Predazzo</span></h1>
                <x-button href="#items" id="slider-btn" class="br-wht br-wht-h txt-wht txt-c1-h load ld-lef ld-del6 scroll">
                    <span class="btn-fill bgr-wht"></span><span class="btn-txt">Esplora</span><span class="slider-btn-det">&#x25BA;</span>
                </x-button>
            </div>
            @if ($highlightedProduct)
                <div id="slider-item-box" class="txt-rig load ld-bot">
                    <div id="slider-item-bgr1" class="bgr bgr-wht"></div>
                    <div id="slider-item-bgr2" class="bgr"></div>
                    <div id="slider-item" class="inlb">
                        <h1 id="slider-item-title" class="txt-upp txt-c1 txt-cen txt-bold load ld-rig ld-del3">Novi<span class="txt-wht">tà</span></h1>
                        <div id="slider-item-body" class="txt-lef">
                            <div id="slider-item-data">
                                <p id="slider-item-stitle" class="txt-c1 txt-sbold load ld-rig ld-del6"><span id="slider-item-det" class="br-c1"></span><span style="z-index: 1;">{{ $highlightedProduct->name }}</span></p>
                                <p id="slider-item-desc" class="load ld-lef ld-del6">Contrasta il dolore associato a processi degenerativi articolari • Stimola la formazione del tesuto connettivo migliorando la mobilità articolare</p>
                                <a href="{{ url('/shop/item') }}?id={{ $highlightedProduct->id }}"><p class="cta txt-1rem txt-c1 txt-sbold marb1 load ld-rig ld-del5">Scopri <span class="inlb icon legacy-icon slider-arrow" style="--icon: url('{{ asset('legacy/system/resources/icons/navigation/arrow2-right.svg') }}')"></span></p></a>
                                <p id="slider-item-price" class="txt-c1 txt-bold load ld-rig ld-del6">{{ number_format($highlightedProduct->price, 2, ',', '') }} €</p>
                            </div>
                            <div id="slider-item-img-box" class="load ld-lef ld-del3">
                                <a href="{{ url('/shop/item') }}?id={{ $highlightedProduct->id }}"><img class="slider__item" src="{{ asset('legacy/pages/images/home/slider/item.webp') }}" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
