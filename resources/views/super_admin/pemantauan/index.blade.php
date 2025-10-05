@extends('layouts.super_admin')

@section('content')


<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4">
        @if (Request::routeIs('super_admin.tld.search'))
            <h2 class="fw-bold">Pemantauan Dosis TLD</h2>
        @elseif (Request::routeIs('super_admin.pendos.search'))
            <h2 class="fw-bold">Pemantauan Dosis Pendos</h2>
        @else
            <h2 class="fw-bold">Pemantauan Dosis</h2>
        @endif
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
                        <select class="form-select form-select-sm me-2" style="width: auto;">
                            <option>5</option>
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
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
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="projectTableBody">
                        @include('super_admin.pemantauan.search')
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <span class="text-muted">Menampilkan {{ $projects->firstItem() ?? 0 }} sampai {{ $projects->lastItem() ?? 0 }} dari {{ $projects->total() }} data</span>
                </div>
                <nav aria-label="Page navigation">
                    {{ $projects->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
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
</style>

@push('scripts')
<script>
    $(document).ready(function() {
        const searchInput = $('#search');
        const projectTableBody = $('#projectTableBody');

        searchInput.on('keyup', function() {
            const searchValue = $(this).val().toLowerCase();
            let found = false;

            projectTableBody.find('tr').each(function() {
                const row = $(this);
                // This is to avoid matching the "no data" message row
                if (row.find('td[colspan]').length > 0) {
                    return;
                }
                const rowText = row.text().toLowerCase();

                if (rowText.includes(searchValue)) {
                    row.show();
                    found = true;
                } else {
                    row.hide();
                }
            });

            // Handle "no results" message
            const noResultsRow = projectTableBody.find('.no-results');
            if (!found && searchValue !== "") {
                if (noResultsRow.length === 0) {
                    projectTableBody.append('<tr class="no-results"><td colspan="6" class="text-center">Tidak ada data yang cocok.</td></tr>');
                }
            } else {
                noResultsRow.remove();
            }
        });
    });
</script>
@endpush
@endsection 