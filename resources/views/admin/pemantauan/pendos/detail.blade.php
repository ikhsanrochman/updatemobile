@extends('layouts.admin')

@section('content')
<!-- Breadcrumb Section -->


<div style="margin-top: 50px;"></div>

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

<div class="container-fluid">
    <!-- Header and Back Button Row -->
    <div class="d-flex align-items-center mb-4 justify-content-between">
        <h2 class="fw-bold mb-0">Detail Pemantauan Pendos</h2>
        <a href="{{ route('admin.pemantauan.pendos', $project->id) }}" class="btn btn-secondary">
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

    <!-- Data Detail Pendos Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <!-- User Information -->
            <div class="card bg-light mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Informasi SDM</h6>
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
                                    <td class="ps-0" style="width: 140px;">Username</td>
                                    <td class="px-3">:</td>
                                    <td>{{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-0">No. SIB</td>
                                    <td class="px-3">:</td>
                                    <td>{{ $user->no_sib ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Yearly Dosis Data Table -->
            <div class="d-flex justify-content-end align-items-center mb-3">
                <button class="btn btn-sm btn-secondary me-2" id="prevYearBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span class="fw-bold me-2" id="currentYearDisplay"></span>
                <button class="btn btn-sm btn-secondary" id="nextYearBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="yearlyDosisTable">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center align-middle" style="width: 80px;">Bulan</th>
                            @for ($i = 1; $i <= 31; $i++)
                                <th class="text-center">{{ $i }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Table rows will be dynamically generated by JavaScript -->
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
        font-weight: normal;
        font-size: 0.875rem;
    }
    
    .table td {
        font-size: 0.875rem;
        vertical-align: middle;
        min-width: 50px; /* Ensure cells have a minimum width */
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

        const dosisData = JSON.parse('{!! json_encode($dosisData) !!}');
        const yearlyDosisTableBody = document.querySelector('#yearlyDosisTable tbody');
        const prevYearBtn = document.getElementById('prevYearBtn');
        const nextYearBtn = document.getElementById('nextYearBtn');
        const currentYearDisplay = document.getElementById('currentYearDisplay');

        let currentYear = new Date().getFullYear();

        const months = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGS', 'SEP', 'OKT', 'NOV', 'DES'];

        function renderYearlyTable(year) {
            currentYearDisplay.textContent = year; // Update the displayed year
            yearlyDosisTableBody.innerHTML = ''; // Clear existing rows

            const dosisByDate = {};
            dosisData.forEach(dosis => {
                const date = new Date(dosis.tanggal_pengukuran);
                if (date.getFullYear() === year) {
                    const month = date.getMonth(); // 0-indexed
                    const day = date.getDate(); // 1-indexed
                    if (!dosisByDate[month]) {
                        dosisByDate[month] = {};
                    }
                    dosisByDate[month][day] = dosis;
                }
            });

            months.forEach((monthName, monthIndex) => {
                const row = document.createElement('tr');
                const monthCell = document.createElement('td');
                monthCell.textContent = monthName;
                row.appendChild(monthCell);

                const daysInMonth = new Date(year, monthIndex + 1, 0).getDate();

                for (let day = 1; day <= 31; day++) {
                    const dayCell = document.createElement('td');
                    dayCell.className = 'text-center';
                    
                    if (day <= daysInMonth) {
                        const dosis = dosisByDate[monthIndex] && dosisByDate[monthIndex][day];
                        if (dosis) {
                            dayCell.innerHTML = `
                                <span>${dosis.hasil_pengukuran ?? '-'}</span>
                                <div class="d-flex justify-content-center gap-1 mt-1">
                                    <button type="button" class="btn btn-warning btn-sm py-0 px-1" onclick="editDosis(${dosis.id})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm py-0 px-1" onclick="deleteDosis(${dosis.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            `;
                        } else {
                            dayCell.textContent = '-';
                        }
                    } else {
                        dayCell.textContent = ''; // Empty for days not in month
                    }
                    row.appendChild(dayCell);
                }
                yearlyDosisTableBody.appendChild(row);
            });
        }

        // Initial render for the current year
        renderYearlyTable(currentYear);

        // Event listeners for year navigation buttons
        prevYearBtn.addEventListener('click', function() {
            currentYear--;
            renderYearlyTable(currentYear);
        });

        nextYearBtn.addEventListener('click', function() {
            currentYear++;
            renderYearlyTable(currentYear);
        });
    });

    function editDosis(id) {
        const projectId = {{ $project->id }};
        const userId = {{ $user->id }};
        window.location.href = `{{ route('admin.pemantauan.pendos.edit', ['projectId' => ':projectId', 'userId' => ':userId', 'dosisId' => ':dosisId']) }}`
            .replace(':projectId', projectId)
            .replace(':userId', userId)
            .replace(':dosisId', id);
    }

    function deleteDosis(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            const projectId = {{ $project->id }};
            const userId = {{ $user->id }};
            fetch(`{{ route('admin.pemantauan.pendos.destroy', ['projectId' => ':projectId', 'userId' => ':userId', 'dosisId' => ':dosisId']) }}`
                .replace(':projectId', projectId)
                .replace(':userId', userId)
                .replace(':dosisId', id), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Data dosis berhasil dihapus');
                    location.reload(); // Reload page to update table
                } else {
                    alert('Terjadi kesalahan: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Jika data berhasil dihapus tapi ada error parsing response, reload halaman
                if (error.message.includes('JSON')) {
                    alert('Data dosis berhasil dihapus');
                    location.reload();
                } else {
                    alert('Terjadi kesalahan saat menghapus data: ' + error.message);
                }
            });
        }
    }
</script>
@endpush

@endsection 