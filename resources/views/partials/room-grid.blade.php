@forelse($availableRooms as $item)
    <article class="room-card">
        <div class="room-header">
            <div class="room-icon">
                <i class="fas fa-door-open" aria-hidden="true"></i>
            </div>

            <div>
                <div class="room-code">
                    {{ $item->room_code }}
                </div>

                <div class="room-status">
                    <i class="fas fa-check-circle" aria-hidden="true"></i>
                    Available
                </div>
            </div>
        </div>

        <div class="room-free">
            <i class="fas fa-check" aria-hidden="true"></i>
            Free Today
        </div>

        <div class="room-footer">
            <i class="fas fa-door-open" aria-hidden="true"></i>
            Room: {{ $item->room_code }}
        </div>
    </article>
@empty
    <div class="empty-card">
        No available rooms.
    </div>
@endforelse
