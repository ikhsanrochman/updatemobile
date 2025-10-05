<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Si-Pemdora - User</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        body {
            background-color: #ffffff;
        }
        .content-wrapper {
            margin-left: 280px;
            margin-top: 71px;
            transition: margin-left 0.3s;
            padding-left: 20px;
            padding-right: 20px;
        }
        .content-wrapper.full-width {
            margin-left: 0;
        }
    </style>
</head>
<body>
    <div id="app">
        @include('layouts.sidebar-user')
        @include('layouts.navbar-user')
        
        <main class="content-wrapper py-4">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html> 