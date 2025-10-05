<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Si-Pemdora - Admin</title>
    
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
            min-height: 100vh;
            position: relative;
            font-size: 14px;
        }
        
        .content-wrapper {
            margin-left: 280px;
            padding-top: 90px;
            padding-left: 20px;
            padding-right: 20px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        .content-wrapper.full-width {
            margin-left: 0;
        }
        
        /* Responsive Table Styles */
        .table-responsive-xl {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table td, .table th {
            white-space: nowrap;
        }
        
        @media (max-width: 1200px) {
            .table td, .table th {
                min-width: 120px;
            }
            .table td:last-child {
                min-width: 150px;
            }
        }
        
        /* Card Responsiveness */
        .card {
            margin-bottom: 1rem;
        }
        
        .card-body {
            padding: 1.25rem;
        }
        
        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
                padding-top: 75px;
                padding-left: 15px;
                padding-right: 15px;
            }
            
            .navbar {
                width: 100% !important;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            /* Improve form responsiveness */
            .form-control, .form-select {
                font-size: 14px;
            }
            
            /* Adjust button sizes for mobile */
            .btn {
                padding: 0.375rem 0.75rem;
                font-size: 14px;
            }
            
            /* Improve modal responsiveness */
            .modal-dialog {
                margin: 0.5rem;
            }
        }
        
        /* Additional Responsive Utilities */
        @media (max-width: 576px) {
            .d-xs-none {
                display: none !important;
            }
            
            .text-xs-center {
                text-align: center !important;
            }
            
            .mb-xs-3 {
                margin-bottom: 1rem !important;
            }
        }

        #app {
            min-height: 100vh;
            position: relative;
        }
        
        /* Breadcrumb Responsiveness */
        .breadcrumb-section {
            margin: 0 -20px 2rem -20px;
            position: fixed;
            top: 70px;
            left: 280px;
            right: 30px;
            z-index: 999;
            background-color: #fff;
            padding-top: 1rem;
            transition: left 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .breadcrumb-section {
                left: 0;
                right: 0;
                padding-top: 0.5rem;
            }
        }
        
        .breadcrumb {
            flex-wrap: wrap;
            padding: 0;
            margin: 0;
        }
        
        .breadcrumb-item {
            display: inline-flex;
            align-items: center;
        }
        
        @media (max-width: 768px) {
            .breadcrumb-section {
                margin: -1rem -15px 1rem -15px;
            }
            
            .breadcrumb {
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        @include('layouts.sidebar-admin')
        @include('layouts.navbar-admin')
        
        <main class="content-wrapper py-4">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</body>
</html> 