@extends('layouts.admin')

@section('content')
<!-- Breadcrumb Section -->


<div style="margin-top: 50px;"></div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the sidebar element
        const sidebar = document.querySelector('.sidebar');
        const breadcrumbContainer = document.getElementById('breadcrumb-container');
        
        // Create a MutationObserver to watch for class changes on the sidebar
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    // Check if sidebar is collapsed
                    const isSidebarCollapsed = sidebar.classList.contains('collapsed');
                    // Update breadcrumb container position
                    breadcrumbContainer.style.left = isSidebarCollapsed ? '25px' : '280px';
                }
            });
        });

        // Start observing the sidebar for class changes
        observer.observe(sidebar, {
            attributes: true
        });
    });
</script>
@endpush

<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4 ps-3">
        <h2 class="fw-bold">Ketersediaan SDM</h2>
    </div>

    <!-- Daftar Project Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1">Daftar Project</h5>
                    <p class="text-muted mb-0">Menampilkan Daftar Project Instansi</p>
                </div>
                
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
                        <select class="form-select form-select-sm me-2" style="width: auto;" id="perPage">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
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

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col">Nama Proyek</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Tanggal Mulai</th>
                            <th scope="col">Tanggal Selesai</th>                            <th scope="col" class="text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody id="projectTableBody">
                        @include('admin.sdm.search')
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <span class="text-muted" id="pagination-info">Menampilkan {{ $projects->firstItem() ?? 0 }} sampai {{ $projects->lastItem() ?? 0 }} dari {{ $projects->total() }} data</span>
                </div>
                <nav aria-label="Page navigation" id="pagination-links">
                    {{ $projects->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    .bg-dark-blue {
        background-color: #1e3a5f;
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
    
    .table-dark th {
        background-color: #1e3a5f;
        border-color: #1e3a5f;
        color: white;
        font-weight: 600;
        padding: 12px 8px;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .btn-sm {
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .alert-light {
        background-color: #f8f9fa;
        border-color: #dee2e6;
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
    
    .pagination .page-link {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #ffffff;
    }

    .pagination-dark-link {
        background-color: #1e3a5f !important;
        border-color: #1e3a5f !important;
        color: white !important;
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

@push('scripts')
<script>
    $(document).ready(function() {
        function fetchProjects(page = 1, search = '', perPage = 10) {
            $.ajax({
                url: '{{ route('admin.sdm.search') }}',
                type: 'GET',
                data: {
                    page: page,
                    search: search,
                    perPage: perPage
                },
                success: function(response) {
                    $('#projectTableBody').html(response.html.table);
                    $('#pagination-links').html(response.html.pagination);
                    $('#pagination-info').text(response.html.info);
                },
                error: function() {
                    alert('Gagal memuat data.');
                }
            });
        }
        let searchTimeout;
        function getPerPage() {
            return $('#perPage').val();
        }
        $('#search').on('keyup', function() {
            clearTimeout(searchTimeout);
            const searchValue = $(this).val();
            searchTimeout = setTimeout(function() {
                fetchProjects(1, searchValue, getPerPage());
            }, 300);
        });
        $('#perPage').on('change', function() {
            fetchProjects(1, $('#search').val(), getPerPage());
        });
        $(document).on('click', '#pagination-links .pagination a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            const page = url.split('page=')[1];
            const searchValue = $('#search').val();
            fetchProjects(page, searchValue, getPerPage());
        });
        // Delete confirmation with SweetAlert2
        $(document).on('click', '.delete-project', function() {
            const projectId = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data proyek ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/projects/${projectId}`,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Dihapus!',
                                'Proyek berhasil dihapus.',
                                'success'
                            ).then(() => {
                                location.reload(); // Reload page to update table
                            });
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus proyek.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
@endsection