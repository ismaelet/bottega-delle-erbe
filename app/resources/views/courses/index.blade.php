<x-layouts.public title="Corsi" :menus="$menus" :floating="true">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('legacy/pages/styles/courses.css') }}">
    @endpush
    <div id="slider" class="grid">
        <div id="bgr" class="bgr" style="background-image: url('{{ asset('legacy/pages/images/courses/bgr.jpg') }}')"></div>
        <h1 id="title">Corsi</h1>
    </div>
    <section id="courses" class="padt10 padb5">
        <div class="content-wrap">
            @forelse ($courses as $course)
                <div class="course bgr-f grid">
                    <div class="image"><img src="{{ asset("storage/courses/{$course->id}_m.jpg") }}" alt="" loading="lazy" class="img-cover"></div>
                    <div class="data">
                        <h2 class="title txt-sbold txt-c1">{{ $course->title }}</h2>
                        <p class="text mart2 txt-1rem txt-lh2 txt-line2">{{ $course->text }}</p>
                        <p class="schedule txt-09rem txt-lh2 txt-c2">{{ $course->schedule }}</p>
                    </div>
                    <a href="{{ route('courses.show', ['id' => $course->id]) }}" class="explore">
                        <p class="txt-upp txt-c3 txt-1rem txt-sbold inlb">Scopri il corso</p>
                        <span class="icon legacy-icon bgr-c3 inlb" style="--icon: url('{{ asset('legacy/system/resources/icons/navigation/arrow1-right.svg') }}')"></span>
                    </a>
                </div>
            @empty
                <div class="empty"><p class="txt-1rem txt-cen txt-ls1">Al momento non ci sono corsi attivi.</p></div>
            @endforelse
        </div>
    </section>
</x-layouts.public>
