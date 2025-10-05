@extends('layouts.super_admin')

@section('content')
<!-- Breadcrumb Section -->


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

<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4 ps-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold">Edit Akun</h2>
                <p class="text-muted mb-0">Edit informasi akun pengguna</p>
            </div>
            <a href="{{ route('super_admin.kelola_akun') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
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

    <form action="{{ route('super_admin.kelola_akun.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded-3 shadow-sm">
        @csrf
        @method('PUT')
        <div class="d-flex align-items-center mb-4">
            <img src="{{ $user->foto_profil ? asset('storage/' . $user->foto_profil) : asset('img/user.png') }}" alt="Foto Profil" class="rounded-circle" id="preview-foto-profil" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #1e3a5f;">
            <div class="ms-3">
                <label for="foto_profil" class="form-label fw-bold mb-1">Foto Profil</label>
                <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept="image/*">
                @error('foto_profil')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
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
        <div class="row justify-content-center mt-3">
            <div class="col-lg-8">
                <!-- Personal Information -->
                <div class="row mb-4">
                    <div class="col-12 mb-2">
                        <h6 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Informasi Pribadi</h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" placeholder="Masukkan nama lengkap" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" placeholder="Masukkan username" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Masukkan email" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Security Information -->
                <div class="row mb-4">
                    <div class="col-12 mb-2">
                        <h6 class="text-primary mb-3"><i class="fas fa-lock me-2"></i>Informasi Keamanan</h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label fw-bold">Password Baru <span class="text-muted">(Opsional)</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru <span class="text-muted">(Opsional)</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password baru">
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Role and Expertise -->
                <div class="row mb-4">
                    <div class="col-12 mb-2">
                        <h6 class="text-primary mb-3"><i class="fas fa-user-tag me-2"></i>Role dan Keahlian</h6>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="role_id" class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                        <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                            <option value="">Pilih Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="is_active" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                            <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jenis_pekerja_selector" class="form-label fw-bold">Bidang <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-select" id="jenis_pekerja_selector">
                                <option value="">Pilih Bidang...</option>
                                @foreach($jenisPekerja as $jp)
                                    <option value="{{ $jp->id }}" data-name="{{ $jp->nama }}">{{ $jp->nama }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-outline-primary" id="btn-tambah-bidang" data-bs-toggle="modal" data-bs-target="#modalBidang">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div id="selected_bidang_container" class="mt-2">
                            {{-- Selected items will be populated here by JavaScript --}}
                        </div>
                        <select name="jenis_pekerja[]" id="jenis_pekerja_hidden" multiple class="d-none">
                            @foreach($jenisPekerja as $jp)
                                @if(in_array($jp->id, old('jenis_pekerja', $user->jenisPekerja->pluck('id')->toArray())))
                                    <option value="{{ $jp->id }}" selected>{{ $jp->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('jenis_pekerja')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="keahlian" class="form-label fw-bold">Keahlian</label>
                        <input type="text" class="form-control @error('keahlian') is-invalid @enderror" id="keahlian" name="keahlian" value="{{ old('keahlian', $user->keahlian) }}" placeholder="Masukkan keahlian">
                        @error('keahlian')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Professional Information -->
                <div class="row mb-4">
                    <div class="col-12 mb-2">
                        <h6 class="text-primary mb-3"><i class="fas fa-id-card me-2"></i>Informasi Profesional</h6>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="no_sib" class="form-label fw-bold">No. SIB <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('no_sib') is-invalid @enderror" id="no_sib" name="no_sib" value="{{ old('no_sib', $user->no_sib) }}" placeholder="Masukkan nomor SIB" required>
                        @error('no_sib')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="npr" class="form-label fw-bold">NPR <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('npr') is-invalid @enderror" id="npr" name="npr" value="{{ old('npr', $user->npr) }}" placeholder="Masukkan nomor NPR" required>
                        @error('npr')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="berlaku" class="form-label fw-bold">Tanggal Berlaku <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('berlaku') is-invalid @enderror" id="berlaku" name="berlaku" value="{{ old('berlaku', $user->berlaku) }}" required>
                        @error('berlaku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Form Actions -->
                <div class="row">
                    <div class="col-12">
                        <hr class="my-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('super_admin.kelola_akun') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Akun
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Custom CSS -->
<style>    
    .container-fluid {
        overflow-x: auto;
        max-width: 100vw;
        padding-left: 15px;
        padding-right: 15px;
    }

    .breadcrumb-item a {
        color: #6c757d;
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        color: #002B5B;
    }

    .breadcrumb-item.active {
        color: #002B5B;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: #6c757d;
    }
    
    .page-breadcrumb {
        padding: 12px 0;
    }

    /* Responsive styles */
    @media (max-width: 576px) {
        .breadcrumb-item {
            font-size: 14px;
        }
        .page-breadcrumb {
            padding: 8px 0;
        }
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }
    }

    @media (min-width: 577px) and (max-width: 768px) {
        .breadcrumb-item {
            font-size: 15px;
        }
        .page-breadcrumb {
            padding: 10px 0;
        }
    }

    @media (min-width: 769px) {
        .breadcrumb-item {
            font-size: 16px;
        }
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

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
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
<script>
    // Password toggle functionality
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const passwordField = document.getElementById('password_confirmation');
        const icon = this.querySelector('i');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]).{8,}$/;
        if (password) {
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return false;
            }
            if (!passwordRegex.test(password)) {
                e.preventDefault();
                alert('Password minimal 8 karakter, mengandung huruf kapital, angka, dan simbol!');
                return false;
            }
        }
    });

    // Cropper.js CSS & JS
    document.addEventListener('DOMContentLoaded', function() {
        let cropper;
        const fotoInput = document.getElementById('foto_profil');
        const cropModal = document.getElementById('cropperModal');
        const cropImage = document.getElementById('cropperImage');
        const cropBtn = document.getElementById('cropBtn');
        const closeCropBtn = document.getElementById('closeCropBtn');
        const previewImg = document.getElementById('preview-foto-profil');

        if (fotoInput) {
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
        }
        if (cropBtn) {
            cropBtn.addEventListener('click', function() {
                if (cropper) {
                    cropper.getCroppedCanvas({
                        width: 250,
                        height: 250,
                        imageSmoothingQuality: 'high'
                    }).toBlob(function(blob) {
                        const uniqueName = 'profile_' + Date.now() + '.png';
                        const file = new File([blob], uniqueName, { type: 'image/png' });
                        const url = URL.createObjectURL(file);
                        previewImg.src = url;
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        fotoInput.files = dataTransfer.files;
                        cropModal.style.display = 'none';
                        cropper.destroy();
                    }, 'image/png');
                }
            });
        }
        if (closeCropBtn) {
            closeCropBtn.addEventListener('click', function() {
                cropModal.style.display = 'none';
                if (cropper) cropper.destroy();
            });
        }
    });
</script>
<link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
@endpush

@endsection
