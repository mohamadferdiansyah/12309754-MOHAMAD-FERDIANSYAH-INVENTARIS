@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        <div style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ asset('assets/img/wk.jpg') }}'); 
                                                    background-size: cover; background-position: center; height: 200px;"
                            class="d-flex align-items-center px-5 text-white">
                            <div>
                                <h2 class="fw-bold">Add New Account</h2>
                                <p class="lead opacity-75 mb-0">Create a new user account and assign their access level.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4 justify-content-center">
            <div class="col-12">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="fw-bold mb-1">Register Account</h2>
                            <p class="text-secondary small mb-0">
                                <i class="bi bi-info-circle me-1"></i> Daftarkan akun baru dan tentukan hak akses (role)
                                pengguna.
                            </p>
                        </div>
                    </div>

                    <form id="userForm" action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-secondary">Full Name</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control px-3 py-2 @error('name') is-invalid @enderror"
                                    placeholder="Masukan Nama" style="border-radius: 8px;">

                                @error('name')
                                    <div class="small mt-1" style="color: #d63384;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-secondary">Email Address</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control px-3 py-2 @error('email') is-invalid @enderror"
                                    placeholder="Masukan Email" style="border-radius: 8px;">

                                @error('email')
                                    <div class="small mt-1" style="color: #d63384;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-secondary">Access Role</label>
                                <select name="role" class="form-select px-3 py-2 @error('role') is-invalid @enderror"
                                    style="border-radius: 8px;">
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select Role</option>
                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>admin</option>
                                    <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>staff
                                    </option>
                                </select>

                                @error('role')
                                    <div class="small mt-1" style="color: #d63384;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('users.admin') }}" class="btn fw-bold px-5 py-2"
                                style="background-color: #4b5563; color: white; border-radius: 8px;">Cancel</a>

                            <button type="button" class="btn text-white fw-bold px-5 py-2"
                                style="background-color: #2563eb; border-radius: 8px;" data-bs-toggle="modal"
                                data-bs-target="#confirmUserModal">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                <div class="modal-header border-0 pt-4 px-4 text-center d-block">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="bi bi-person-plus text-primary fs-3"></i>
                    </div>
                    <h5 class="modal-title fw-bold">Daftarkan Pengguna Baru</h5>
                </div>
                <div class="modal-body px-4 text-center">
                    <p class="mb-0 fw-bold text-dark">Apakah data pengguna sudah benar?</p>
                    <p class="small text-secondary mb-0">Password default akan dibuat secara otomatis (4 karakter awal email
                        + nomor). Akun akan langsung aktif setelah disimpan.</p>
                </div>
                <div class="modal-footer border-0 pb-4 px-4 justify-content-center gap-2">
                    <button type="button" class="btn fw-bold px-4 py-2" data-bs-dismiss="modal"
                        style="background-color: #4b5563; color: white; border-radius: 8px;">Periksa Lagi</button>

                    <button type="button" class="btn fw-bold px-4 py-2 text-white"
                        onclick="document.getElementById('userForm').submit()"
                        style="background-color: #2563eb; border-radius: 8px;">Ya, Daftarkan Akun</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .modal-backdrop.show {
            opacity: 0.5;
        }
    </style>
@endpush
