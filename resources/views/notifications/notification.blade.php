<li class="dropdown pc-h-item">
    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button"
        aria-haspopup="false" aria-expanded="false">
        <svg class="pc-icon">
            <use xlink:href="#custom-notification"></use>
        </svg>
        <span class="badge bg-success pc-h-badge">
            {{ auth()->user()->unreadNotifications->count() }}
        </span>
    </a>

    <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header d-flex align-items-center justify-content-between">
            <h5 class="m-0">Notifications</h5>
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link btn-sm">Mark all read</button>
            </form>
        </div>

        <div class="dropdown-body text-wrap header-notification-scroll position-relative"
            style="max-height: calc(100vh - 215px)">

            @forelse(auth()->user()->notifications->take(5) as $notification)
                <div class="card mb-2 {{ $notification->read_at ? '' : 'border-warning' }}">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <svg class="pc-icon text-primary">
                                    <use xlink:href="#custom-layer"></use>
                                </svg>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <span class="float-end text-sm text-muted">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                                <h5 class="text-body mb-2">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </h5>
                                <p class="mb-0">{{ $notification->data['message'] ?? '' }}</p>

                                {{-- Mark as read button --}}
                                @if (!$notification->read_at)
                                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}"
                                        class="mt-2">
                                        @csrf
                                        <button class="btn btn-sm btn-primary">Mark Read</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <span class="dropdown-item text-muted">No notifications</span>
            @endforelse
        </div>

        <div class="text-center py-2">
            <form action="{{ route('notifications.deleteAll') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link link-danger">Clear all
                    Notifications</button>
            </form>
        </div>
    </div>
</li>
