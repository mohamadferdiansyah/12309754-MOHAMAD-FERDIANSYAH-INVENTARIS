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
                                <p class="small fw-bold text-uppercase">Categories Data Management</p>
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
                            <h2 class="fw-bold mb-1">Categories Table</h2>
                            <p class="text-secondary small mb-0">
                                <i class="bi bi-info-circle me-1"></i> Kelola data kategori untuk pengelompokan barang
                                inventaris.
                            </p>
                        </div>
                        <a href="{{ route('categories.create') }}" class="btn d-flex align-items-center fw-bold px-4 py-2"
                            style="background-color: #16a34a; color: white; border: none; border-radius: 8px;">
                            <i class="bi bi-plus-lg me-2"></i> Add Category
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="text-secondary small text-uppercase">
                                <tr>
                                    <th class="py-3 px-4" style="width: 80px;">#</th>
                                    <th class="py-3">Name</th>
                                    <th class="py-3">Division PJ</th>
                                    <th class="py-3 text-center">Total Items</th>
                                    <th class="py-3 text-center" style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td class="px-4 fw-bold text-secondary">{{ $loop->iteration }}</td>
                                        <td class="fw-semibold">{{ $category->name }}</td>
                                        <td class="fw-semibold">{{ $category->division }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark px-3 py-2 border fs-6">
                                                {{ $category->items_count }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('categories.edit', $category->id) }}"
                                                    class="btn btn-sm text-white px-3 fw-bold shadow-sm"
                                                    style="background-color: #2563eb; border-radius: 8px;">
                                                    <i class="bi bi-pencil-square me-2"></i> Edit
                                                </a>

                                                <button type="button"
                                                    class="btn btn-sm text-white shadow-sm btn-delete-category"
                                                    style="background-color: #dc2626; border-radius: 8px;"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    data-delete-url="{{ route('categories.destroy', $category->id) }}"
                                                    data-delete-url=""
                                                    data-category-name="{{ $category->name }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-secondary py-4">
                                            Data kategori belum ada.
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
                    <h5 class="modal-title fw-bold" id="deleteModalLabel">Konfirmasi Hapus</h5>
                </div>
                <div class="modal-body px-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="bi bi-exclamation-triangle text-danger fs-3"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-bold text-dark">
                                Apakah Anda yakin ingin menghapus kategori <span id="deleteCategoryName"></span>?
                            </p>
                            <p class="small text-secondary mb-0">Tindakan ini tidak dapat dibatalkan dan data akan hilang
                                permanen.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn fw-bold px-4 py-2" data-bs-dismiss="modal"
                        style="background-color: #4b5563; color: white; border-radius: 8px;">
                        Batal
                    </button>

                    <form id="deleteCategoryForm" action="#" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn fw-bold px-4 py-2"
                            style="background-color: #dc2626; color: white; border-radius: 8px;">
                            Ya, Hapus
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

        .modal-backdrop.show {
            opacity: 0.5;
        }
    </style>
@endpush

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForm = document.getElementById('deleteCategoryForm');
            const nameSpan = document.getElementById('deleteCategoryName');

            document.querySelectorAll('.btn-delete-category').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.getAttribute('data-delete-url');
                    const name = this.getAttribute('data-category-name');

                    deleteForm.setAttribute('action', url);
                    if (nameSpan) nameSpan.textContent = name;
                });
            });
        });
    </script>
@endpush
