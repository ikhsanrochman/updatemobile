@extends('layouts.super_admin')

@section('content')
<!-- Breadcrumb Section -->


<div class="container-fluid px-4">
    <!-- Header -->
    <div class="mb-4">
        <h2 class="fw-bold">Perizinan Sumber Radiasi</h2>
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
                            <th scope="col">Tanggal Selesai</th>
                            <th scope="col" class="text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody id="projectTableBody">
                        @include('super_admin.perizinan.search')
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
    .page-breadcrumb {
        margin-bottom: 20px;
    }

    .breadcrumb-item a {
        color: #002B5B !important;
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        text-decoration: underline;
    }

    .breadcrumb-item.active {
        color: #6c757d !important;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        color: #6c757d;
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
    
    .alert-custom-info {
        background-color: #e9ecef;
        border: none;
    }

    .info-icon-circle {
        background-color: #343a40;
    }
    
    .form-select-sm, .form-control-sm {
        font-size: 0.875rem;
    }

    .text-blue {
        color: #002B5B !important;
    }

    .text-secondary {
        color: #6c757d !important;
    }
</style>

@push('scripts')
<script>
    $(document).ready(function() {
        function fetchProjects(page = 1, search = '', perPage = 10) {
            $.ajax({
                url: '{{ route('super_admin.perizinan.search') }}',
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
    });
</script>
@endpush
@endsection 