@extends('layouts.admin')

@section('content')
<!-- Breadcrumb Section -->


<div style="margin-top: 50px;"></div>

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
    });
</script>
@endpush

<div class="container-fluid">
    <!-- Header and Back Button Row -->
    <div class="d-flex align-items-center mb-4 justify-content-between">
        <h2 class="fw-bold mb-0">Edit Project</h2>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <!-- Alert Section -->
            <div class="alert alert-custom-info mb-2">
                <div class="d-flex align-items-start">
                    <div class="info-icon-circle text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 24px; height: 24px; font-size: 12px;">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-2">PERINGATAN !</h6>
                        <ul class="mb-0 small">
                            <li>Pastikan memperbaharui data dengan benar</li>
                        </ul>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.projects.update', $project->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-2">
                    <label for="nama_proyek" class="form-label">Nama Project</label>
                    <input type="text" class="form-control" id="nama_proyek" name="nama_proyek" value="{{ old('nama_proyek', $project->nama_proyek) }}" required>
                </div>
                <div class="mb-2">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $project->tanggal_mulai->format('Y-m-d')) }}" required>
                </div>
                <div class="mb-2">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $project->tanggal_selesai->format('Y-m-d')) }}" required>
                </div>
                <div class="mb-2">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="2">{{ old('keterangan', $project->keterangan) }}</textarea>
                </div>
                
                <button type="submit" class="btn btn-dark-custom mt-2">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
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
    
    .alert-custom-info {
        background-color: #e9ecef;
        border: none;
    }

    .info-icon-circle {
        background-color: #343a40;
    }
    
    .card {
        border-radius: 8px;
    }

    .btn-dark-custom {
        background-color: #1e3a5f;
        border-color: #1e3a5f;
        color: white;
    }

    .btn-dark-custom:hover {
        background-color: #162c46;
        border-color: #162c46;
        color: white;
    }
</style>
@endsection