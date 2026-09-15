@props(['title', 'eyebrow' => null, 'description' => null])

<div class="page-header">
    <div>
        @if($eyebrow)<div class="eyebrow">{{ $eyebrow }}</div>@endif
        <h1>{{ $title }}</h1>
        @if($description)<p>{{ $description }}</p>@endif
    </div>
    @if(trim($slot))
        <div class="page-actions">{{ $slot }}</div>
    @endif
</div>
