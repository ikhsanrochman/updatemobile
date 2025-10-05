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

        // Client-side search for project table
        const searchInput = document.getElementById('search-project');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('table tbody tr');
                rows.forEach(row => {
                    // Gabungkan semua kolom yang ingin dicari
                    const text = Array.from(row.querySelectorAll('td')).map(td => td.textContent.toLowerCase()).join(' ');
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        }
    });
</script>
@endpush

<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4 ps-3">
        <h2 class="fw-bold">Laporan Proyek</h2>
        <p class="text-muted">Ringkasan dan detail semua proyek dalam sistem</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs text-primary text-uppercase fw-bold mb-1">
                                Total Proyek</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalProjects }}</div>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                            <i class="fas fa-calendar fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    <!-- Projects Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1">Daftar Proyek</h5>
                    <p class="text-muted mb-0">Detail semua proyek dalam sistem</p>
                </div>
            </div>

            <!-- Instructions -->
            <div class="alert alert-custom-info mb-4">
                <div class="d-flex align-items-start">
                    <div class="info-icon-circle text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 24px; height: 24px; font-size: 12px;">
                        <i class="fas fa-info"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-2">INFORMASI !</h6>
                        <ul class="mb-0 small">
                            <li>Klik tombol "Detail" untuk melihat informasi lengkap proyek</li>
                            <li>Setiap proyek menampilkan statistik perizinan, SDM, dan pemantauan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="row mb-3">
                <div class="col-12 col-md-6 col-lg-4 ms-auto">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="search-project" class="form-control border-start-0" 
                               placeholder="Cari proyek, keterangan, tanggal...">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col">Nama Proyek</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Tanggal Mulai</th>
                            <th scope="col">Tanggal Selesai</th>
                            <th scope="col" class="text-center">Perizinan</th>
                            <th scope="col" class="text-center">SDM</th>
                            <th scope="col" class="text-center">TLD</th>
                            <th scope="col" class="text-center">Pendose</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $project->nama_proyek }}</strong>
                            </td>
                            <td>{{ $project->keterangan ?: '-' }}</td>
                            <td>{{ $project->tanggal_mulai->format('d/m/Y') }}</td>
                            <td>{{ $project->tanggal_selesai->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $project->perizinanSumberRadiasiPengion->count() }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-warning">
                                    {{ $project->ketersediaanSdm->flatMap->users->count() }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger">{{ $project->pemantauanDosisTld->count() }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $project->pemantauanDosisPendose->count() }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('super_admin.laporan.project_detail', $project->id) }}" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data proyek</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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

    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }

    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }

    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }

    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }

    .border-left-danger {
        border-left: 0.25rem solid #e74a3b !important;
    }

    .border-left-secondary {
        border-left: 0.25rem solid #858796 !important;
    }

    .text-xs {
        font-size: 0.7rem;
    }

    .text-gray-800 {
        color: #5a5c69 !important;
    }

    .text-gray-300 {
        color: #dddfeb !important;
    }

    .alert-custom-info {
        background-color: #e9ecef;
        border: none;
    }

    .info-icon-circle {
        background-color: #1e3a5f;
    }

    .badge {
        font-size: 0.75rem;
    }

    /* Responsive Table Styles */
    .table-responsive {
        margin: 0;
        padding: 0;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Additional Responsive Utilities */
    @media (max-width: 768px) {
        .table td, .table th {
            white-space: nowrap;
            min-width: 100px;
        }
        
        .card-body {
            padding: 1rem;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }

        .card {
            margin-bottom: 1rem;
        }

        .h5, h5 {
            font-size: 1.1rem;
        }

        .alert-custom-info {
            padding: 0.75rem;
        }
    }
</style>
@endsection
