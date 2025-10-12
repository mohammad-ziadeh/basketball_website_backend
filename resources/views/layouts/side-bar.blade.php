<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="../dashboard/index.html" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="../assets/images/logo-dark.svg" class="img-fluid logo-lg" alt="logo" />
                <span class="badge bg-light-success rounded-pill ms-2 theme-version">v9.4.3</span>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label>Navigation</label>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-status-up"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Pages</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        <span class="pc-badge">2</span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="/dashboard">Dashboard</a></li>
                        <li class="pc-item"><a class="pc-link" href="/">empty</a>
                        <li class="pc-item"><a class="pc-link" href="../dashboard/finance.html">empty</a></li>
                    </ul>
                </li>
                {{-- ##################################################### --}}

                @if (Auth::user() && Auth::user()->role === 'admin')
                    <li class="pc-item"><a href="/event" class="pc-link">
                            <span class="pc-micon">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-calendar-1"></use>
                                </svg>
                            </span>
                            <span class="pc-mtext">Events</span>
                        </a>
                    </li>

                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-keyboard"></use>
                                </svg>
                            </span>
                            <span class="pc-mtext">Tables</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('users.index') }}">Users</a> </li>
                            <li class="pc-item"><a class="pc-link" href="{{ route('payments.index') }}">Payments</a> </li>
                            </li>
                            <li class="pc-item"><a class="pc-link" href="../demo/layout-color-header.html">Layouts 2</a>
                            </li>
                            <li class="pc-item"><a class="pc-link" href="../demo/layout-compact.html">Compact</a> </li>
                            <li class="pc-item"><a class="pc-link" href="../demo/layout-tab.html">Tab</a></li>
                        </ul>
                    </li>
                @elseif (Auth::user() && Auth::user()->role === 'coach')
                    <li class="pc-item"><a href="{{ route('courses.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-layer"></use>
                                </svg>
                            </span>
                            <span class="pc-mtext">Courses</span>
                        </a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-keyboard"></use>
                                </svg>
                            </span>
                            <span class="pc-mtext">Tables</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('users.index') }}">users
                                </a>
                            </li>
                            <li class="pc-item"><a class="pc-link" href="{{ route('attendance.index') }}">Players
                                    Attendance</a>
                            </li>
                            <li class="pc-item"><a class="pc-link" href="{{ route('evaluations.index') }}">Players
                                    Evaluation</a>
                            </li>
                            <li class="pc-item"><a class="pc-link"
                                    href="{{ route('session_performances.index') }}">Sessions Performance</a>
                            </li>
                            <li class="pc-item"><a class="pc-link"
                                    href="{{ route('monthly_performances.index') }}">Monthly Performance</a>
                            </li>
                            <li class="pc-item"><a class="pc-link" href="../demo/layout-tab.html">Tab</a></li>
                        </ul>
                    </li>
                @elseif (Auth::user() && Auth::user()->role === 'parent')
                    <li class="pc-item"><a href="/event" class="pc-link">
                            <span class="pc-micon">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-calendar-1"></use>
                                </svg>
                            </span>
                            <span class="pc-mtext">Events</span>
                        </a>
                    </li>
                    <li class="pc-item"><a href="{{ route('parent.attendance.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-layer"></use>
                                </svg>
                            </span>
                            <span class="pc-mtext">Attendance</span>
                        </a>
                    </li>

                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-keyboard"></use>
                                </svg>
                            </span>
                            <span class="pc-mtext">Tables</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('users.index') }}">Users</a> </li>
                            <li class="pc-item"><a class="pc-link" href="../demo/layout-color-header.html">Layouts
                                    1</a>
                            </li>
                            <li class="pc-item"><a class="pc-link" href="../demo/layout-color-header.html">Layouts
                                    2</a>
                            </li>
                            <li class="pc-item"><a class="pc-link" href="../demo/layout-compact.html">Compact</a>
                            </li>
                            <li class="pc-item"><a class="pc-link" href="../demo/layout-tab.html">Tab</a></li>
                        </ul>
                    </li>
                @else
                    <h1>nothing for now</h1>
                @endif
                {{-- ##################################################### --}}

                <li class="pc-item pc-caption">
                    <label>Other</label>
                    <svg class="pc-icon">
                        <use xlink:href="#custom-notification-status"></use>
                    </svg>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link"><span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-level"></use>
                            </svg> </span><span class="pc-mtext">Menu levels</span><span class="pc-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="#!">Level 2.1</a></li>
                        <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link">Level 2.2<span class="pc-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                                <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                                <li class="pc-item pc-hasmenu">
                                    <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i
                                                data-feather="chevron-right"></i></span></a>
                                    <ul class="pc-submenu">
                                        <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                                        <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link">Level 2.3<span class="pc-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                                <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                                <li class="pc-item pc-hasmenu">
                                    <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i
                                                data-feather="chevron-right"></i></span></a>
                                    <ul class="pc-submenu">
                                        <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a> </li>
                                        <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a> </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="pc-item"><a href="../other/sample-page.html" class="pc-link">
                        <span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-notification-status"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Sample page</span></a></li>
            </ul>
        </div>
    </div>
</nav>
