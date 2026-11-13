<x-layouts.public :title="$post->title" :menus="$menus">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('legacy/pages/styles/blog/post/post.css') }}">
    @endpush

    <div id="slider" class="grid">
        <div id="bgr" class="bgr" style="background-image: url('{{ asset('legacy/pages/images/blog/post/bgr.jpg') }}')"></div>
        <h1 id="title">Novità</h1>
    </div>
    <section id="body" class="content-wrap padt7 padb5">
        <div id="content-head" class="grid content-grid">
            <div id="post-head">
                <h1 class="title txt-3rem txt-sbold txt-c1">{{ $post->title }}</h1>
                <p class="date mart2 txt-ls1 txt-a">{{ \Illuminate\Support\Carbon::parse($post->time)->format('d · m · Y') }}</p>
            </div>
            <div class="more-posts desk1024"><h1 class="title txt-upp txt-c1 txt-13rem txt-bold txt-cen">Altre Novità</h1></div>
        </div>
        <div id="content-body" class="grid content-grid al-top mart3">
            <div id="post-body">
                <div class="txt-cen"><img src="{{ asset("storage/blog/{$post->id}.jpg") }}" alt="" class="image marb2"></div>
                <p class="text txt-1rem txt-lh2">{{ $post->text }}</p>
                <div class="txt-cen mart2"><x-button :href="route('blog.index')" class="txt-def desk1024">Tutte le novità</x-button></div>
            </div>
            <div class="more-posts">
                <h1 class="title txt-c1 txt-sbold txt-cen mob1024 marb4">Altre Novità</h1>
                <div class="posts grid">
                    @foreach ($morePosts as $otherPost)
                        <a href="{{ route('blog.show', ['id' => $otherPost->id]) }}" class="post grid">
                            <div class="img image {{ $otherPost->cover ? 'cover' : 'contain' }}" style="background-image: url('{{ asset("storage/blog/{$otherPost->id}_m.jpg") }}')"></div>
                            <div class="data">
                                <h1 class="txt-sbold txt-13rem">{{ $otherPost->title }}</h1>
                                <p class="date mart1 txt-c">{{ \Illuminate\Support\Carbon::parse($otherPost->time)->format('d - m - Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
