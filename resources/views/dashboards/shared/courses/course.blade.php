<x-app-layout>

    @include('components.alerts')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Course</h5>
                        @if (Auth::user() && Auth::user()->role === 'admin')
                            <div>
                                <a href="../admins/course-course-add.html" class="btn btn-primary">Add Course</a>
                            </div>
                        @endif

                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-lg-4 col-xxl-3">
                            <div class="card border">
                                <div class="card-body p-2">
                                    <div class="position-relative">
                                        <img src="../assets/images/admin/img-course-1.png" alt="img"
                                            class="img-fluid w-100" />
                                        @if ('date' == 'new')
                                            <div class="position-absolute top-0 end-0 p-2">
                                                <span class="badge text-bg-light text-uppercase">Free</span>
                                            </div>
                                        @endif
                                    </div>
                                    <ul class="list-group list-group-flush my-2">
                                        <li class="list-group-item px-0 py-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 me-2">
                                                    <h6 class="mb-1">
                                                        Bootstrap 5 Beginner Course
                                                    </h6>
                                                    <p class="mb-0 f-w-600">
                                                        <i class="fas fa-star text-warning"></i> 4.8
                                                    </p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <a href="#" class="avtar avtar-xs btn-link-secondary">
                                                        <i class="ti ti-edit f-20"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0 py-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 me-2">
                                                    <p class="mb-0">Duration</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <p class="text-muted mb-0">10 Months</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0 py-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 me-2">
                                                    <p class="mb-0">Teacher</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <p class="text-muted mb-0">Jimmy Morris</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0 py-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 me-2">
                                                    <p class="mb-0">Students</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <p class="text-muted mb-0">+120</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <button class="btn btn-sm btn-outline-primary mb-2">
                                        Read More
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 col-xxl-3">
                            <div class="card border">
                                <div class="card-body p-2">
                                    <div class="position-relative">
                                        <img src="../assets/images/admin/img-course-1.png" alt="img"
                                            class="img-fluid w-100" />
                                        @if ('date' == 'new')
                                            <div class="position-absolute top-0 end-0 p-2">
                                                <span class="badge text-bg-light text-uppercase">Free</span>
                                            </div>
                                        @endif
                                    </div>
                                    <ul class="list-group list-group-flush my-2">
                                        <li class="list-group-item px-0 py-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 me-2">
                                                    <h6 class="mb-1">
                                                        Bootstrap 5 Beginner Course
                                                    </h6>
                                                    <p class="mb-0 f-w-600">
                                                        <i class="fas fa-star text-warning"></i> 4.8
                                                    </p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <a href="#" class="avtar avtar-xs btn-link-secondary">
                                                        <i class="ti ti-edit f-20"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0 py-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 me-2">
                                                    <p class="mb-0">Duration</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <p class="text-muted mb-0">10 Months</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0 py-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 me-2">
                                                    <p class="mb-0">Teacher</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <p class="text-muted mb-0">Jimmy Morris</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0 py-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 me-2">
                                                    <p class="mb-0">Students</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <p class="text-muted mb-0">+120</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <button class="btn btn-sm btn-outline-primary mb-2">
                                        Read More
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
