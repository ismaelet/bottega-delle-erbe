@props(['href', 'variant' => 'secondary'])

<a href="{{ $href }}" {{ $attributes->class(['sbtn' => $variant === 'secondary', 'mbtn' => $variant === 'primary']) }}>{{ $slot }}</a>
