<!-- [ Header Topbar ] start -->
<header class="pc-header">
    <div class="header-wrapper" style="display: flex; justify-content: space-between;">
        <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <!-- ======= Menu collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item d-none d-md-inline-flex">
                    <form class="form-search">
                        <i class="search-icon">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-search-normal-1"></use>
                            </svg>
                        </i>
                        <input type="search" class="form-control" placeholder="Ctrl + K" />
                    </form>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <svg class="pc-icon">
                            <use xlink:href="#custom-sun-1"></use>
                        </svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-moon"></use>
                            </svg>
                            <span>Dark</span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="layout_change('light')">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-sun-1"></use>
                            </svg>
                            <span>Light</span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="layout_change_default()">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-setting-2"></use>
                            </svg>
                            <span>Default</span>
                        </a>
                    </div>
                </li>
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <svg class="pc-icon">
                            <use xlink:href="#custom-setting-2"></use>
                        </svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <a href="#!" class="dropdown-item">
                            <i class="ti ti-user"></i>
                            <span>My Account</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i class="ti ti-settings"></i>
                            <span>Settings</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i class="ti ti-headset"></i>
                            <span>Support</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i class="ti ti-lock"></i>
                            <span>Lock Screen</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i class="ti ti-power"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li>
                <li class="pc-h-item">
                    <a href="#" class="pc-head-link me-0" data-bs-toggle="offcanvas"
                        data-bs-target="#announcement" aria-controls="announcement">
                        <svg class="pc-icon">
                            <use xlink:href="#custom-flash"></use>
                        </svg>
                    </a>
                </li>
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
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
                                                    <form method="POST"
                                                        action="{{ route('notifications.read', $notification->id) }}"
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

                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                        <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="user-image"
                            class="user-avtar" />
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Profile</h5>
                        </div>
                        <div class="dropdown-body">
                            <div class="profile-notification-scroll position-relative"
                                style="max-height: calc(100vh - 225px)">
                                <div class="d-flex mb-1">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="user-image"
                                            class="user-avtar wid-35" />
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">Carson Darrin 🖖</h6>
                                        <span>carson.darrin@company.io</span>
                                    </div>
                                </div>
                                <hr class="border-secondary border-opacity-50" />
                                <div class="card">
                                    <div class="card-body py-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0 d-inline-flex align-items-center"><svg
                                                    class="pc-icon text-muted me-2">
                                                    <use xlink:href="#custom-notification-outline"></use>
                                                </svg>Notification</h5>
                                            <div class="form-check form-switch form-check-reverse m-0">
                                                <input class="form-check-input f-18" type="checkbox"
                                                    role="switch" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-span">Manage</p>
                                <a href="#" class="dropdown-item">
                                    <span>
                                        <svg class="pc-icon text-muted me-2">
                                            <use xlink:href="#custom-setting-outline"></use>
                                        </svg>
                                        <span>Settings</span>
                                    </span>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <span>
                                        <svg class="pc-icon text-muted me-2">
                                            <use xlink:href="#custom-share-bold"></use>
                                        </svg>
                                        <span>Share</span>
                                    </span>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <span>
                                        <svg class="pc-icon text-muted me-2">
                                            <use xlink:href="#custom-lock-outline"></use>
                                        </svg>
                                        <span>Change Password</span>
                                    </span>
                                </a>
                                <hr class="border-secondary border-opacity-50" />
                                <p class="text-span">Team</p>
                                <a href="#" class="dropdown-item">
                                    <span>
                                        <svg class="pc-icon text-muted me-2">
                                            <use xlink:href="#custom-profile-2user-outline"></use>
                                        </svg>
                                        <span>UI Design team</span>
                                    </span>
                                    <div class="user-group">
                                        <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="user-image"
                                            class="avtar" />
                                        <span class="avtar bg-danger text-white">K</span>
                                        <span class="avtar bg-success text-white">
                                            <svg class="pc-icon m-0">
                                                <use xlink:href="#custom-user"></use>
                                            </svg>
                                        </span>
                                        <span class="avtar bg-light-primary text-primary">+2</span>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <span>
                                        <svg class="pc-icon text-muted me-2">
                                            <use xlink:href="#custom-profile-2user-outline"></use>
                                        </svg>
                                        <span>Friends Groups</span>
                                    </span>
                                    <div class="user-group">
                                        <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="user-image"
                                            class="avtar" />
                                        <span class="avtar bg-danger text-white">K</span>
                                        <span class="avtar bg-success text-white">
                                            <svg class="pc-icon m-0">
                                                <use xlink:href="#custom-user"></use>
                                            </svg>
                                        </span>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <span>
                                        <svg class="pc-icon text-muted me-2">
                                            <use xlink:href="#custom-add-outline"></use>
                                        </svg>
                                        <span>Add new</span>
                                    </span>
                                    <div class="user-group">
                                        <span class="avtar bg-primary text-white">
                                            <svg class="pc-icon m-0">
                                                <use xlink:href="#custom-add-outline"></use>
                                            </svg>
                                        </span>
                                    </div>
                                </a>
                                <hr class="border-secondary border-opacity-50" />
                                <div class="d-grid mb-3">
                                    <button class="btn btn-primary">
                                        <svg class="pc-icon me-2">
                                            <use xlink:href="#custom-logout-1-outline"></use>
                                        </svg>Logout
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>

<!-- [ Header ] end -->
