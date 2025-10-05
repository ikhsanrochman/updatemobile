@extends('layouts.admin')

@section('content')
<!-- Breadcrumb Section -->


<div style="margin-top: 50px;"></div>

<div class="container-fluid">
    <!-- Header and Back Button Row -->
    <div class="d-flex align-items-center mb-4 justify-content-between">
        <h2 class="fw-bold mb-0">Tambah Data TLD</h2>
        <a href="{{ route('admin.pemantauan.tld', $project->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h6 class="fw-bold mb-4">Tambah Data Dosis Pemantauan TLD</h6>

            <form action="{{ route('admin.pemantauan.tld.store', ['projectId' => $project->id]) }}" method="POST">
                @csrf
                
                <!-- Pilih Karyawan -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Pilih Karyawan <span class="text-danger">*</span></label>
                            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                <option value="">Pilih Karyawan</option>
                                @foreach($project->ketersediaanSdm->flatMap->users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama }} ({{ $user->npr ?? 'No NPR' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Data TLD -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="periode_bulan" class="form-label">Periode Bulan <span class="text-danger">*</span></label>
                            <select class="form-select" id="periode_bulan" required>
                                <option value="">Pilih Bulan</option>
                                <option value="03">Maret</option>
                                <option value="06">Juni</option>
                                <option value="09">September</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="periode_tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                            <select class="form-select" id="periode_tahun" required>
                                <!-- Tahun akan diisi oleh JS -->
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="tanggal_pemantauan" id="tanggal_pemantauan" value="{{ old('tanggal_pemantauan', date('Y-m-d')) }}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="dosis" class="form-label">Dosis (mSv) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('dosis') is-invalid @enderror" 
                                id="dosis" name="dosis" value="{{ old('dosis') }}" required>
                            @error('dosis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('admin.pemantauan.tld', $project->id) }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .breadcrumb-section {
        background-color: #1e3a5f !important;
    }
    
    .form-label {
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .form-control, .form-select {
        font-size: 0.875rem;
    }
    
    .form-control:read-only {
        background-color: #f8f9fa;
    }
    
    .btn {
        font-size: 0.875rem;
    }
    
    .btn-primary {
        background-color: #1e3a5f;
        border-color: #1e3a5f;
    }
    
    .btn-primary:hover {
        background-color: #162c46;
        border-color: #162c46;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #5a6268;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar');
        const breadcrumbContainer = document.getElementById('breadcrumb-container');
        
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    const isSidebarCollapsed = sidebar.classList.contains('collapsed');
                    breadcrumbContainer.style.left = isSidebarCollapsed ? '25px' : '280px';
                }
            });
        });

        observer.observe(sidebar, {
            attributes: true
        });

        // Isi dropdown tahun
        const tahunSelect = document.getElementById('periode_tahun');
        const tahunSekarang = new Date().getFullYear();
        for (let t = 2020; t <= tahunSekarang + 1; t++) {
            const opt = document.createElement('option');
            opt.value = t;
            opt.textContent = t;
            tahunSelect.appendChild(opt);
        }
        // Set tanggal_pemantauan saat submit
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const bulan = document.getElementById('periode_bulan').value;
            const tahun = document.getElementById('periode_tahun').value;
            if (!bulan || !tahun) {
                e.preventDefault();
                alert('Pilih periode bulan dan tahun!');
                return false;
            }
            document.getElementById('tanggal_pemantauan').value = tahun + '-' + bulan + '-01';
        });
    });
</script>
@endpush
@endsection 