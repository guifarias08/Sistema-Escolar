@props(['icon' => 'fa-folder-open', 'title', 'description'])

<div class="empty-state">
    <span><i class="fa-solid {{ $icon }}"></i></span>
    <h3>{{ $title }}</h3>
    <p>{{ $description }}</p>
    {{ $slot }}
</div>
