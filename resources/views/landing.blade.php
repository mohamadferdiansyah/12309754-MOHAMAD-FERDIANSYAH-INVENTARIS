<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Inventaris - SMK Wikrama</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fcfdfe;
            color: #333;
        }

        /* Navbar */
        .navbar-brand img {
            width: 50px;
        }

        .btn-login {
            background-color: #2563eb;
            color: white;
            border-radius: 8px;
            padding: 8px 30px;
            font-weight: 600;
            border: none;
        }

        .btn-login:hover {
            background-color: #1d4ed8;
            color: white;
            transform: translateY(-1px);
            transition: 0.2s;
        }

        /* Hero Section */
        .hero {
            padding: 100px 0 60px;
            text-align: center;
        }

        .hero h1 {
            font-weight: 800;
            font-size: 2.8rem;
            margin-bottom: 15px;
            color: #1e293b;
        }

        .hero p {
            color: #64748b;
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto;
        }

        .hero-img {
            max-width: 1000px;
            width: 100%;
            margin-top: 50px;
            border-radius: 20px;
        }

        /* System Flow Section */
        .flow-section {
            padding: 80px 0;
            background-color: white;
            border-top: 1px solid #f1f5f9;
        }

        .flow-title {
            font-weight: 700;
            font-size: 2.2rem;
            color: #1e293b;
        }

        .flow-card {
            border-radius: 0px;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            transition: 0.3s;
        }

        .flow-card i {
            font-size: 3.5rem;
            margin-bottom: 15px;
        }

        .flow-label {
            font-weight: 600;
            margin-top: 20px;
            color: #475569;
        }

        /* Flow Colors */
        .bg-dark-blue {
            background-color: #000839;
            color: white;
        }

        .bg-orange {
            background-color: #ffa500;
            color: white;
        }

        .bg-lavender {
            background-color: #c3b1e1;
            color: white;
        }

        .bg-mint {
            background-color: #72d3a8;
            color: white;
        }

        /* Footer */
        footer {
            padding: 80px 0 40px;
            border-top: 2px solid #1e293b;
            margin-top: 50px;
        }

        .footer-logo {
            width: 45px;
        }

        .footer-links a {
            text-decoration: none;
            color: #64748b;
            display: block;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .footer-links a:hover {
            color: #2563eb;
        }

        .social-icons a {
            color: #94a3b8;
            margin-right: 20px;
            font-size: 1.3rem;
        }

        .social-icons a:hover {
            color: #2563eb;
        }

        /* Modal Login Style Modern */
        .modal-content {
            border-radius: 15px;
            border: none;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: none;
            padding: 30px 30px 10px;
        }

        .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
            color: #1e293b;
        }

        .modal-body {
            padding: 10px 30px 20px;
        }

        .modal-footer {
            border-top: none;
            padding: 10px 30px 30px;
            justify-content: flex-start;
            gap: 10px;
        }

        .form-control {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.1);
        }

        .btn-close-modal {
            background-color: #dc2626;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-submit-modal {
            background-color: #16a34a;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-close-modal:hover {
            background-color: #b91c1c;
            color: white;
        }

        .btn-submit-modal:hover {
            background-color: #15803d;
            color: white;
        }
    </style>
</head>

<body>

    <nav class="navbar fixed-top navbar-light bg-white bg-opacity-75 pt-4 px-lg-5 shadow-sm"
        style="backdrop-filter: blur(10px);">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/img/app_icon.png') }}" alt="Logo Wikrama">
            </a>

            {{-- @auth
                <a href="#" class="btn btn-login shadow-sm">
                    Dashboard
                </a>
            @else --}}
                <button class="btn btn-login shadow-sm" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Login
                </button>
            {{-- @endauth --}}
        </div>
    </nav>

    <section class="hero container">
        <h1>Manajemen Inventaris <br> SMK Wikrama</h1>
        <p>Sistem manajemen inventaris terpadu untuk pengelolaan barang masuk, keluar, dan peminjaman aset di SMK
            Wikrama Bogor.</p>
        <img src="{{ asset('assets/img/landing.jpg') }}" class="hero-img shadow-lg" alt="Illustration">
    </section>

    <section class="flow-section text-center">
        <div class="container">
            <h2 class="flow-title">Our system flow</h2>
            <p class="text-muted mb-5">Alur kerja sistem manajemen inventaris kami</p>

            <div class="row g-0 shadow-sm rounded-4 overflow-hidden">
                <div class="col-md-3">
                    <div class="flow-card bg-dark-blue">
                        <i class="bi bi-box-seam"></i>
                        <p class="flow-label text-white">Items Data</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="flow-card bg-orange">
                        <i class="bi bi-person-gear"></i>
                        <p class="flow-label text-white">Management Technician</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="flow-card bg-lavender">
                        <i class="bi bi-arrow-left-right"></i>
                        <p class="flow-label text-white">Managed Lending</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="flow-card bg-mint">
                        <i class="bi bi-check2-all"></i>
                        <p class="flow-label text-white">All Can Borrow</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <img src="{{ asset('assets/img/app_icon.png') }}" class="footer-logo mb-3" alt="Logo">
                <p class="mb-1 fw-bold">smkwikrama@sch.id</p>
                <p class="text-muted">001-7876-2876</p>
            </div>
            <div class="col-md-4 mb-4 footer-links">
                <h6 class="fw-bold mb-3">Our Guidelines</h6>
                <a href="#">Terms of Service</a>
                <a href="#" class="text-danger">Privacy Policy</a>
                <a href="#">Cookie Policy</a>
                <a href="#">Discover</a>
            </div>
            <div class="col-md-4 mb-4">
                <h6 class="fw-bold mb-3">Our address</h6>
                <p class="text-muted small">Jalan Wangun Tengah, Kel. Sindangsari<br>Kec. Bogor Timur, Kota
                    Bogor<br>Jawa Barat</p>
                <div class="social-icons mt-3">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- LOGIN MODAL -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title">Login Account</h5>
                </div>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger py-2 small mb-4 border-0">
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Email Address</label>
                            <input name="email" type="email" class="form-control" placeholder="example@gmail.com"
                                value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Password</label>
                            <input name="password" type="password" class="form-control" placeholder="••••••••" required>
                        </div>
                        {{-- <div class="form-check small mt-2">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label text-secondary" for="remember">Ingat Saya</label>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-close-modal" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-submit-modal shadow-sm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
            @endif
        });
    </script>
</body>

</html>
