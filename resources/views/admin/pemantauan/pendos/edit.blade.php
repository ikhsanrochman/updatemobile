@extends('layouts.admin')

@section('content')


<div style="margin-top: 50px;"></div>

<div class="container-fluid">
    <!-- Informasi Project -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-light">
            <h6 class="fw-bold mb-3">Informasi Project</h6>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="ps-0" style="width: 140px;">Nama Proyek</td>
                            <td class="px-3">:</td>
                            <td>{{ $project->nama_proyek }}</td>
                        </tr>
                        <tr>
                            <td class="ps-0">Keterangan</td>
                            <td class="px-3">:</td>
                            <td>{{ $project->keterangan }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="ps-0" style="width: 140px;">Tanggal Mulai</td>
                            <td class="px-3">:</td>
                            <td>{{ $project->tanggal_mulai ? $project->tanggal_mulai->format('d F Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="ps-0">Tanggal Selesai</td>
                            <td class="px-3">:</td>
                            <td>{{ $project->tanggal_selesai ? $project->tanggal_selesai->format('d F Y') : '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Dosis Pendos Form Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h6 class="fw-bold mb-4">Edit Data Dosis Pemantauan Pendos</h6>

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

            <form action="{{ route('admin.pemantauan.pendos.update', ['projectId' => $project->id, 'userId' => $user->id, 'dosisId' => $dosisPendos->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama SDM</label>
                            <input type="text" class="form-control" id="nama" value="{{ $user->nama }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_pengukuran" class="form-label">Tanggal Pengukuran <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_pengukuran') is-invalid @enderror" id="tanggal_pengukuran" name="tanggal_pengukuran" value="{{ old('tanggal_pengukuran', $dosisPendos->tanggal_pengukuran ? \Carbon\Carbon::parse($dosisPendos->tanggal_pengukuran)->format('Y-m-d') : '') }}" required>
                            @error('tanggal_pengukuran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="hasil_pengukuran" class="form-label">Hasil Pengukuran (mSv) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('hasil_pengukuran') is-invalid @enderror" id="hasil_pengukuran" name="hasil_pengukuran" value="{{ old('hasil_pengukuran', $dosisPendos->hasil_pengukuran) }}" required>
                            @error('hasil_pengukuran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('admin.pendos.user.detail', ['projectId' => $project->id, 'userId' => $user->id]) }}" class="btn btn-secondary">
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
        font-weight: normal;
        font-size: 0.875rem;
    }
    
    .table td {
        font-size: 0.875rem;
        vertical-align: middle;
    }

    .table-bordered td, .table-bordered th {
        border-color: #dee2e6;
    }

    .bg-light {
        background-color: #f8f9fa !important;
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

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
        color: #000;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .card-header {
        border-bottom: 1px solid #dee2e6;
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
@endsection 