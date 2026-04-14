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
                                <h2 class="fw-bold">Create Lending</h2>
                                <p class="lead opacity-75 mb-0">Record a new item lending transaction.</p>
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
                            <h2 class="fw-bold mb-1">New Lending Transaction</h2>
                            <p class="text-secondary small mb-0">
                                <i class="bi bi-info-circle me-1"></i> Catat transaksi peminjaman barang secara lengkap dan
                                akurat.
                            </p>
                        </div>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form id="lendingForm" action="{{ route('lendings.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Borrower Name</label>
                            <input type="text" name="borrower_name" value="{{ old('borrower_name') }}"
                                class="form-control px-3 py-2 @error('borrower_name') is-invalid @enderror"
                                placeholder="Masukan nama peminjam" style="border-radius: 8px;">

                            @error('borrower_name')
                                <div class="small mt-1" style="color: #d63384;">{{ $message }}</div>
                            @enderror
                        </div>


                        <div id="items-container">
                            <div class="item-row bg-light p-3 rounded-3 mb-3 border border-dashed">
                                <div class="row">
                                    <div class="col-md-8 mb-3 mb-md-0">
                                        <label class="form-label fw-bold text-secondary small">Select Item</label>
                                        <select name="items[0][item_id]"
                                            class="form-select px-3 py-2 @error('items.0.item_id') is-invalid @enderror"
                                            style="border-radius: 8px;">
                                            <option value="" disabled {{ old('items.0.item_id') ? '' : 'selected' }}>
                                                Pilih
                                                Barang</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ (string) old('items.0.item_id') === (string) $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }} (available: {{ $item->available }})
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('items.0.item_id')
                                            <div class="small mt-1" style="color: #d63384;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-secondary small">Total Item</label>
                                        <input type="number" name="items[0][qty]" value="{{ old('items.0.qty') }}"
                                            class="form-control px-3 py-2 @error('items.0.qty') is-invalid @enderror"
                                            placeholder="0" style="border-radius: 8px;">

                                        @error('items.0.qty')
                                            <div class="small mt-1" style="color: #d63384;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <a href="javascript:void(0)" id="add-item"
                                class="btn btn-sm d-inline-flex align-items-center fw-bold shadow-sm"
                                style="color: #0891b2; background-color: #ecfeff; border: 1px solid #cffafe; border-radius: 8px; padding: 8px 15px;">
                                <i class="bi bi-plus-circle-fill me-2"></i> Add More Items
                            </a>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Ket. (Keterangan)</label>
                            <textarea name="description" class="form-control px-3 py-2" rows="3"
                                placeholder="Contoh: Digunakan untuk keperluan UKK di Lab RPL" style="border-radius: 8px;"></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('lendings') }}" class="btn fw-bold px-4 py-2"
                                style="background-color: #9ca3af; color: white; border-radius: 8px;">Cancel</a>

                            <button type="button" class="btn text-white fw-bold px-4 py-2"
                                style="background-color: #2563eb; border-radius: 8px;" data-bs-toggle="modal"
                                data-bs-target="#confirmLendingModal">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL KONFIRMASI LENDING -->
    <div class="modal fade" id="confirmLendingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                <div class="modal-header border-0 pt-4 px-4 text-center d-block">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="bi bi-clipboard-check text-primary fs-3"></i>
                    </div>
                    <h5 class="modal-title fw-bold">Konfirmasi Peminjaman</h5>
                </div>
                <div class="modal-body px-4 text-center">
                    <p class="mb-0 fw-bold text-dark">Simpan transaksi peminjaman ini?</p>
                    <p class="small text-secondary mb-0">Pastikan jumlah item yang dipinjam tidak melebihi stok tersedia.
                        Data akan langsung tercatat di riwayat peminjaman.</p>
                </div>
                <div class="modal-footer border-0 pb-4 px-4 justify-content-center gap-2">
                    <button type="button" class="btn fw-bold px-4 py-2" data-bs-dismiss="modal"
                        style="background-color: #4b5563; color: white; border-radius: 8px;">Periksa Kembali</button>

                    <button type="button" class="btn fw-bold px-4 py-2 text-white"
                        onclick="document.getElementById('lendingForm').submit()"
                        style="background-color: #2563eb; border-radius: 8px;">Ya, Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('items-container');
            let index = container.querySelectorAll('.item-row').length - 1;

            const itemsOptions = @json($items->map(fn($i) => ['id' => $i->id, 'text' => $i->name . ' (available: ' . $i->available . ')']));

            document.getElementById('add-item').addEventListener('click', function() {
                index++;

                const newRow = document.createElement('div');
                newRow.className = 'item-row bg-light p-3 rounded-3 mb-3 border border-dashed';

                const optionsHtml = [
                    `<option value="" disabled selected>Pilih Barang</option>`,
                    ...itemsOptions.map(o => `<option value="${o.id}">${o.text}</option>`)
                ].join('');

                newRow.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge rounded-pill bg-info bg-opacity-10 text-info fw-bold" style="font-size: 0.7rem;">ADDITIONAL ITEM</span>
                        <button type="button" class="btn btn-sm btn-outline-danger border-0 remove-row">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3 mb-md-0">
                            <label class="form-label fw-bold text-secondary small">Select Item</label>
                            <select name="items[${index}][item_id]" class="form-select px-3 py-2" style="border-radius: 8px;">
                                ${optionsHtml}
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary small">Total Item</label>
                            <input name="items[${index}][qty]" type="number" class="form-control px-3 py-2" placeholder="0" style="border-radius: 8px;">
                        </div>
                    </div>
                `;

                container.appendChild(newRow);

                newRow.querySelector('.remove-row').addEventListener('click', function() {
                    newRow.remove();
                });
            });
        });
    </script>
@endpush

@push('css')
    <style>
        .border-dashed {
            border: 1px dashed #cbd5e1 !important;
        }

        .modal-backdrop.show {
            opacity: 0.5;
        }

        #add-item:hover {
            background-color: #cffafe !important;
            transform: translateY(-1px);
            transition: 0.2s;
        }
    </style>
@endpush
