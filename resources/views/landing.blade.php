<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Si-Pemdora</title>
    <!-- Import Bootstrap 5 CSS dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Import Bootstrap Icons dari CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Import AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- CSS Kustom untuk tampilan website -->
    <style>
        /* Membuat scroll halus saat klik menu */
        html {
            scroll-behavior: smooth;
        }
        /* Mengatur jarak atas karena ada navbar fixed */
        body {
            padding-top: 60px;
        }
        /* Mengatur tampilan hero/banner utama */
        .hero {
            background-image: linear-gradient(to bottom, rgba(0, 123, 255, 0.5), rgba(0, 123, 255, 0) 60%), url('img/landing.jpeg');
            background-size: cover;
            background-position: center;
            position: relative;
            height: 100vh;
            color: white;
            z-index: 1;
        }
        /* Memberi lapisan gelap pada hero */
        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }
        /* Memastikan konten hero tetap terlihat */
        .hero-content {
            position: relative;
            z-index: 2;
        }
        /* Mengatur tampilan navbar */
        .navbar-custom {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1030;
            transition: all 0.3s ease;
        }
        .navbar-custom.scrolled {
            background-color: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        /* Mengatur jarak antar section */
        section {
            padding: 100px 0;
        }
        /* Efek hover pada menu navbar */
        .nav-link {
            transition: all 0.3s;
            color: #555;
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #0d6efd;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .nav-link.active {
            color: #0d6efd;
        }
        .nav-link.active::after {
            width: 100%;
        }
        /* Posisi menu di tengah navbar */
        .nav-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        /* Mengatur tampilan section contact */
        #contact {
            min-height: 80vh;
            padding: 100px 0;
            display: flex;
            align-items: center;
            background-image: linear-gradient(to bottom, rgba(0, 123, 255, 0.5), rgba(0, 123, 255, 0) 60%), url('img/contact.png');
            background-size: cover;
            background-position: center;
            position: relative;
            color: white;
            z-index: 1;
        }
        /* Memastikan konten contact tetap terlihat */
        .contact-content {
            position: relative;
            z-index: 2;
        }
        /* Mengatur tinggi minimum section feature */
        #feature {
            min-height: 60vh;
            padding: 100px 0;
            display: flex;
            align-items: center;
            background-color: #f8f9fa;
        }
        /* Animasi untuk card */
        .feature-card {
            transition: all 0.3s ease;
            border: none;
            overflow: hidden;
            background: white;
            border-radius: 10px;
            padding: 40px 20px;
            height: 100%;
            text-align: center;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        .feature-card img {
            transition: all 0.3s ease;
        }
        .feature-card:hover img {
            transform: scale(1.1);
        }
        /* Animasi untuk tombol */
        .btn-primary {
            background-color: #fff;
            border-color: #fff;
            color: rgb(13, 59, 102);
            border-radius: 50px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            padding: 12px 40px;
            font-weight: 600;
        }
        .btn-primary::after {
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
        .btn-primary:hover::after {
            width: 300px;
            height: 300px;
        }
        /* Animasi untuk icon kontak */
        .contact-icon {
            transition: all 0.3s ease;
        }
        .contact-icon:hover {
            transform: scale(1.2) rotate(5deg);
        }
        .navbar-brand {
            color: rgb(13, 59, 102) !important;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .feature-icon {
            color: rgb(13, 59, 102);
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
        }
        /* Memberi lapisan biru transparan pada section contact */
        #contact::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(13, 59, 102, 0.9), rgba(13, 59, 102, 0.6) 40%);
            z-index: -1;
        }
        
        /* Custom styling untuk feature section */
        .feature-title {
            color: rgb(13, 59, 102);
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .feature-divider {
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, rgb(13, 59, 102), rgba(13, 59, 102, 0.5));
            margin: 0 auto 50px auto;
            border-radius: 2px;
        }
        
        .feature-card h5 {
            color: rgb(13, 59, 102);
            font-weight: 600;
            font-size: 1.25rem;
            margin-top: 10px;
        }
        
        /* Contact section improvements */
        .contact-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .contact-divider {
            width: 80px;
            height: 4px;
            background: white;
            margin: 0 auto 50px auto;
            border-radius: 2px;
        }
        
        .contact-item h5 {
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .contact-item p {
            font-size: 1rem;
            line-height: 1.6;
        }
        
        /* Hero section improvements */
        .hero h1 {
            font-size: 3.5rem;
            line-height: 1.2;
        }
        
        .hero h2 {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .hero p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto 30px auto;
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            .feature-title, .contact-title {
                font-size: 2rem;
            }
            .feature-card {
                padding: 30px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- ==========================================
         NAVBAR (MENU NAVIGASI)
         ========================================== -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-custom">
        <div class="container">
            <!-- Logo website -->
            <a class="navbar-brand fw-bold" href="#" data-aos="fade-right">Si-Pemdora</a>
            
            <!-- Menu untuk layar desktop -->
            <div class="nav-center d-none d-lg-block">
                <ul class="navbar-nav flex-row fw-semibold">
                    <li class="nav-item px-3">
                        <a class="nav-link" href="#home" id="home-link">Home</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link" href="#feature" id="feature-link">Feature</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link" href="#contact" id="contact-link">Contact</a>
                    </li>
                </ul>
            </div>
            
            <!-- Tombol menu untuk layar mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Menu untuk layar mobile -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto d-lg-none">
                    <li class="nav-item">
                        <a class="nav-link" href="#home" id="home-link-mobile">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#feature" id="feature-link-mobile">Feature</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact" id="contact-link-mobile">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ==========================================
         HERO SECTION (BANNER UTAMA)
         ========================================== -->
    <section class="hero d-flex align-items-center" id="home">
        <div class="container text-center hero-content">
            <h2 class="mb-3" data-aos="fade-up" data-aos-delay="100">Selamat Datang di Si-Pemdora</h2>
            <h1 class="fw-bold mb-4" data-aos="fade-up" data-aos-delay="200">Sistem Pemantauan Dosis Radiasi</h1>
            <p class="mb-4" data-aos="fade-up" data-aos-delay="300">Pantau dan laporkan paparan radiasi personel secara efisien dan akurat.</p>
            <!-- Tombol untuk login -->
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg" data-aos="fade-up" data-aos-delay="400">Sign In</a>
        </div>
    </section>

    <!-- ==========================================
         FEATURE SECTION (FITUR-FITUR)
         ========================================== -->
    <section id="feature">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="feature-title" data-aos="fade-up">Our Feature</h2>
                <div class="feature-divider" data-aos="fade-up" data-aos-delay="100"></div>
            </div>
            
            <!-- Grid untuk menampilkan fitur-fitur -->
            <div class="row justify-content-center g-4">
                <!-- Fitur Daftar Pekerja -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="card shadow-sm feature-card">
                        <div class="d-flex justify-content-center">
                            <svg class="feature-icon" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002A.274.274 0 0 1 15 13H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                            </svg>
                        </div>
                        <h5>Daftar Pekerja</h5>
                    </div>
                </div>
                
                <!-- Fitur Laporan Keselamatan -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="card shadow-sm feature-card">
                        <div class="d-flex justify-content-center">
                            <svg class="feature-icon" fill="currentColor" viewBox="0 0 16 16">
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            </svg>
                        </div>
                        <h5>Laporan Keselamatan Fasilitas</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
         CONTACT SECTION (KONTAK)
         ========================================== -->
    <section id="contact">
        <div class="container contact-content">
            <div class="text-center mb-5">
                <h2 class="contact-title" data-aos="fade-up">Contact Us</h2>
                <div class="contact-divider" data-aos="fade-up" data-aos-delay="100"></div>
            </div>
            
            <!-- Grid untuk menampilkan informasi kontak -->
            <div class="row justify-content-center g-4">
                <!-- Nomor Telepon -->
                <div class="col-lg-4 col-md-6 contact-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="white" class="bi bi-telephone contact-icon mb-3" viewBox="0 0 16 16">
                            <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                        </svg>
                        <h5>Office Contact</h5>
                        <p>031 5967608 / 5967609</p>
                    </div>
                </div>
                
                <!-- Email -->
                <div class="col-lg-4 col-md-6 contact-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="white" class="bi bi-envelope contact-icon mb-3" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                        </svg>
                        <h5>Office Email</h5>
                        <p>robutech@robutech.com</p>
                    </div>
                </div>
                
                <!-- Alamat -->
                <div class="col-lg-4 col-md-12 contact-item" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="white" class="bi bi-geo-alt contact-icon mb-3" viewBox="0 0 16 16">
                            <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                            <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                        <h5>Office Address</h5>
                        <p>Jl. Semolowaru Selatan V No.25, Semolowaru,<br>Kec. Sukolilo, Surabaya, Jawa Timur 60119</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Import Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Import AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Script untuk mengatur menu aktif saat di-scroll -->
    <script>
        // Inisialisasi AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Menjalankan script setelah halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk mengatur menu aktif berdasarkan posisi scroll
            function setActiveNavLink() {
                // Ambil semua section dan menu
                const sections = document.querySelectorAll('section');
                const navLinks = document.querySelectorAll('.nav-link');
                
                let current = '';
                
                // Cek posisi scroll dan tentukan section mana yang sedang aktif
                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 100;
                    const sectionHeight = section.clientHeight;
                    
                    if (window.pageYOffset >= sectionTop && window.pageYOffset < sectionTop + sectionHeight) {
                        current = section.getAttribute('id');
                    }
                });
                
                // Atur class active pada menu yang sesuai
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${current}`) {
                        link.classList.add('active');
                    }
                });
            }
            
            // Fungsi untuk mengatur navbar saat di-scroll
            function handleScroll() {
                const navbar = document.querySelector('.navbar-custom');
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
            
            // Jalankan fungsi saat halaman dimuat
            setActiveNavLink();
            handleScroll();
            
            // Jalankan fungsi saat halaman di-scroll
            window.addEventListener('scroll', () => {
                setActiveNavLink();
                handleScroll();
            });
        });
    </script>
</body>
</html>