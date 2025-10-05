@extends('layouts.admin')

@section('content')


<div style="margin-top: 50px;"></div>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Edit Perizinan</h2>
        <a href="{{ route('admin.perizinan.detail', $perizinan->project_id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-body bg-light">
            <!-- Warning Message -->
            <div class="alert alert-warning mb-4">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>PERINGATAN!</strong>
                <span class="ms-2">Pastikan memperbaharui data dengan benar</span>
            </div>

            <div class="row">
                <!-- Left Column - Project Details -->
                <div class="col-md-4 mb-4">
                    <!-- Title Box -->
                    <div class="bg-white p-4 rounded shadow-sm mb-4">
                        <h3 class="h2 fw-bold mb-0">{{ old('nama', $perizinan->nama) }}</h3>
                    </div>
                    
                    <!-- Project Details Box -->
                    <div class="bg-white p-4 rounded shadow-sm">
                        <div class="project-details">
                            <div class="mb-3">
                                <p class="mb-1">Nama Proyek</p>
                                <h6 class="text-muted">{{ $perizinan->project->nama_proyek }}</h6>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1">Keterangan</p>
                                <h6 class="text-muted">{{ $perizinan->project->keterangan }}</h6>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1">Diupload pada</p>
                                <h6 class="text-muted">{{ $perizinan->created_at->format('d/M/Y') }}</h6>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1">Diperbarui pada</p>
                                <h6 class="text-muted">{{ $perizinan->updated_at->format('d/M/Y') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Form -->
                <div class="col-md-8">
                    <form action="{{ route('admin.perizinan.update', $perizinan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label fw-bold">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $perizinan->nama) }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                        
                                <div class="mb-3">
                                    <label for="tipe" class="form-label fw-bold">Tipe</label>
                                    <input type="text" class="form-control @error('tipe') is-invalid @enderror" id="tipe" name="tipe" value="{{ old('tipe', $perizinan->tipe) }}" required>
                                    @error('tipe')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="no_seri" class="form-label fw-bold">No. Seri</label>
                                    <input type="text" class="form-control @error('no_seri') is-invalid @enderror" id="no_seri" name="no_seri" value="{{ old('no_seri', $perizinan->no_seri) }}" required>
                                    @error('no_seri')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="aktivitas" class="form-label fw-bold">Aktivitas</label>
                                    <input type="text" class="form-control @error('aktivitas') is-invalid @enderror" id="aktivitas" name="aktivitas" value="{{ old('aktivitas', $perizinan->aktivitas) }}" required>
                                    @error('aktivitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_aktivitas" class="form-label fw-bold">Tanggal Aktivitas</label>
                                    <input type="date" class="form-control @error('tanggal_aktivitas') is-invalid @enderror" id="tanggal_aktivitas" name="tanggal_aktivitas" value="{{ old('tanggal_aktivitas', $perizinan->tanggal_aktivitas->format('Y-m-d')) }}" required>
                                    @error('tanggal_aktivitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="kv_ma" class="form-label fw-bold">Kv-mA</label>
                                    <input type="text" class="form-control @error('kv_ma') is-invalid @enderror" id="kv_ma" name="kv_ma" value="{{ old('kv_ma', $perizinan->kv_ma) }}">
                                    @error('kv_ma')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="no_ktun" class="form-label fw-bold">No. KTUN</label>
                                    <input type="text" class="form-control @error('no_ktun') is-invalid @enderror" id="no_ktun" name="no_ktun" value="{{ old('no_ktun', $perizinan->no_ktun) }}" required>
                                    @error('no_ktun')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_berlaku" class="form-label fw-bold">Tanggal Berlaku</label>
                                    <input type="date" class="form-control @error('tanggal_berlaku') is-invalid @enderror" id="tanggal_berlaku" name="tanggal_berlaku" value="{{ old('tanggal_berlaku', $perizinan->tanggal_berlaku->format('Y-m-d')) }}" required>
                                    @error('tanggal_berlaku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
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
    }

    .card {
        border-radius: 8px;
    }

    .bg-dark-blue {
        background-color: #1e3a5f;
    }

    .form-label {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border-radius: 6px;
        padding: 0.6rem 1rem;
        border: 1px solid #ced4da;
    }

    .form-control:focus {
        border-color: #1e3a5f;
        box-shadow: 0 0 0 0.2rem rgba(30, 58, 95, 0.25);
    }

    .btn-primary {
        background-color: #1e3a5f;
        border-color: #1e3a5f;
    }

    .btn-primary:hover {
        background-color: #152c47;
        border-color: #152c47;
    }

    .project-details p {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    .project-details h6 {
        font-size: 1rem;
        margin-bottom: 0;
    }

    .bg-white {
        background-color: #ffffff;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar');
        const breadcrumbContainer = document.getElementById('breadcrumb-container');
        
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    const isSidebarCollapsed = sidebar.classList.contains('collapsed');
                    breadcrumbContainer.style.left = isSidebarCollapsed ? '25px' : '280px';
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
