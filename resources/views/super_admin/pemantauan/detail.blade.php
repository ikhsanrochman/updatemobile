@extends('layouts.super_admin')

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
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Detail Pemantauan : {{ $project->nama_proyek }}</h2>
        <a href="{{ route('super_admin.pemantauan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Detail Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-secondary text-white py-3">
            <h5 class="fw-bold mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Project</h5>
        </div>
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-2"><span class="fw-bold">Nama Project</span> : {{ $project->nama_proyek }}</p>
                    <p class="mb-0"><span class="fw-bold">Keterangan</span> : {{ $project->keterangan }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><span class="fw-bold">Tanggal Mulai</span> : {{ $project->tanggal_mulai->format('d-M-Y') }}</p>
                    <p class="mb-0"><span class="fw-bold">Tanggal Selesai</span> : {{ $project->tanggal_selesai->format('d-M-Y') }}</p>
                </div>
            </div>
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

    .table thead tr th {
        background-color: #1e3a5f;
        color: white;
        font-weight: 600;
        padding: 12px 8px;
        border-color: #1e3a5f;
    }
    
    .card {
        border-radius: 8px;
    }

    .bg-custom-dark-gray {
        background-color: #1e3a5f;
        color: #ffffff;
    }

    .bg-custom-light-gray {
        background-color: white;
    }

    .btn-custom-dark {
        background-color: #1e3a5f;
        color: #ffffff;
        border-color: #1e3a5f;
    }

    .btn-custom-dark:hover {
        background-color: #162f4d;
        border-color: #162f4d;
    }
</style>
@endsection 