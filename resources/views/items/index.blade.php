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
                                <p class="small fw-bold text-uppercase">Items Inventory Management</p>
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
                            <h2 class="fw-bold mb-1">Items Table</h2>
                            <p class="text-secondary small mb-0">
                                <i class="bi bi-info-circle me-1"></i> Daftar lengkap aset dan inventaris SMK Wikrama.
                            </p>
                        </div>
                        @if (auth()->user()->role === 'admin')
                            <div class="d-flex gap-2">
                                <a href="{{ route('items.export.excel') }}"
                                    class="btn text-white fw-bold px-4 py-2 shadow-sm"
                                    style="background-color: #7c3aed; border-radius: 8px;">
                                    <i class="bi bi-file-earmark-spreadsheet me-2"></i> Export Excel
                                </a>
                                <a href="{{ route('items.create') }}"
                                    class="btn btn-success d-flex align-items-center fw-bold px-4 py-2"
                                    style="background-color: #16a34a; border: none; border-radius: 8px;">
                                    <i class="bi bi-plus-lg me-2"></i> Add Item
                                </a>
                            </div>
                        @endif
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
                                    <th class="py-3">Category</th>
                                    <th class="py-3">Name</th>
                                    <th class="py-3 text-center">Total</th>

                                    @if (auth()->user()->role === 'staff')
                                        <th class="py-3 text-center">Available</th>
                                    @else
                                        <th class="py-3 text-center">Repair</th>
                                    @endif

                                    <th class="py-3 text-center">Lending</th>

                                    @if (auth()->user()->role === 'admin')
                                        <th class="py-3 text-center" style="width: 200px;">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                    <tr>
                                        <td class="px-4 fw-bold text-secondary">{{ $loop->iteration }}</td>
                                        <td class="fw-semibold">{{ $item->category?->name ?? '-' }}</td>
                                        <td class="fw-semibold text-secondary">{{ $item->item_name }}</td>

                                        <td class="text-center">
                                            <span class="badge bg-light text-dark px-3 py-2 border fs-6">
                                                {{ $item->total_stock }}
                                            </span>
                                        </td>

                                        @if (auth()->user()->role === 'staff')
                                            <td class="text-center">
                                                <span class="badge bg-success text-white px-3 py-2 border fs-6">
                                                    {{ $item->available }}
                                                </span>
                                            </td>
                                        @else
                                            <td class="text-center">
                                                <span class="badge bg-warning text-dark px-3 py-2 border fs-6">
                                                    {{ $item->total_repaired }}
                                                </span>
                                            </td>
                                        @endif

                                        <td class="text-center">
                                            <a href="{{ route('lendings.index', ['item_id' => $item->id]) }}"
                                                    class="badge text-decoration-none bg-info text-dark px-3 py-2 border fs-6">
                                                    {{ $item->total_borrowed }}
                                                </>
                                        </td>

                                        @if (auth()->user()->role === 'admin')
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('items.edit', $item->id) }}"
                                                        class="btn btn-sm text-white px-3 fw-bold shadow-sm"
                                                        style="background-color: #2563eb; border-radius: 8px;">
                                                        <i class="bi bi-pencil-square me-2"></i> Edit
                                                    </a>

                                                    <button type="button"
                                                        class="btn btn-sm text-white shadow-sm btn-delete-item"
                                                        style="background-color: #dc2626; border-radius: 8px;"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        data-delete-url="{{ route('items.destroy', $item->id) }}"
                                                        data-item-name="{{ $item->name }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-secondary py-4">
                                            Data item belum ada.
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
                    <h5 class="modal-title fw-bold" id="deleteModalLabel">Konfirmasi Hapus Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="bi bi-exclamation-triangle text-danger fs-3"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-bold text-dark">
                                Apakah Anda yakin ingin menghapus barang <span id="deleteItemName"></span>?
                            </p>
                            <p class="small text-secondary mb-0">Seluruh data terkait stok dan riwayat peminjaman barang ini
                                juga akan hilang.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn fw-bold px-4 py-2" data-bs-dismiss="modal"
                        style="background-color: #4b5563; color: white; border-radius: 8px;">
                        Batal
                    </button>

                    <form id="deleteItemForm" action="#" method="POST" class="m-0">
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
            const deleteForm = document.getElementById('deleteItemForm');
            const nameSpan = document.getElementById('deleteItemName');

            document.querySelectorAll('.btn-delete-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.getAttribute('data-delete-url');
                    const name = this.getAttribute('data-item-name');

                    deleteForm.setAttribute('action', url);
                    if (nameSpan) nameSpan.textContent = name;
                });
            });
        });
    </script>
@endpush
