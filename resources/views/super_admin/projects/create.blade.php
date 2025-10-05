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

<div class="container-fluid px-4 py-3">
    <!-- Header -->
    <div class="mb-4 pt-2">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <h2 class="fw-bold h3 mb-0">Tambah Data Project</h2>
            <a href="{{ route('super_admin.projects.index') }}" class="btn btn-dark-custom btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-3 p-md-4">
            <!-- Alert Section -->
            <div class="alert alert-custom-info mb-3">
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

            <form action="{{ route('super_admin.projects.store') }}" method="POST">
                @csrf
                <div class="mb-2">
                    <label for="nama_proyek" class="form-label">Nama Project</label>
                    <input type="text" class="form-control" id="nama_proyek" name="nama_proyek" required>
                </div>
                <div class="mb-2">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                </div>
                <div class="mb-2">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                </div>
                <div class="mb-2">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea>
                </div>
                
                <button type="submit" class="btn btn-dark-custom mt-2">
                    <i class="fas fa-save me-2"></i>Save
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    .bg-navy-blue {
        background-color: #002B5B;
    }
    
    @media (max-width: 768px) {
        .bg-navy-blue > div {
            margin-left: 0 !important;
        }
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
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
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

    @media (max-width: 768px) {
        #breadcrumb-container {
            left: 0 !important;
            right: 0 !important;
            top: 60px !important;
        }

        .breadcrumb {
            font-size: 0.85rem;
        }

        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }

        .card-body {
            padding: 1rem !important;
        }

        h2 {
            font-size: 1.5rem;
        }

        .alert {
            padding: 0.75rem;
        }

        .form-label {
            font-size: 0.9rem;
        }

        .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
        }
    }

    /* Improve form inputs on mobile */
    .form-control {
        font-size: 0.9rem;
        padding: 0.375rem 0.75rem;
    }

    @media (max-width: 576px) {
        .breadcrumb-item {
            font-size: 0.8rem;
        }
        
        .breadcrumb-item:not(:last-child) {
            display: none;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const breadcrumbNav = document.querySelector('.bg-navy-blue > div');
    
    function updateBreadcrumbMargin() {
        if (window.innerWidth <= 768) {
            breadcrumbNav.style.marginLeft = '0';
        } else {
            breadcrumbNav.style.marginLeft = sidebar.classList.contains('collapsed') ? '30px' : '280px';
        }
    }

    // Observer for sidebar changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                updateBreadcrumbMargin();
            }
        });
    });

    observer.observe(sidebar, { attributes: true });

    // Handle window resize
    window.addEventListener('resize', updateBreadcrumbMargin);

    // Initial call
    updateBreadcrumbMargin();
});
</script>
@endsection