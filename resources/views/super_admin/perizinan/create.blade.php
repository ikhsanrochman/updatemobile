@extends('layouts.super_admin')

@section('content')
<!-- Breadcrumb Section -->

<div style="margin-top: 120px;"></div>

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
                    breadcrumbContainer.style.left = isSidebarCollapsed ? '30px' : '280px';
                    if (mainContentWrapper) {
                        mainContentWrapper.style.marginLeft = isSidebarCollapsed ? '30px' : '280px';
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

<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Tambah Perizinan</h2>
        <a href="{{ route('super_admin.perizinan.detail', $project->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-secondary text-white py-3">
            <h5 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2"></i>Form Tambah Perizinan</h5>
        </div>
        <div class="card-body bg-light">
            <form action="{{ route('super_admin.perizinan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-bold">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tipe" class="form-label fw-bold">Tipe</label>
                            <input type="text" class="form-control @error('tipe') is-invalid @enderror" id="tipe" name="tipe" value="{{ old('tipe') }}" required>
                            @error('tipe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="no_seri" class="form-label fw-bold">No. Seri</label>
                            <input type="text" class="form-control @error('no_seri') is-invalid @enderror" id="no_seri" name="no_seri" value="{{ old('no_seri') }}" required>
                            @error('no_seri')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="aktivitas" class="form-label fw-bold">Aktivitas</label>
                            <input type="text" class="form-control @error('aktivitas') is-invalid @enderror" id="aktivitas" name="aktivitas" value="{{ old('aktivitas') }}" required>
                            @error('aktivitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_aktivitas" class="form-label fw-bold">Tanggal Aktivitas</label>
                            <input type="date" class="form-control @error('tanggal_aktivitas') is-invalid @enderror" id="tanggal_aktivitas" name="tanggal_aktivitas" value="{{ old('tanggal_aktivitas') }}" required>
                            @error('tanggal_aktivitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kv_ma" class="form-label fw-bold">Kv-mA</label>
                            <input type="text" class="form-control @error('kv_ma') is-invalid @enderror" id="kv_ma" name="kv_ma" value="{{ old('kv_ma') }}">
                            @error('kv_ma')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="no_ktun" class="form-label fw-bold">No. KTUN</label>
                            <input type="text" class="form-control @error('no_ktun') is-invalid @enderror" id="no_ktun" name="no_ktun" value="{{ old('no_ktun') }}" required>
                            @error('no_ktun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_berlaku" class="form-label fw-bold">Tanggal Berlaku</label>
                            <input type="date" class="form-control @error('tanggal_berlaku') is-invalid @enderror" id="tanggal_berlaku" name="tanggal_berlaku" value="{{ old('tanggal_berlaku') }}" required>
                            @error('tanggal_berlaku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    .breadcrumb-section {
        background-color: #1e3a5f;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        color: #ffffff;
    }
    
    .breadcrumb-item a {
        color: #ffffff;
    }
    
    .breadcrumb-item a:hover {
        color: #e0e0e0;
    }
    
    .breadcrumb-item.active {
        color: #ffffff;
        font-weight: 500;
    }

    .card {
        border-radius: 8px;
    }

    .bg-dark-blue {
        background-color: #1e3a5f;
    }
</style>
@endsection 