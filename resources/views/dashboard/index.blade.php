@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
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
                                <p class="small">Pilih menu di sidebar untuk mulai mengelola data.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection