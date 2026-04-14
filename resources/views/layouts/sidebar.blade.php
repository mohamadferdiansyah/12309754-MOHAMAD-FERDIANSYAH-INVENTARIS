<nav id="sidebar" class="bg-dark text-white" style="width: 260px; min-height: 100vh; position: fixed;">
    <div class="p-4">
        <div class="d-flex align-items-center mb-4">
            <img src="{{ asset('assets/img/app_icon.png') }}" width="35" alt="Logo">
            <span class="fs-4 fw-bold ms-2">Inventaris</span>
        </div>

        @php
            $role = auth()->user()?->role;
        @endphp

        @if ($role === 'admin')
            <div class="mb-4">
                <small class="text-secondary text-uppercase fw-bold"
                    style="font-size: 0.7rem; letter-spacing: 1px;">Menu</small>
                <ul class="nav flex-column mt-2">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.index') }}"
                            class="nav-link text-white {{ request()->is('dashboard*') ? 'bg-primary rounded' : 'opacity-75' }}">
                            <i class="bi bi-grid-fill me-2"></i> Dashboard
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mb-4">
                <small class="text-secondary text-uppercase fw-bold"
                    style="font-size: 0.7rem; letter-spacing: 1px;">Items
                    Data</small>
                <ul class="nav flex-column mt-2 gap-2">
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}"
                            class="nav-link text-white {{ request()->is('categories*') ? 'bg-primary rounded' : 'opacity-75' }}">
                            <i class="bi bi-ui-checks-grid me-2"></i> Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('items.index') }}"
                            class="nav-link text-white {{ request()->is('items*') ? 'bg-primary rounded' : 'opacity-75' }}">
                            <i class="bi bi-box-seam me-2"></i> Items
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mb-4">
                <small class="text-secondary text-uppercase fw-bold"
                    style="font-size: 0.7rem; letter-spacing: 1px;">Accounts</small>
                <ul class="nav flex-column mt-2">
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('users*') ? '' : 'opacity-75' }}"
                            data-bs-toggle="collapse" href="#userDropdown" role="button"
                            aria-expanded="{{ request()->is('users*') ? 'true' : 'false' }}">
                            <span><i class="bi bi-people me-2"></i> Users</span>
                            <i class="bi bi-chevron-down small"></i>
                        </a>

                        <div class="collapse {{ request()->is('users*') ? 'show' : '' }}" id="userDropdown">
                            <ul class="nav flex-column ms-4 mt-1 gap-2">
                                <li class="nav-item">
                                    <a href="{{ route('users.admin') }}"
                                        class="nav-link text-white {{ request()->is('users/admin*') || request()->is('users/admins*') ? 'bg-primary rounded' : 'opacity-75' }}">
                                        <i class="bi bi-person-badge me-2"></i> Admin
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('users.operator') }}"
                                        class="nav-link text-white {{ request()->is('users/operator*') || request()->is('users/operators*') ? 'bg-primary rounded' : 'opacity-75' }}">
                                        <i class="bi bi-person me-2"></i> Operator
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        @elseif ($role === 'staff')
            <div class="mb-4">
                <small class="text-secondary text-uppercase fw-bold"
                    style="font-size: 0.7rem; letter-spacing: 1px;">Menu</small>
                <ul class="nav flex-column mt-2">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.index') }}"
                            class="nav-link text-white {{ request()->is('dashboard*') ? 'bg-primary rounded' : 'opacity-75' }}">
                            <i class="bi bi-grid-fill me-2"></i> Dashboard
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mb-4">
                <small class="text-secondary text-uppercase fw-bold"
                    style="font-size: 0.7rem; letter-spacing: 1px;">Menu</small>
                <ul class="nav flex-column mt-2 gap-2">
                    <li class="nav-item">
                        <a href="{{ route('items.index') }}"
                            class="nav-link text-white {{ request()->is('items*') ? 'bg-primary rounded' : 'opacity-75' }}">
                            <i class="bi bi-box-seam me-2"></i> Items
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('lendings.index') }}"
                            class="nav-link text-white {{ request()->is('lendings*') ? 'bg-primary rounded' : 'opacity-75' }}">
                            <i class="bi bi-arrow-left-right me-2"></i> Lending
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mb-4">
                <small class="text-secondary text-uppercase fw-bold"
                    style="font-size: 0.7rem; letter-spacing: 1px;">Accounts</small>
                <ul class="nav flex-column mt-2">
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('users*') ? '' : 'opacity-75' }}"
                            data-bs-toggle="collapse" href="#userDropdown" role="button"
                            aria-expanded="{{ request()->is('users*') ? 'true' : 'false' }}">
                            <span><i class="bi bi-people me-2"></i> Users</span>
                            <i class="bi bi-chevron-down small"></i>
                        </a>

                        <div class="collapse {{ request()->is('users*') ? 'show' : '' }}" id="userDropdown">
                            <ul class="nav flex-column ms-4 mt-1 gap-2">
                                <li class="nav-item">
                                    <a href="{{ route('users.edit', auth()->id()) }}"
                                        class="nav-link text-white {{ request()->is('users/' . auth()->id() . '/edit') ? 'bg-primary rounded' : 'opacity-75' }}">
                                        <i class="bi bi-person-circle me-2"></i> My Profile
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</nav>
