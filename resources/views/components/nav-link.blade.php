@props(['active', 'icon'])

@php
$classes = ($active ?? false)
? 'text-base text-gray-900 font-normal rounded-lg flex items-center p-2 bg-gray-100 group'
: 'text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <ion-icon name={{ $icon }}></ion-icon>
    <span class="ml-3">{{ $slot }}</span>
</a>
