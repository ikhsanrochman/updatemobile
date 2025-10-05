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

<div class="container-fluid px-3">
    <!-- Header -->
    <div class="mb-4 pt-2">
        <h2 class="fw-bold h3 mb-3">Kelola Project</h2>
    </div>

    <!-- Daftar Project Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-3 p-md-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
                <div>
                    <h5 class="fw-bold mb-1">Daftar Project</h5>
                    <p class="text-muted mb-0 small">Menampilkan Daftar Project Instansi</p>
                </div>
                <a href="{{ route('super_admin.projects.create') }}" class="btn btn-dark-custom btn-sm">
                    <i class="fas fa-plus me-2"></i>Tambah data
                </a>
            </div>

            <!-- Instructions -->
            <div class="alert alert-custom-info mb-4">
                <div class="d-flex align-items-start">
                    <div class="info-icon-circle text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 24px; height: 24px; font-size: 12px;">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-2">PETUNJUK !</h6>
                        <ul class="mb-0 small">
                            <li>Gunakan kolom pencarian di atas tabel untuk mencari daftar proyek</li>
                            <li>Gunakan tombol detail untuk mengakses informasi mengenai data proyek</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <span class="me-2">Menampilkan</span>
                        <select name="per_page" class="form-select form-select-sm me-2" style="width: auto;">
                            @foreach([5, 10, 25, 50, 100] as $size)
                                <option value="{{ $size }}" {{ session('projects_per_page', 10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                        <span>data per halaman</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        <div class="input-group" style="width: 250px;">
                            <input type="text" id="search" class="form-control form-control-sm border-end-0" placeholder="Search">
                            <span class="input-group-text bg-white border-start-0">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <span class="ms-2 align-self-center"></span>
                    </div>
                </div>
            </div>

            <!-- Table & Pagination (AJAX loaded) -->
            <div id="table-data-wrapper">
                @include('super_admin.projects.table-data')
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
        overflow-x: hidden;
        max-width: 100vw;
    }

    .bg-navy-blue {
        background-color: #002B5B;
    }
    
    @media (max-width: 768px) {
        .bg-navy-blue > div {
            margin-left: 0 !important;
        }
    }
    
    .table-dark th {
        background-color: #1e3a5f;
        border-color: #1e3a5f;
        color: white;
        font-weight: 600;
        padding: 12px 8px;
        font-size: 0.9rem;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
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
    
    .form-select-sm, .form-control-sm {
        font-size: 0.875rem;
    }
    
    .pagination {
        margin: 0;
    }
    
    .page-link {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #1e3a5f;
        border-color: #1e3a5f;
        color: #ffffff;
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

    .table-responsive {
        border-radius: 8px;
        border: 1px solid #dee2e6;
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

        .table > :not(caption) > * > * {
            padding: 0.5rem;
        }

        .btn-group-sm > .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .page-link {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    }

    @media (max-width: 576px) {
        .breadcrumb-item {
            font-size: 0.8rem;
        }
        
        .breadcrumb-item:not(:last-child) {
            display: none;
        }

        .card {
            border-radius: 12px;
        }

        .table-responsive {
            margin-left: -1rem;
            margin-right: -1rem;
            border-radius: 0;
            border-left: 0;
            border-right: 0;
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

@push('scripts')
<script>
    $(document).ready(function() {
        // Delete project
        $('.delete-project').click(function() {
            const projectId = $(this).data('id');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/super-admin/projects/${projectId}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Terhapus!',
                                'Data proyek berhasil dihapus.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat menghapus data.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        // AJAX for search
        $(document).on('keyup', '#search', function() {
            const search = $(this).val();
            const url = window.location.pathname;
            $.ajax({
                url: url,
                type: 'GET',
                data: { search: search },
                dataType: 'html',
                success: function(response) {
                    $('#table-data-wrapper').html(response);
                },
                error: function() {
                    alert('Gagal memuat data.');
                }
            });
        });

        // AJAX for per_page dropdown
        $(document).on('change', 'select[name="per_page"]', function(e) {
            e.preventDefault();
            const perPage = $(this).val();
            const url = window.location.pathname; // URL tanpa query string
            $.ajax({
                url: url,
                type: 'GET',
                data: { per_page: perPage },
                dataType: 'html',
                success: function(response) {
                    $('#table-data-wrapper').html(response);
                },
                error: function() {
                    alert('Gagal memuat data.');
                }
            });
        });

        // Re-bind delete button after AJAX load
        $(document).on('click', '.delete-project', function() {
            const projectId = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/super-admin/projects/${projectId}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Terhapus!',
                                'Data proyek berhasil dihapus.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat menghapus data.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        // AJAX for pagination
        $(document).on('click', '#table-data-wrapper .pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html',
                success: function(response) {
                    $('#table-data-wrapper').html(response);
                },
                error: function() {
                    alert('Gagal memuat data.');
                }
            });
        });
    });
</script>
@endpush
@endsection 