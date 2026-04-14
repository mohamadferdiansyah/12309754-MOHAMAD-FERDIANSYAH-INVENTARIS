@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        <div style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ asset('assets/img/wk.jpg') }}'); 
                                                                            background-size: cover; background-position: center; height: 250px;"
                            class="d-flex align-items-center px-5 text-white">
                            <div>
                                <h1 class="display-5 fw-bold">Welcome Back, {{ auth()->user()->name }}</h1>
                                <p class="lead opacity-75">Sistem Manajemen Inventaris SMK Wikrama Bogor.</p>
                                <hr class="w-25 border-2 opacity-100 mt-4">
                                <p class="small fw-bold text-uppercase">USER OPERATOR MANAGEMENT</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="fw-bold mb-1">Operator Accounts Table</h2>
                            <p class="text-secondary small mb-0">
                                <i class="bi bi-info-circle me-1"></i> Kelola akun pengguna operator.
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('users.operator.export.excel') }}" class="btn text-white fw-bold px-4 py-2 shadow-sm"
                                style="background-color: #7c3aed; border-radius: 8px;">
                                <i class="bi bi-file-earmark-spreadsheet me-2"></i> Export Excel
                            </a>
                            <a href="{{ route('users.create') }}"
                                class="btn btn-success d-flex align-items-center fw-bold px-4 py-2"
                                style="background-color: #16a34a; border: none; border-radius: 8px;">
                                <i class="bi bi-file-earmark-plus me-2"></i> Add Account
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="text-secondary small text-uppercase">
                                <tr>
                                    <th class="py-3 px-4" style="width: 80px;">#</th>
                                    <th class="py-3">Name</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3 text-center" style="width: 250px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-4 fw-bold text-secondary">{{ $loop->iteration }}</td>
                                        <td class="fw-semibold">{{ $user->name }}</td>
                                        <td class="fw-semibold">{{ $user->email }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button type="button"
                                                    class="btn btn-sm text-white px-3 fw-bold shadow-sm btn-reset-password"
                                                    style="background-color: #ea580c; border-radius: 8px;"
                                                    data-bs-toggle="modal" data-bs-target="#resetPasswordModal"
                                                    data-reset-url="{{ route('users.reset-password', $user->id) }}"
                                                    data-user-name="{{ $user->name }}">
                                                    <i class="bi bi-arrow-counterclockwise me-2"></i> Reset Password
                                                </button>

                                                <button type="button"
                                                    class="btn btn-sm text-white shadow-sm btn-delete-user"
                                                    style="background-color: #dc2626; border-radius: 8px;"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    data-delete-url="{{ route('users.destroy', $user->id) }}"
                                                    data-user-name="{{ $user->name }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-secondary py-4">
                                            Belum ada akun operator.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DELETE MODAL -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" id="deleteModalLabel">Hapus Akun Operator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="bi bi-person-x text-danger fs-3"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-bold text-dark">
                                Hapus akun operator <span id="deleteUserName"></span>?
                            </p>
                            <p class="small text-secondary mb-0">Operator ini tidak akan bisa lagi melakukan input data
                                peminjaman jika akun dihapus.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn fw-bold px-4 py-2" data-bs-dismiss="modal"
                        style="background-color: #4b5563; color: white; border-radius: 8px;">
                        Batal
                    </button>

                    <form id="deleteUserForm" action="#" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn fw-bold px-4 py-2"
                            style="background-color: #dc2626; color: white; border-radius: 8px;">
                            Ya, Hapus Akun
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- RESET PASSWORD MODAL -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">Reset Password Operator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body px-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="bi bi-arrow-counterclockwise text-warning fs-3"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-bold text-dark">
                                Reset password untuk <span id="resetUserName"></span>?
                            </p>
                            <p class="small text-secondary mb-0">
                                Password akan dikembalikan ke format default (4 karakter awal email + nomor akun).
                            </p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn fw-bold px-4 py-2" data-bs-dismiss="modal"
                        style="background-color: #4b5563; color: white; border-radius: 8px;">
                        Batal
                    </button>

                    <form id="resetPasswordForm" action="#" method="POST" class="m-0">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn fw-bold px-4 py-2 text-white"
                            style="background-color: #ea580c; border-radius: 8px;">
                            Ya, Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .table thead th {
            border-bottom: 1px solid #f0f0f0;
            background-color: #fafafa;
            font-weight: 700;
        }

        .table tbody td {
            border-bottom: 1px solid #f8f9fa;
            color: #333;
        }

        .table-hover tbody tr:hover {
            background-color: #fcfdfe;
        }

        .btn:hover {
            filter: brightness(90%);
            transition: 0.2s;
        }

        .modal-backdrop.show {
            opacity: 0.5;
        }
    </style>
@endpush

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resetForm = document.getElementById('resetPasswordForm');
            const resetNameSpan = document.getElementById('resetUserName');

            document.querySelectorAll('.btn-reset-password').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.getAttribute('data-reset-url');
                    const name = this.getAttribute('data-user-name');

                    resetForm.setAttribute('action', url);
                    if (resetNameSpan) resetNameSpan.textContent = name;
                });
            });

            const deleteForm = document.getElementById('deleteUserForm');
            const nameSpan = document.getElementById('deleteUserName');

            document.querySelectorAll('.btn-delete-user').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.getAttribute('data-delete-url');
                    const name = this.getAttribute('data-user-name');

                    deleteForm.setAttribute('action', url);
                    if (nameSpan) nameSpan.textContent = name;
                });
            });
        });
    </script>
@endpush
