<x-layouts.public title="Novità" :menus="$menus" :floating="true">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('legacy/pages/styles/blog.css') }}">
    @endpush
    @push('scripts')
        <script defer src="{{ asset('legacy/blog.js') }}"></script>
    @endpush

    <div id="slider" class="grid">
        <div id="bgr" class="bgr" style="background-image: url('{{ asset('legacy/pages/images/blog/bgr.jpg') }}')"></div>
        <h1 id="title">Novità</h1>
    </div>

    <section id="posts" class="bgr-f6 padt7 padb5">
        <div class="content-wrap">
            <div class="posts grid4 grid3-1440w grid2-768w grid1-480w al-top" data-blog-posts>
                @foreach ($posts as $post)
                    <a href="{{ route('blog.show', ['id' => $post->id]) }}" class="post" data-id="{{ $loop->iteration }}">
                        <div class="box bgr-f">
                            <div class="image">
                                <img src="{{ asset("storage/blog/{$post->id}_m.jpg") }}" alt="" loading="lazy" class="img-cover {{ $post->cover ? 'cover' : 'contain' }}">
                            </div>
                            <div class="body txt-cen">
                                <h1 class="title txt-25px txt-sbold">{{ $post->title }}</h1>
                                <p class="data txt-09rem txt-a">{{ \Illuminate\Support\Carbon::parse($post->time)->format('d · m · Y') }}</p>
                                <p class="text txt-09rem mart2">{{ $post->text }}</p>
                                <div class="txt-cen"><p class="more txt-c2-h br-c2-h mart1 brb1 br-a brb-dashed inlb">Continua a leggere</p></div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <section id="pages" class="txt-cen mart5" aria-label="Pagine">
                @for ($page = 1; $page <= $posts->lastPage() && $posts->total() > 0; $page++)
                    <a href="{{ $posts->url($page) }}"><span class="page txt-12rem inlb {{ $posts->currentPage() === $page ? 'active' : '' }}">{{ $page }}</span></a>
                @endfor
            </section>
        </div>
    </section>
</x-layouts.public>
