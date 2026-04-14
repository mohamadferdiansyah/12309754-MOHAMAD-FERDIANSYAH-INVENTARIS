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
                                <h2 class="fw-bold">Edit Category</h2>
                                <p class="lead opacity-75 mb-0">Modify existing category information.</p>
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
                            <h2 class="fw-bold mb-1">Edit Category</h2>
                            <p class="text-secondary small mb-0">
                                <i class="bi bi-info-circle me-1"></i> Ubah detail informasi pada kategori yang sudah ada.
                            </p>
                        </div>
                    </div>

                    <form id="editCategoryForm" action="{{ route('categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-secondary">Name</label>
                                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    style="padding: 12px; border-radius: 8px;">

                                @error('name')
                                    <div class="small mt-1" style="color: #d63384;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-secondary">Division PJ</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"
                                        style="border-radius: 8px 0 0 8px;">
                                        <i class="bi bi-people text-muted"></i>
                                    </span>
                                    <select name="division" class="form-select @error('division') is-invalid @enderror"
                                        style="padding: 12px; border-radius: 0 8px 8px 0;">
                                        @php
                                            $divisionValue = old('division', $category->division);
                                        @endphp

                                        <option value="Sarpras" {{ $divisionValue === 'Sarpras' ? 'selected' : '' }}>Sarpras
                                        </option>
                                        <option value="Tata Usaha" {{ $divisionValue === 'Tata Usaha' ? 'selected' : '' }}>
                                            Tata Usaha</option>
                                        <option value="Tefa" {{ $divisionValue === 'Tefa' ? 'selected' : '' }}>Tefa
                                        </option>
                                    </select>
                                </div>
                                @error('division')
                                    <div class="small mt-1" style="color: #d63384;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('categories.index') }}" class="btn fw-bold px-4 py-2"
                                style="background-color: #9ca3af; color: white; border-radius: 8px;">Cancel</a>

                            <button type="button" class="btn text-white fw-bold px-4 py-2"
                                style="background-color: #2563eb; border-radius: 8px;" data-bs-toggle="modal"
                                data-bs-target="#confirmUpdateModal">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL KONFIRMASI UPDATE -->
    <div class="modal fade" id="confirmUpdateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                <div class="modal-header border-0 pt-4 px-4 text-center d-block">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="bi bi-pencil-square text-primary fs-3"></i>
                    </div>
                    <h5 class="modal-title fw-bold">Konfirmasi Perubahan Data</h5>
                </div>
                <div class="modal-body px-4 text-center">
                    <p class="mb-0 fw-bold text-dark">Apakah Anda yakin ingin menyimpan perubahan?</p>
                    <p class="small text-secondary mb-0">Data kategori ini akan diperbarui di seluruh sistem inventaris.</p>
                </div>
                <div class="modal-footer border-0 pb-4 px-4 justify-content-center gap-2">
                    <button type="button" class="btn fw-bold px-4 py-2" data-bs-dismiss="modal"
                        style="background-color: #4b5563; color: white; border-radius: 8px;">Batal</button>

                    <button type="button" class="btn fw-bold px-4 py-2 text-white"
                        onclick="document.getElementById('editCategoryForm').submit()"
                        style="background-color: #2563eb; border-radius: 8px;">Ya, Simpan Perubahan</button>
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
