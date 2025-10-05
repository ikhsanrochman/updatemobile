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
    <div class="mb-4 pt-2">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold">Detail Perizinan Sumber Radiasi :  {{ $project->nama_proyek }}</h2>
            <a href="{{ route('super_admin.perizinan.index') }}" class="btn btn-dark-custom btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>    <!-- Detail Section -->
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
    </div>    <!-- Data Perizinan Sumber Radiasi Pengion Section -->    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-secondary text-white py-3">
            <h5 class="fw-bold mb-0"><i class="fas fa-info-circle me-2"></i>Data Perizinan Sumber Radiasi Pengion</h5>
        </div>
        <div class="card-body bg-light">            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('super_admin.perizinan.create', ['project_id' => $project->id]) }}" class="btn btn-secondary">
                    <i class="fas fa-plus me-2"></i>Tambah data
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="bg-dark-blue text-white">
                            <th scope="col" class="text-center">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Tipe</th>
                            <th scope="col">No. Seri</th>
                            <th scope="col">Aktivitas</th>
                            <th scope="col">Tanggal Aktivitas</th>
                            <th scope="col">Kv-mA</th>
                            <th scope="col">No. KTUN</th>
                            <th scope="col">Tanggal berlaku</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>                    <tbody>
                        @forelse($perizinanSumberRadiasiPengion as $index => $izin)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $izin->nama }}</td>
                                <td>{{ $izin->tipe }}</td>
                                <td>{{ $izin->no_seri }}</td>
                                <td>{{ $izin->aktivitas }}</td>
                                <td>{{ $izin->tanggal_aktivitas ? $izin->tanggal_aktivitas->format('d-m-Y') : '-' }}</td>
                                <td>{{ $izin->kv_ma ?? '-' }}</td>
                                <td>{{ $izin->no_ktun }}</td>
                                <td>{{ $izin->tanggal_berlaku ? $izin->tanggal_berlaku->format('d-m-Y') : '-' }}</td>
                                <td class="text-center">
                                    <form action="{{ route('super_admin.perizinan.destroy', $izin->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm me-1" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                    <a href="{{ route('super_admin.perizinan.edit', $izin->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data perizinan</td>
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
    }      .table thead tr th {
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
        background-color: #1e3a5f; /* Adjusted to dark blue to match image headers */
        color: #ffffff; /* Changed to white text color to match image headers */
    }

    .bg-custom-light-gray {
        background-color: white; /* Remains white to match image card bodies */
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