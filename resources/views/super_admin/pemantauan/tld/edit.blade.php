@extends('layouts.super_admin')

@section('content')
<!-- Breadcrumb Section -->


<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h6 class="fw-bold mb-4">Edit Data Dosis Pemantauan TLD</h6>

            <form action="{{ route('super_admin.pemantauan.tld.update', ['projectId' => $project->id, 'userId' => $user->id, 'dosisId' => $dosisTld->id]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Informasi Karyawan -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Karyawan</label>
                            <input type="text" class="form-control" value="{{ $user->nama }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">NPR</label>
                            <input type="text" class="form-control" value="{{ $user->npr ?? '-' }}" readonly>
                        </div>
                    </div>
                </div>

                <!-- Form Data TLD -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_pemantauan" class="form-label">Tanggal Pencatatan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_pemantauan') is-invalid @enderror" 
                                id="tanggal_pemantauan" name="tanggal_pemantauan" 
                                value="{{ old('tanggal_pemantauan', $dosisTld->tanggal_pemantauan->format('Y-m-d')) }}" required>
                            @error('tanggal_pemantauan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="dosis" class="form-label">Dosis (mSv) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('dosis') is-invalid @enderror" 
                                id="dosis" name="dosis" value="{{ old('dosis', $dosisTld->dosis) }}" required>
                            @error('dosis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('super_admin.pemantauan.tld.detail', ['projectId' => $project->id, 'userId' => $user->id]) }}" class="btn btn-secondary">
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

<style>
    /* Breadcrumb Styles */
    .page-breadcrumb {
        padding: 15px 20px;
        margin-bottom: 30px;
    }

    .breadcrumb {
        margin: 0;
        background: transparent;
        padding: 0;
    }

    .breadcrumb-item a {
        color: #002B5B !important;
        font-weight: 500;
        transition: color 0.2s;
    }

    .breadcrumb-item a:hover {
        text-decoration: none;
        color: #001B3B !important;
    }

    .breadcrumb-item.active {
        color: #6c757d !important;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        color: #6c757d;
    }

    /* Form Styles */
    .form-label {
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .form-control, .form-select {
        font-size: 0.875rem;
    }
    
    .form-control:read-only {
        background-color: #f8f9fa;
    }
    
    .btn {
        font-size: 0.875rem;
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
</style>


@endsection 