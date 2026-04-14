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
                                <h2 class="fw-bold">Edit Item</h2>
                                <p class="lead opacity-75 mb-0">Update item details and manage broken stock.</p>
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
                            <h2 class="fw-bold mb-1">Update Item Details</h2>
                            <p class="text-secondary small mb-0">
                                <i class="bi bi-info-circle me-1"></i> Ubah detail informasi barang atau catat penambahan
                                barang rusak.
                            </p>
                        </div>
                    </div>

                    <form id="editItemForm" action="{{ route('items.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-secondary">Name</label>
                                <input type="text" name="name" value="{{ old('name', $item->item_name) }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    style="padding: 12px; border-radius: 8px;">
                                @error('name')
                                    <div class="small mt-1" style="color: #d63384;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-secondary">Category</label>
                                <select name="category_id" id="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror"
                                    style="padding: 12px; border-radius: 8px;">
                                    <option value="" disabled
                                        {{ old('category_id', $item->category_id) ? '' : 'selected' }}>Pilih Category
                                    </option>

                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ (string) old('category_id', $item->category_id) === (string) $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <div class="small mt-1" style="color: #d63384;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-secondary">Total</label>
                                <div class="input-group">
                                    <input type="number" name="stock" value="{{ old('stock', $item->total_stock) }}"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        style="padding: 12px; border-radius: 8px 0 0 8px;">
                                    <span class="input-group-text bg-light text-muted px-3"
                                        style="border-radius: 0 8px 8px 0; border-left: none;">item</span>
                                </div>
                                @error('stock')
                                    <div class="small mt-1" style="color: #d63384;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label fw-bold text-secondary">
                                    New Broke Item <span style="color: #ea580c;">(currently:
                                        {{ $item->total_repaired }})</span>
                                </label>

                                <div class="input-group">
                                    <input type="number" name="new_repair" value="{{ old('new_repair', 0) }}"
                                        class="form-control @error('new_repair') is-invalid @enderror"
                                        style="padding: 12px; border-radius: 8px 0 0 8px;">
                                    <span class="input-group-text bg-light text-muted px-3"
                                        style="border-radius: 0 8px 8px 0; border-left: none;">item</span>
                                </div>

                                @error('new_repair')
                                    <div class="small mt-1" style="color: #d63384;">{{ $message }}</div>
                                @enderror

                                <small class="text-muted">
                                    Input angka jika terdapat barang rusak baru untuk menambah total repair.
                                </small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('items.index') }}" class="btn fw-bold px-4 py-2"
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

    <div class="modal fade" id="confirmUpdateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                <div class="modal-header border-0 pt-4 px-4 text-center d-block">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="bi bi-pencil-square text-primary fs-3"></i>
                    </div>
                    <h5 class="modal-title fw-bold">Konfirmasi Perubahan Item</h5>
                </div>
                <div class="modal-body px-4 text-center">
                    <p class="mb-0 fw-bold text-dark">Simpan perubahan data barang ini?</p>
                    <p class="small text-secondary mb-0">Pastikan jumlah stok dan data barang sudah benar. Perubahan akan
                        segera diperbarui di database.</p>
                </div>
                <div class="modal-footer border-0 pb-4 px-4 justify-content-center gap-2">
                    <button type="button" class="btn fw-bold px-4 py-2" data-bs-dismiss="modal"
                        style="background-color: #4b5563; color: white; border-radius: 8px;">Batal</button>

                    <button type="button" class="btn fw-bold px-4 py-2 text-white"
                        onclick="document.getElementById('editItemForm').submit()"
                        style="background-color: #2563eb; border-radius: 8px;">Ya, Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .modal-backdrop.show {
            opacity: 0.5;
        }

        .select2-container .select2-selection--single {
            height: 46px;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 8px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }
    </style>
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#category_id').select2({
                width: '100%',
                placeholder: 'Pilih Category'
            });
        });
    </script>
@endpush
