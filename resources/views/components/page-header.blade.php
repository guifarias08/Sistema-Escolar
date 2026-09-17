@props(['title', 'eyebrow' => null, 'description' => null, 'greetingName' => null])

<div class="page-header">
    <div>
        @if($eyebrow)<div class="eyebrow">{{ $eyebrow }}</div>@endif
        <h1
            @if($greetingName)
                data-dynamic-greeting
                data-greeting-name="{{ $greetingName }}"
            @endif
        >{{ $title }}</h1>
        @if($description)<p>{{ $description }}</p>@endif
    </div>
    @if(trim($slot))
        <div class="page-actions">{{ $slot }}</div>
    @endif
</div>
