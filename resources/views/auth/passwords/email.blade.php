<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Sistem Pelaporan Dosis Radiasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            background: url('/img/login.png') center center / cover no-repeat;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, transparent 0%, rgba(0, 0, 0, 0.3) 100%);
            z-index: 1;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem 2.5rem;
            width: 100%;
            max-width: 400px;
            color: white;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
            animation: containerFadeIn 1s ease-out;
        }
        @keyframes containerFadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-control {
            background-color: transparent;
            border: none;
            border-bottom: 1px solid white;
            border-radius: 0;
            color: white;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #ddd;
            transform: translateY(-2px);
        }
        .form-control::placeholder { color: #ccc; }
        .form-label { font-weight: bold; margin-top: 1rem; transition: all 0.3s ease; }
        .form-control:focus + .form-label { color: #fff; transform: translateY(-5px); }
        .btn-login {
            background-color: white;
            color: #003366;
            border-radius: 999px;
            font-weight: bold;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-login:hover {
            background-color: #e0e0e0;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-login::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }
        .btn-login:hover::after {
            width: 300px;
            height: 300px;
        }
        .alert { animation: slideIn 0.5s ease-out; }
        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .login-container:hover {
            box-shadow: 0 0 40px rgba(255, 255, 255, 0.1);
        }
        .top-bar {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 40px;
            box-sizing: border-box;
            z-index: 3;
        }
        .top-bar .brand-logo {
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
        .top-bar .btn-link {
            font-weight: 600;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <div class="top-bar d-flex justify-content-between align-items-center p-4 fixed-top">
        <div class="brand-logo fw-bold text-white fs-4" data-aos="fade-right">Si-Pemdora</div>
        <a href="{{ route('landing') }}" class="btn btn-link text-white text-decoration-none" data-aos="fade-left">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>
    <div class="login-container" data-aos="fade-up" data-aos-duration="1000">
        <h4 class="text-center fw-bold mb-4" data-aos="fade-down" data-aos-delay="200">Reset Password</h4>
        @if (session('status'))
            <div class="alert alert-success" data-aos="fade-up" data-aos-delay="300">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" data-aos="fade-up" data-aos-delay="300">
                {{ $errors->first() }}
            </div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3" data-aos="fade-up" data-aos-delay="400">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email anda" required autofocus>
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                </div>
            </div>
            <button type="submit" class="btn btn-login w-100" data-aos="fade-up" data-aos-delay="500">Kirim Link Reset Password</button>
        </form>
    </div>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
    </script>
</body>
</html>
