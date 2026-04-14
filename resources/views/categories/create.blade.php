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
                                <h2 class="fw-bold">Add Category</h2>
                                <p class="lead opacity-75 mb-0">Create a new classification for items.</p>
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
                            <h2 class="fw-bold mb-1">Create Category</h2>
                            <p class="text-secondary small mb-0">
                                <i class="bi bi-info-circle me-1"></i> Tambahkan kategori baru untuk mengelompokkan barang
                                inventaris.
                            </p>
                        </div>
                    </div>

                    <form id="categoryForm" action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-secondary">Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Masukan nama kategori" style="padding: 12px; border-radius: 8px;">
                                @error('name')
                                    <div class="small mt-1" style="color: #d63384;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Division PJ Select -->
                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-secondary">Division PJ</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"
                                        style="border-radius: 8px 0 0 8px;">
                                        <i class="bi bi-people text-muted"></i>
                                    </span>
                                    <select name="division" class="form-select @error('division') is-invalid @enderror"
                                        style="padding: 12px; border-radius: 0 8px 8px 0;">
                                        <option value="" disabled selected>Select Division PJ
                                        </option>
                                        <option value="Sarpras">Sarpras
                                        </option>
                                        <option value="Tata Usaha">
                                            Tata Usaha</option>
                                        <option value="Tefa">Tefa</option>
                                    </select>
                                </div>
                                @error('division')
                                    <div class="small mt-1" style="color: #d63384;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <a href="{{ route('categories.index') }}" class="btn fw-bold px-4 py-2"
                                    style="background-color: #9ca3af; color: white; border-radius: 8px;">Cancel</a>

                                <button type="button" class="btn text-white fw-bold px-4 py-2"
                                    style="background-color: #2563eb; border-radius: 8px;" data-bs-toggle="modal"
                                    data-bs-target="#confirmSubmitModal">
                                    Submit
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL KONFIRMASI SUBMIT -->
    <div class="modal fade" id="confirmSubmitModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                <div class="modal-header border-0 pt-4 px-4 text-center d-block">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="bi bi-cloud-upload text-primary fs-3"></i>
                    </div>
                    <h5 class="modal-title fw-bold">Konfirmasi Simpan Data</h5>
                </div>
                <div class="modal-body px-4 text-center">
                    <p class="mb-0 fw-bold text-dark">Apakah data yang Anda masukkan sudah benar?</p>
                    <p class="small text-secondary mb-0">Pastikan Nama Kategori dan Divisi PJ sudah sesuai sebelum disimpan
                        ke sistem.</p>
                </div>
                <div class="modal-footer border-0 pb-4 px-4 justify-content-center gap-2">
                    <button type="button" class="btn fw-bold px-4 py-2" data-bs-dismiss="modal"
                        style="background-color: #4b5563; color: white; border-radius: 8px;">Batal</button>

                    <!-- Button Submit Sesungguhnya -->
                    <button type="button" class="btn fw-bold px-4 py-2 text-white"
                        onclick="document.getElementById('categoryForm').submit()"
                        style="background-color: #2563eb; border-radius: 8px;">Ya, Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .form-control:focus,
        .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.1);
        }

        .modal-backdrop.show {
            opacity: 0.5;
        }
    </style>
@endpush
