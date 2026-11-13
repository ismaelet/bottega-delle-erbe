<section id="blog" class="padb3">
    <div id="blog-wrap" class="wrap">
        <div class="pado2">
            <div class="grid3 grid2-1024w grid1-480w grid-pad2 grid-pad1-768w al-top">
                @foreach ($posts as $post)
                    <a href="{{ route('blog.show', ['id' => $post->id]) }}" class="grid-ele blog-post-box bgr-f6 load ld-bot ld-del{{ $loop->iteration }}">
                        <div id="blog-post{{ $post->id }}" class="blog-post">
                            <div class="blog-img"><img src="{{ asset("storage/blog/{$post->id}_m.jpg") }}" loading="lazy" class="img-cover cont" alt=""></div>
                            <div class="blog-cont">
                                <p class="blog-title txt-spa1 txt-2rem txt-bold txt-c1 padb1">{{ $post->title }}</p>
                                <p class="blog-txt">{{ \Illuminate\Support\Str::limit($post->text, 200) }}</p>
                                <p class="blog-link mart1 txt-1rem txt-c5">Leggi tutto</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="txt-cen"><x-button :href="route('blog.index')" class="txt-def load ld-bot ld-del2">Tutte le novità</x-button></div>
        </div>
    </div>
    <a href="#slider" class="scroll-top" aria-label="Torna in cima"><span class="icon legacy-icon" style="--icon: url('{{ asset('legacy/system/resources/icons/navigation/arrow1-top.svg') }}')"></span></a>
</section>
