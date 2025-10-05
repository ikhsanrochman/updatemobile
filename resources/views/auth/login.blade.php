<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Pelaporan Dosis Radiasi</title>
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

        /* Efek partikel background */
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
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-control {
            background-color: transparent !important;
            border: none;
            border-bottom: 1px solid white;
            border-radius: 0;
            color: white !important;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #ddd;
            transform: translateY(-2px);
        }

        .form-control::placeholder {
            color: #ccc;
        }

        .form-label {
            font-weight: bold;
            margin-top: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus + .form-label {
            color: #fff;
            transform: translateY(-5px);
        }

        .form-check-label,
        .forgot-password {
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: #fff !important;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

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

        .input-group-text {
            background-color: transparent;
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .input-group:focus-within .input-group-text {
            transform: scale(1.1);
        }

        /* Animasi untuk alert */
        .alert {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Efek hover pada input group */
        .input-group {
            transition: all 0.3s ease;
        }

        .input-group:hover {
            transform: translateX(5px);
        }

        /* Animasi untuk checkbox */
        .form-check-input {
            transition: all 0.3s ease;
        }

        .form-check-input:checked {
            transform: scale(1.2);
        }

        /* Efek glow pada container saat hover */
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

        /* Hilangkan password reveal button default browser */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
        input[type="password"]::-webkit-credentials-auto-fill-button,
        input[type="password"]::-webkit-input-password-reveal-button {
            display: none;
        }
        input[type="password"]::-o-input-password-reveal-button {
            display: none;
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
        <h4 class="text-center fw-bold mb-4" data-aos="fade-down" data-aos-delay="200">Login</h4>

        @if ($errors->any())
            <div class="alert alert-danger" data-aos="fade-up" data-aos-delay="300">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3" data-aos="fade-up" data-aos-delay="400">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus>
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                </div>
            </div>

            <div class="mb-3" data-aos="fade-up" data-aos-delay="500">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                    <span class="input-group-text" id="togglePassword" style="cursor:pointer;">
                        <i class="bi bi-eye" style="color:white;"></i>
                    </span>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3" data-aos="fade-up" data-aos-delay="600">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <a href="{{ route('password.request') }}" class="forgot-password text-light text-decoration-underline">Forgot password?</a>
            </div>

            <div class="mb-3" data-aos="fade-up" data-aos-delay="650">
                <label for="captcha" class="form-label">Captcha</label>
                <div class="input-group">
                    <input type="text" name="captcha" id="captcha" class="form-control" placeholder="Masukkan kode captcha" required>
                    <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
                </div>
                <div class="mt-2">
                    <img src="{{ captcha_src() }}" alt="captcha" class="captcha-img" style="border-radius: 5px;">
                    <button type="button" class="btn btn-link text-light p-0 ms-2" onclick="refreshCaptcha()">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100" data-aos="fade-up" data-aos-delay="700">Login</button>
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

        // Fungsi untuk refresh captcha
        function refreshCaptcha() {
            document.querySelector('.captcha-img').src = '{{ captcha_src() }}?' + Math.random();
        }

        // Show/hide password
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const icon = togglePassword.querySelector('i');
            togglePassword.addEventListener('click', function(e) {
                e.preventDefault();
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });
    </script>
</body>
</html>
