<nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm px-4">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-light d-md-none">
            <i class="bi bi-list"></i>
        </button>

        <div class="d-flex align-items-center ms-auto">
            <span class="text-muted me-4 d-none d-md-block">{{ date('d F, Y') }}</span>

            <div class="dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                    data-bs-toggle="dropdown">
                    @php
                        $user = auth()->user();
                    @endphp

                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D6EFD&color=fff"
                        width="35" class="rounded-circle me-2">

                    <p class="mb-0 fw-bold" style="font-size: 0.9rem;">{{ $user->name }}</p>
                    {{-- <small class="text-muted" style="font-size: 0.7rem;">
                    {{ $user->role === 'admin' ? 'Administrator' : 'Operator' }}
                    </small> --}}
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0"
                    style="border-radius: 12px; margin-top: 15px;">
                    <li>
                        <a class="dropdown-item text-danger d-flex align-items-center fw-bold" href="javascript:void(0)"
                            data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- LOGOUT MODAL -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 15px;">
            <div class="modal-header border-0 pt-4 px-4 text-center d-block">
                <div class="bg-danger bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                    <i class="bi bi-exclamation-circle text-danger fs-3"></i>
                </div>
                <h5 class="modal-title fw-bold" id="logoutModalLabel">Konfirmasi Logout</h5>
            </div>
            <div class="modal-body px-4 text-center">
                <p class="mb-0 fw-bold text-dark">Apakah Anda yakin ingin mengakhiri sesi ini?</p>
                <p class="small text-secondary mb-0">Anda harus login kembali untuk dapat mengakses sistem inventaris.
                </p>
            </div>
            <div class="modal-footer border-0 pb-4 px-4 justify-content-center gap-2">
                <button type="button" class="btn fw-bold px-4 py-2" data-bs-dismiss="modal"
                    style="background-color: #4b5563; color: white; border-radius: 8px;">Batal</button>

                <button type="button" class="btn fw-bold px-4 py-2 text-white"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    style="background-color: #dc2626; border-radius: 8px;">Ya, Logout</button>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

@push('css')
    <style>
        .modal-backdrop.show {
            opacity: 0.5;
        }
    </style>
@endpush
