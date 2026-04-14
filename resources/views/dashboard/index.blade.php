@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Hero Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        <div style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ asset('assets/img/wk.jpg') }}'); 
                                    background-size: cover; background-position: center; height: 300px;"
                            class="d-flex align-items-center px-5 text-white">
                            <div>
                                <h1 class="display-5 fw-bold">Welcome Back, {{ auth()->user()->name }}</h1>
                                <p class="lead opacity-75">Sistem Manajemen Inventaris SMK Wikrama Bogor.</p>
                                <hr class="w-25 border-2 opacity-100 mt-4">
                                <p class="small">Pilih menu di sidebar untuk mulai mengelola data sebagai <span
                                        class="badge bg-primary text-uppercase">{{ auth()->user()->role }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="row">
            @if (auth()->user()->role === 'admin')
                <!-- TAMPILAN ADMIN -->
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3 text-primary">
                                <i class="bi bi-grid-fill fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-secondary small mb-1">Total Kategori</h6>
                                <h3 class="fw-bold mb-0">{{ $total_categories }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3 text-success">
                                <i class="bi bi-box-seam-fill fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-secondary small mb-1">Jenis Barang</h6>
                                <h3 class="fw-bold mb-0">{{ $total_items }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3 text-info">
                                <i class="bi bi-stack fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-secondary small mb-1">Total Stok Keseluruhan</h6>
                                <h3 class="fw-bold mb-0">{{ $total_stock_all }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- TAMPILAN STAFF / OPERATOR -->
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3 text-warning">
                                <i class="bi bi-arrow-left-right fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-secondary small mb-1">Total Peminjaman</h6>
                                <h3 class="fw-bold mb-0">{{ $total_borrowed }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3 text-success">
                                <i class="bi bi-check-all fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-secondary small mb-1">Sudah Kembali</h6>
                                <h3 class="fw-bold mb-0">{{ $total_returned }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
                        <div class="d-flex align-items-center">
                            <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3 text-danger">
                                <i class="bi bi-clock-history fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-secondary small mb-1">Masih Dipinjam</h6>
                                <h3 class="fw-bold mb-0">{{ $active_borrowing }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm p-3" style="border-radius: 15px;">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3 text-primary">
                                <i class="bi bi-box-seam fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-secondary small mb-1">Total Jenis Barang</h6>
                                <h3 class="fw-bold mb-0">{{ $total_items_available }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
