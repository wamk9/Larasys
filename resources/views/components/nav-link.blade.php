@props(['active', 'iconClass' => ''])

@php
$classes = ($active ?? false)
            ? 'nav-link active my-1 bg-gray-700'
            : 'nav-link my-1 text-white bg-gray-800';
@endphp

<i class="icon {{ $iconClass }}"></i>
<span>
<a {{ $attributes->merge(['class' => $classes]) }}>
	
	
	{{ $slot }}
</a>
</span