@forelse($lectures as $item)
    @include('partials.lecture-card', [
        'item' => $item,
    ])
@empty
    <div class="empty-card">
        No lectures today.
    </div>
@endforelse
