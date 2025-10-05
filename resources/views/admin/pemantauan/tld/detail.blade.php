@extends('layouts.admin')

@section('content')
<!-- Breadcrumb Section -->


<div style="margin-top: 50px;"></div>

<div class="container-fluid">
    <!-- Header and Back Button Row -->
    <div class="d-flex align-items-center mb-4 justify-content-between">
        <h2 class="fw-bold mb-0">Detail Dosis TLD</h2>
        <a href="{{ route('admin.pemantauan.tld', $project->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
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
                            <td>{{ $project->tanggal_mulai }}</td>
                        </tr>
                        <tr>
                            <td class="ps-0">Tanggal Selesai</td>
                            <td class="px-3">:</td>
                            <td>{{ $project->tanggal_selesai }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Petugas -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-light">
            <h6 class="fw-bold mb-3">Informasi Petugas</h6>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="ps-0" style="width: 140px;">Nama</td>
                            <td class="px-3">:</td>
                            <td>{{ $user->nama }}</td>
                        </tr>
                        <tr>
                            <td class="ps-0">NPR</td>
                            <td class="px-3">:</td>
                            <td>{{ $user->npr ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="ps-0" style="width: 140px;">Jenis Pekerja</td>
                            <td class="px-3">:</td>
                            <td>
                                @if($user->jenisPekerja->isNotEmpty())
                                    {{ $user->jenisPekerja->first()->nama }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-0">Keahlian</td>
                            <td class="px-3">:</td>
                            <td>{{ $user->keahlian ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Dosis TLD -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Riwayat Dosis TLD {{ $user->nama }}</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal Pemantauan</th>
                            <th class="text-center">Dosis</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dosisTlds->sortBy('tanggal_pemantauan') as $key => $dosisTld)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $dosisTld->tanggal_pemantauan }}</td>
                                <td class="text-center">{{ $dosisTld->dosis }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.tld.edit', ['projectId' => $project->id, 'userId' => $user->id, 'dosisId' => $dosisTld->id]) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <form action="{{ route('admin.pemantauan.tld.destroy', ['projectId' => $project->id, 'userId' => $user->id, 'dosisId' => $dosisTld->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data dosis TLD untuk petugas ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .breadcrumb-section {
        background-color: #1e3a5f !important;
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

    .form-control-sm {
        height: calc(1.5em + 0.5rem + 2px);
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.2rem;
    }

    .input-group-text {
        border-left: 0;
    }

    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>

@endsection 