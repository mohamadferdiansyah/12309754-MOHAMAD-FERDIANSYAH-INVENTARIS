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
                                    <button type="button" class="btn text-white fw-bold px-4 py-2 shadow-sm"
                                        style="background-color: #7c3aed; border-radius: 8px;" data-bs-toggle="modal"
                                        data-bs-target="#exportModal">
                                        <i class="bi bi-file-earmark-spreadsheet me-2"></i> Export Excel
                                    </button>
                                    <a href="{{ route('lendings.create') }}"
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
                                    <th class="py-3 text-center">Bukti</th>
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
                                            {{ $lending->item?->item_name ?? '-' }}
                                        </td>

                                        <td>
                                            <span class="badge bg-light text-dark px-3 py-2 border fw-semibold fs-6">
                                                {{ $lending->total_item }}
                                            </span>
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $lending->name_of_borrower ?? '-' }}
                                        </td>

                                        <td class="fw-semibold text-secondary small">
                                            {{ $lending->notes ?? '-' }}
                                        </td>

                                        <td class="small text-secondary">
                                            {{ \Carbon\Carbon::parse($lending->date)->format('d F, Y') }}
                                        </td>

                                        <td class="text-center">
                                            @if ($lending->returned)
                                                <span class="badge bg-success text-white px-3 py-2 border">
                                                    {{ $lending->return_date ? \Carbon\Carbon::parse($lending->return_date)->format('d F, Y') : 'Returned' }}
                                                </span>
                                            @else
                                                <span class="badge bg-danger text-white px-3 py-2 border">Not
                                                    Returned</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('lendings.download-receipt', $lending->id) }}"
                                                target="_blank" class="btn btn-sm btn-outline-danger border-0">
                                                <i class="bi bi-file-pdf-fill fs-5"></i>
                                            </a>
                                        </td>

                                        <td>
                                            <span class="fw-bold">{{ $lending->user?->name ?? '-' }}</span>
                                        </td>

                                        @if (empty($isDetail) || !$isDetail)
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    @if (!$lending->returned)
                                                        <button type="button"
                                                            class="btn btn-sm text-white px-3 fw-bold shadow-sm btn-returned"
                                                            style="background-color: #ea580c; border-radius: 8px;"
                                                            data-bs-toggle="modal" data-bs-target="#returnedModal"
                                                            data-returned-url="{{ route('lendings.returned', $lending->id) }}"
                                                            data-item-name="{{ $lending->item?->item_name ?? '' }}"
                                                            data-total-item="{{ $lending->total_item }}">
                                                            <i class="bi bi-arrow-counterclockwise me-2"></i> Returned
                                                        </button>
                                                    @endif

                                                    <button type="button"
                                                        class="btn btn-sm text-white shadow-sm btn-delete-lending"
                                                        style="background-color: #dc2626; border-radius: 8px;"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        data-delete-url="{{ route('lendings.destroy', $lending->id) }}"
                                                        data-item-name="{{ $lending->item?->name ?? '' }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-secondary py-4">
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

    <!-- MODAL RETURNED (DENGAN INPUT KONDISI BARANG) -->
    <div class="modal fade" id="returnedModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                <div class="modal-header border-0 pt-4 px-4 text-center d-block">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="bi bi-arrow-counterclockwise text-warning fs-3"></i>
                    </div>
                    <h5 class="modal-title fw-bold">Konfirmasi Pengembalian</h5>
                </div>

                <form id="returnedForm" action="#" method="POST">
                    @csrf
                    <div class="modal-body px-4">
                        <!-- Info Barang -->
                        <div class="alert alert-info py-2 small border-0 mb-4"
                            style="background-color: #e0f2fe; color: #0369a1; border-radius: 8px;">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Item: <strong id="returnedItemName"></strong> | Total Dipinjam: <strong
                                id="totalItemBorrowed"></strong>
                        </div>

                        <p class="text-secondary small mb-3">Silahkan input kondisi barang saat dikembalikan:</p>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small fw-bold">Barang Kondisi Baik</label>
                                <input type="number" name="good_condition" id="input_good" class="form-control"
                                    value="0" min="0" style="border-radius: 8px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-warning">Barang Rusak</label>
                                <input type="number" name="broken" id="input_broken"
                                    class="form-control border-warning-subtle" value="0" min="0"
                                    style="border-radius: 8px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-danger">Barang Hilang</label>
                                <input type="number" name="missing" id="input_missing"
                                    class="form-control border-danger-subtle" value="0" min="0"
                                    style="border-radius: 8px;">
                            </div>
                        </div>

                        <div id="totalCheckWarning" class="mt-3 small text-danger d-none">
                            <i class="bi bi-exclamation-circle me-1"></i> Total input harus sama dengan jumlah dipinjam!
                        </div>
                    </div>

                    <div class="modal-footer border-0 pb-4 px-4 justify-content-center gap-2">
                        <button type="button" class="btn fw-bold px-4 py-2 shadow-sm" data-bs-dismiss="modal"
                            style="background-color: #f1f5f9; color: #475569; border-radius: 8px;">
                            Batal
                        </button>
                        <button type="submit" class="btn fw-bold px-4 py-2 text-white shadow-sm"
                            style="background-color: #ea580c; border-radius: 8px;">
                            Konfirmasi & Update Stok
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EXPORT EXCEL DENGAN TOGGLE FILTER -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-dark" id="exportModalLabel">Export Data Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('lendings.export.excel') }}" method="GET">
                    <div class="modal-body px-4">
                        <p class="text-secondary small mb-4">Pilih jenis data yang ingin Anda ekspor ke format Excel.</p>

                        <div class="mb-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="export_type" id="exportAll"
                                    value="all" checked>
                                <label class="form-check-label fw-bold text-dark" for="exportAll">
                                    Semua Data
                                </label>
                                <div class="text-muted small">Ekspor seluruh riwayat peminjaman tanpa batasan waktu.</div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="export_type" id="exportRange"
                                    value="range">
                                <label class="form-check-label fw-bold text-dark" for="exportRange">
                                    Berdasarkan Rentang Tanggal
                                </label>
                                <div class="text-muted small">Pilih tanggal mulai dan tanggal selesai peminjaman.</div>
                            </div>
                        </div>

                        <div id="dateRangeWrapper" style="display: none;" class="animate__animated animate__fadeInUp">
                            <div class="row border-top pt-3">
                                <div class="col-6 mb-3">
                                    <label class="form-label small fw-bold text-secondary">Dari Tanggal</label>
                                    <input type="date" name="from_date" id="from_date" class="form-control"
                                        style="border-radius: 8px;">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label small fw-bold text-secondary">Sampai Tanggal</label>
                                    <input type="date" name="to_date" id="to_date" class="form-control"
                                        style="border-radius: 8px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pb-4 px-4">
                        <button type="button" class="btn fw-bold px-4 py-2" data-bs-dismiss="modal"
                            style="background-color: #f1f5f9; color: #475569; border-radius: 8px;">Batal</button>

                        <button type="submit" class="btn text-white fw-bold px-4 py-2 shadow-sm"
                            style="background-color: #7c3aed; border-radius: 8px;">
                            <i class="bi bi-file-earmark-arrow-down me-2"></i> Download Excel
                        </button>
                    </div>
                </form>
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
            // Returned modal logic
            const returnedForm = document.getElementById('returnedForm');
            const returnedItemNameSpan = document.getElementById('returnedItemName');
            const totalItemBorrowedSpan = document.getElementById('totalItemBorrowed');
            const inputGood = document.getElementById('input_good');

            document.querySelectorAll('.btn-returned').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.getAttribute('data-returned-url');
                    const itemName = this.getAttribute('data-item-name');
                    const totalItem = this.getAttribute('data-total-item');

                    if (returnedForm) returnedForm.setAttribute('action', url);
                    if (returnedItemNameSpan) returnedItemNameSpan.textContent = itemName;
                    if (totalItemBorrowedSpan) totalItemBorrowedSpan.textContent = totalItem;

                    // Set default value barang baik sama dengan total yang dipinjam
                    if (inputGood) inputGood.value = totalItem;
                });
            });

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

            const exportAll = document.getElementById('exportAll');
            const exportRange = document.getElementById('exportRange');
            const dateRangeWrapper = document.getElementById('dateRangeWrapper');
            const fromDateInput = document.getElementById('from_date');
            const toDateInput = document.getElementById('to_date');

            function toggleDateRange() {
                if (exportRange.checked) {
                    dateRangeWrapper.style.display = 'block';
                    fromDateInput.setAttribute('required', 'required');
                    toDateInput.setAttribute('required', 'required');
                } else {
                    dateRangeWrapper.style.display = 'none';
                    fromDateInput.removeAttribute('required');
                    toDateInput.removeAttribute('required');
                    fromDateInput.value = '';
                    toDateInput.value = '';
                }
            }

            exportAll.addEventListener('change', toggleDateRange);
            exportRange.addEventListener('change', toggleDateRange);

            // NOTIFIKASI SUKSES + TOMBOL DOWNLOAD (Bukan Auto Popup)
            @if (session('pdf_url'))
                Swal.fire({
                    title: 'Berhasil Terkirim!',
                    text: 'Data peminjaman telah disimpan. Silahkan unduh struk sebagai bukti.',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#4b5563',
                    confirmButtonText: '<i class="bi bi-printer me-2"></i> Cetak Struk',
                    cancelButtonText: 'Tutup'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Hanya akan terbuka jika user mengklik tombol cetak
                        window.location.href = "{{ session('pdf_url') }}";
                    }
                });
            @endif
        });
    </script>
@endpush
