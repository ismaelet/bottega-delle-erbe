<x-layouts.public :title="$course->title" :menus="$menus">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('legacy/pages/styles/courses/course.css') }}">
    @endpush
    <section id="slider">
        <div class="bgr" style="background-image: url('{{ asset("storage/courses/{$course->id}.jpg") }}')"></div>
    </section>
    <section id="body" class="content-wrap padt5 padb3">
        <h1 class="title txt-c1 txt-25rem txt-bold txt-cen marb3">{{ $course->title }}</h1>
        <p class="text txt-1rem txt-lh2">{{ $course->text }}</p>
        <p class="schedule padt2 mart2 txt-c1 txt-12rem txt-cen txt-sbold brt1 br-e">{{ $course->schedule }}</p>
    </section>
    <section id="more" class="padt3 padb5 bgr-f6">
        <div class="content-wrap">
            <h2 class="title txt-c1 txt-sbold marb3">Altri corsi</h2>
            <div class="courses grid2 grid-pad2">
                @foreach ($moreCourses as $otherCourse)
                    <a href="{{ route('courses.show', ['id' => $otherCourse->id]) }}" class="course bgr-f grid">
                        <div class="img image" style="background-image: url('{{ asset("storage/courses/{$otherCourse->id}_m.jpg") }}')"></div>
                        <div class="data pad3">
                            <h1 class="txt-sbold txt-13rem">{{ $otherCourse->title }}</h1>
                            <p class="txt-a txt-line2 mart1">{{ $otherCourse->text }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.public>
