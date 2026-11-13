<x-layouts.public :menus="$menus" :floating="true" scheme="dark">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('legacy/app/elements/item_grid/styles/element_item_grid.css') }}">
        <link rel="stylesheet" href="{{ asset('legacy/pages/styles/home.css') }}">
        @foreach (['about', 'blog', 'items', 'slider'] as $stylesheet)
            <link rel="stylesheet" href="{{ asset("legacy/pages/styles/home/{$stylesheet}.css") }}">
        @endforeach
        <link rel="stylesheet" href="{{ asset('legacy/home.css') }}">
    @endpush
    @push('scripts')
        <script defer src="{{ asset('legacy/home.js') }}"></script>
    @endpush

    @include('home.slider')
    @include('home.items')
    @include('home.about')
    @include('home.blog')
</x-layouts.public>
