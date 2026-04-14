<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris SMK Wikrama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7fa; overflow-x: hidden; }
        .wrapper { display: flex; width: 100%; align-items: stretch; }
        #content { width: 100%; padding: 20px; min-height: 100vh; transition: all 0.3s; margin-left: 250px; }
        @media (max-width: 768px) { #content { margin-left: 0; } }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('css')
</head>
<body>

    <div class="wrapper">
        @include('layouts.sidebar')

        <div id="content">
            @include('layouts.navbar')

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('script')
</body>
</html>