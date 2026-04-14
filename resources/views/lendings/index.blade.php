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
                                <p class="small fw-bold text-uppercase">Lending Items Management</p>
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
                            <h2 class="fw-bold mb-1">Lendings Table</h2>
                            <p class="text-secondary small mb-0">
                                <i class="bi bi-info-circle me-1"></i> Pantau lalu lintas peminjaman dan pengembalian
                                barang.
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="d-flex gap-2">
                                @if (!empty($isDetail) && $isDetail)
                                    <a href="{{ route('items.index') }}" class="btn fw-bold px-4 py-2 shadow-sm"
                                        style="background-color: #9ca3af; color: white; border-radius: 8px;">
                                        Back
                                    </a>
                                @else
                                    <a href=""
                                        class="btn text-white fw-bold px-4 py-2 shadow-sm"
                                        style="background-color: #7c3aed; border-radius: 8px;">
                                        <i class="bi bi-file-earmark-spreadsheet me-2"></i> Export Excel
                                    </a>
                                    <a href=""
                                        class="btn btn-success d-flex align-items-center fw-bold px-4 py-2 shadow-sm"
                                        style="background-color: #16a34a; border: none; border-radius: 8px;">
                                        <i class="bi bi-plus-lg me-2"></i> Add Lending
                                    </a>
                                @endif
                            </div>
                        </div>
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
                                    <th class="py-3">Item</th>
                                    <th class="py-3">Total</th>
                                    <th class="py-3">Name</th>
                                    <th class="py-3">Ket.</th>
                                    <th class="py-3">Date</th>
                                    <th class="py-3 text-center">Returned</th>
                                    <th class="py-3">Edited By</th>
                                    @if (empty($isDetail) || !$isDetail)
                                        <th class="py-3 text-center" style="width: 200px;">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lendings as $lending)
                                    <tr>
                                        <td class="px-4 fw-bold text-secondary">{{ $loop->iteration }}</td>

                                        <td class="fw-semibold">
                                            {{ $lending->item?->name ?? '-' }}
                                        </td>

                                        <td>
                                            <span class="badge bg-light text-dark px-3 py-2 border fw-semibold fs-6">
                                                {{ $lending->qty }}
                                            </span>
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $lending->borrower_name ?? '-' }}
                                        </td>

                                        <td class="fw-semibold text-secondary small">
                                            {{ $lending->description ?? '-' }}
                                        </td>

                                        <td class="small text-secondary">
                                            {{ \Carbon\Carbon::parse($lending->date)->format('d F, Y') }}
                                        </td>

                                        <td class="text-center">
                                            @if ($lending->status === 'returned')
                                                <span class="badge bg-success text-white px-3 py-2 border">
                                                    {{ $lending->return_date ? \Carbon\Carbon::parse($lending->return_date)->format('d F, Y') : 'Returned' }}
                                                </span>
                                            @else
                                                <span class="badge bg-danger text-white px-3 py-2 border">Not
                                                    Returned</span>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="fw-bold">{{ $lending->user?->name ?? '-' }}</span>
                                        </td>

                                        @if (empty($isDetail) || !$isDetail)
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    @if ($lending->status === 'borrowed')
                                                        <button type="button"
                                                            class="btn btn-sm text-white px-3 fw-bold shadow-sm btn-returned"
                                                            style="background-color: #ea580c; border-radius: 8px;"
                                                            data-bs-toggle="modal" data-bs-target="#returnedModal"
                                                            {{-- data-returned-url="{{ route('lendings.returned', $lending->id) }}" --}}
                                                            data-returned-url=""
                                                            data-item-name="{{ $lending->item?->name ?? '' }}">
                                                            <i class="bi bi-arrow-counterclockwise me-2"></i> Returned
                                                        </button>
                                                    @endif

                                                    <button type="button"
                                                        class="btn btn-sm text-white shadow-sm btn-delete-lending"
                                                        style="background-color: #dc2626; border-radius: 8px;"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        {{-- data-delete-url="{{ route('lendings.destroy', $lending->id) }}" --}}
                                                        data-delete-url=""
                                                        data-item-name="{{ $lending->item?->name ?? '' }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-secondary py-4">
                                            Data lending belum ada.
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

    <!-- MODAL RETURNED -->
    <div class="modal fade" id="returnedModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                <div class="modal-header border-0 pt-4 px-4 text-center d-block">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="bi bi-arrow-counterclockwise text-warning fs-3"></i>
                    </div>
                    <h5 class="modal-title fw-bold">Konfirmasi Pengembalian</h5>
                </div>
                <div class="modal-body px-4 text-center">
                    <p class="mb-0 fw-bold text-dark">
                        Apakah barang <span id="returnedItemName"></span> sudah dikembalikan?
                    </p>
                    <p class="small text-secondary mb-0">Status peminjaman akan berubah menjadi 'Returned' dan stok barang
                        akan bertambah secara otomatis.</p>
                </div>
                <div class="modal-footer border-0 pb-4 px-4 justify-content-center gap-2">
                    <button type="button" class="btn fw-bold px-4 py-2" data-bs-dismiss="modal"
                        style="background-color: #4b5563; color: white; border-radius: 8px;">
                        Batal
                    </button>

                    <form id="returnedForm" action="#" method="POST" class="m-0">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn fw-bold px-4 py-2"
                            style="background-color: #ea580c; color: white; border-radius: 8px;">
                            Ya, Konfirmasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">Hapus Riwayat Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="bi bi-trash text-danger fs-3"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-bold text-dark">
                                Hapus data peminjaman <span id="deleteLendingItemName"></span>?
                            </p>
                            <p class="small text-secondary mb-0">Tindakan ini akan menghapus catatan riwayat tanpa
                                mempengaruhi stok barang saat ini.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn fw-bold px-4 py-2" data-bs-dismiss="modal"
                        style="background-color: #4b5563; color: white; border-radius: 8px;">
                        Batal
                    </button>

                    <form id="deleteLendingForm" action="#" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn fw-bold px-4 py-2"
                            style="background-color: #dc2626; color: white; border-radius: 8px;">
                            Hapus Data
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
            filter: brightness(95%);
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
            // Returned modal
            const returnedForm = document.getElementById('returnedForm');
            const returnedItemNameSpan = document.getElementById('returnedItemName');

            document.querySelectorAll('.btn-returned').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.getAttribute('data-returned-url');
                    const itemName = this.getAttribute('data-item-name');

                    if (returnedForm) returnedForm.setAttribute('action', url);
                    if (returnedItemNameSpan) returnedItemNameSpan.textContent = itemName;
                });
            });

            // Delete modal
            const deleteForm = document.getElementById('deleteLendingForm');
            const deleteItemNameSpan = document.getElementById('deleteLendingItemName');

            document.querySelectorAll('.btn-delete-lending').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.getAttribute('data-delete-url');
                    const itemName = this.getAttribute('data-item-name');

                    if (deleteForm) deleteForm.setAttribute('action', url);
                    if (deleteItemNameSpan) deleteItemNameSpan.textContent = itemName;
                });
            });
        });
    </script>
@endpush
