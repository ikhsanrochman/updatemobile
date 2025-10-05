@extends('layouts.super_admin')

@section('content')
<!-- Breadcrumb Section -->


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

            <form action="{{ route('super_admin.pemantauan.pendos.update', ['projectId' => $project->id, 'userId' => $user->id, 'dosisId' => $dosisPendos->id]) }}" method="POST">
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
                            <label for="tanggal_pemantauan" class="form-label">Tanggal Pengukuran <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_pemantauan') is-invalid @enderror" id="tanggal_pemantauan" name="tanggal_pemantauan" value="{{ old('tanggal_pemantauan', $dosisPendos->tanggal_pengukuran ? \Carbon\Carbon::parse($dosisPendos->tanggal_pengukuran)->format('Y-m-d') : '') }}" required>
                            @error('tanggal_pemantauan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="dosis" class="form-label">Hasil Pengukuran (mSv) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('dosis') is-invalid @enderror" id="dosis" name="dosis" value="{{ old('dosis', $dosisPendos->hasil_pengukuran) }}" required>
                            @error('dosis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('super_admin.pemantauan.pendos.detail', ['projectId' => $project->id, 'userId' => $user->id]) }}" class="btn btn-secondary">
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
    .breadcrumb-item a {
        color: #6c757d;
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        color: #002B5B;
    }

    .breadcrumb-item.active {
        color: #002B5B;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: #6c757d;
    }
    
    .page-breadcrumb {
        padding: 15px 0;
    }

    .table td {
        font-size: 0.875rem;
        vertical-align: middle;
    }
    
    .form-control,
    .form-select {
        font-size: 0.875rem;
    }
</style>
@endsection
