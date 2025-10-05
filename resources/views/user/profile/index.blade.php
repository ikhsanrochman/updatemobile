@extends('layouts.user')

@section('content')
<!-- Breadcrumb Section -->
<div id="breadcrumb-container" class="breadcrumb-section mb-4 position-fixed" style="right: 30px; left: 280px; top: 85px; z-index: 999; transition: left 0.3s ease;">
    <div class="d-flex justify-content-between bg-dark-blue py-2 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}" class="text-decoration-none text-white">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Profile</li>
            </ol>
        </nav>
    </div>
</div>

<div style="margin-top: 50px;"></div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar');
        const breadcrumbContainer = document.getElementById('breadcrumb-container');
        const mainContentWrapper = document.getElementById('main-content-wrapper');
        
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    const isSidebarCollapsed = sidebar.classList.contains('collapsed');
                    breadcrumbContainer.style.left = isSidebarCollapsed ? '25px' : '280px';
                    if (mainContentWrapper) {
                        mainContentWrapper.style.marginLeft = isSidebarCollapsed ? '25px' : '280px';
                    }
                }
            });
        });

        observer.observe(sidebar, {
            attributes: true
        });
    });
</script>
@endpush

<!-- Header -->
<div class="mb-2">
    <h2 class="fw-bold">Profile Saya</h2>
    <div class="text-muted" style="font-size: 15px;">Kelola informasi profile dan keamanan akun Anda</div>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <!-- Profile Information -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Profile</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Foto Profil -->
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ $user->foto_profil ? asset('storage/' . $user->foto_profil) : asset('img/user.png') }}"
                             alt="Foto Profil"
                             class="rounded-circle"
                             id="preview-foto-profil"
                             style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #1e3a5f;">
                        <div class="ms-3">
                            <label for="foto_profil" class="form-label fw-bold mb-1">Ubah Foto Profil</label>
                            <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept="image/*">
                            @error('foto_profil')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Informasi Pribadi</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" name="nama" value="{{ old('nama', $user->nama) }}" 
                                   placeholder="Masukkan nama lengkap" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                   id="username" name="username" value="{{ old('username', $user->username) }}" 
                                   placeholder="Masukkan username" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" 
                                   placeholder="Masukkan email" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="row">
                        <div class="col-12">
                            <hr class="my-4">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-4 py-2">
                                    <i class="fas fa-save me-2"></i>Update Profile
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Password Change -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Ubah Password</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.profile.update_password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-bold">Password Saat Ini <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" placeholder="Masukkan password saat ini" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label fw-bold">Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                   id="new_password" name="new_password" placeholder="Masukkan password baru" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <ul id="user-password-requirements" class="mt-2 mb-0 ps-3" style="list-style: disc; font-size: 0.95em;">
                            <li id="user-pw-length" class="text-danger">Minimal 8 karakter</li>
                            <li id="user-pw-uppercase" class="text-danger">Mengandung huruf kapital</li>
                            <li id="user-pw-number" class="text-danger">Mengandung angka</li>
                            <li id="user-pw-symbol" class="text-danger">Mengandung simbol</li>
                        </ul>
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" 
                                   id="new_password_confirmation" name="new_password_confirmation" 
                                   placeholder="Konfirmasi password baru" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning px-4 py-2">
                            <i class="fas fa-key me-2"></i>Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    .bg-dark-blue {
        background-color: #1e3a5f;
    }
    
    .container-fluid {
        overflow-x: auto;
        max-width: 100vw;
    }

    .breadcrumb-item {
        padding: 0;
        margin: 0;
    }
    
    .breadcrumb-item a {
        color: #ffffff;
        text-decoration: none;
    }
    
    .breadcrumb-item a:hover {
        color: #e0e0e0;
    }

    .breadcrumb {
        margin: 0;
        padding: 0;
    }

    .card-header {
        border-bottom: 1px solid #dee2e6;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #1e3a5f;
        box-shadow: 0 0 0 0.2rem rgba(30, 58, 95, 0.25);
    }

    .btn-primary {
        background-color: #1e3a5f;
        border-color: #1e3a5f;
    }

    .btn-primary:hover {
        background-color: #152a47;
        border-color: #152a47;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
        color: #000;
    }

    .text-primary {
        color: #1e3a5f !important;
    }

    .alert {
        border-radius: 8px;
    }

    .card {
        border-radius: 12px;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
    }
</style>

@push('scripts')
<link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fotoInput = document.getElementById('foto_profil');
    const cropModal = document.getElementById('cropperModal');
    const cropImage = document.getElementById('cropperImage');
    const cropBtn = document.getElementById('cropBtn');
    const closeCropBtn = document.getElementById('closeCropBtn');
    const previewImg = document.getElementById('preview-foto-profil');
    let cropper;

    if (fotoInput && cropModal && cropImage && cropBtn && closeCropBtn && previewImg) {
        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && /^image\/.*/.test(file.type)) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    cropImage.src = evt.target.result;
                    cropModal.style.display = 'flex';
                    if (cropper) cropper.destroy();
                    cropper = new Cropper(cropImage, {
                        aspectRatio: 1,
                        viewMode: 1,
                        movable: true,
                        zoomable: true,
                        rotatable: false,
                        scalable: false,
                        cropBoxResizable: true,
                        minContainerWidth: 200,
                        minContainerHeight: 200,
                        minCropBoxWidth: 100,
                        minCropBoxHeight: 100,
                        autoCropArea: 1
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        cropBtn.addEventListener('click', function() {
            if (cropper) {
                cropper.getCroppedCanvas({
                    width: 250,
                    height: 250,
                    imageSmoothingQuality: 'high'
                }).toBlob(function(blob) {
                    const url = URL.createObjectURL(blob);
                    previewImg.src = url;
                    const dataTransfer = new DataTransfer();
                    const file = new File([blob], 'cropped_profile.png', { type: 'image/png' });
                    dataTransfer.items.add(file);
                    fotoInput.files = dataTransfer.files;
                    cropModal.style.display = 'none';
                    cropper.destroy();
                }, 'image/png');
            }
        });

        closeCropBtn.addEventListener('click', function() {
            cropModal.style.display = 'none';
            if (cropper) cropper.destroy();
        });
    }

    // Real-time password requirements check (user profile)
    const newPasswordInput = document.getElementById('new_password');
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            const value = newPasswordInput.value;
            document.getElementById('user-pw-length').className = value.length >= 8 ? 'text-success' : 'text-danger';
            document.getElementById('user-pw-uppercase').className = /[A-Z]/.test(value) ? 'text-success' : 'text-danger';
            document.getElementById('user-pw-number').className = /\d/.test(value) ? 'text-success' : 'text-danger';
            document.getElementById('user-pw-symbol').className = /[!@#$%^&*()_\-+=\[\]{};':"\\|,.<>\/?]/.test(value) ? 'text-success' : 'text-danger';
        });
    }
});
</script>
<!-- Modal Cropper -->
<div id="cropperModal" style="display:none; position:fixed; z-index:2000; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.7); align-items:center; justify-content:center;">
    <div style="background:#fff; padding:24px 18px 18px 18px; border-radius:14px; max-width:340px; width:95vw; max-height:95vh; box-shadow:0 8px 32px rgba(30,58,95,0.18); display:flex; flex-direction:column; align-items:center;">
        <div style="font-weight:600; font-size:1.1rem; margin-bottom:10px; color:#1e3a5f;">Atur & Crop Foto Profil</div>
        <img id="cropperImage" src="" style="max-width:250px; max-height:250px; width:100%; height:auto; border-radius:8px; border:1px solid #eee; background:#f8f9fa; display:block; margin:auto;">
        <div class="mt-3 d-flex justify-content-center gap-2" style="width:100%;">
            <button type="button" class="btn btn-primary flex-fill" id="cropBtn">Crop & Simpan</button>
            <button type="button" class="btn btn-secondary flex-fill" id="closeCropBtn">Batal</button>
        </div>
    </div>
</div>
@endpush

@endsection