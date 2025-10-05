@extends('layouts.super_admin')

@section('content')


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

    <!-- Data Detail Pendos Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">Data Detail Pemantauan Pendos</h6>
                <a href="{{ route('super_admin.pendos.detail', $project->id) }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

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

    .table-dark th {
        background-color: #1e3a5f;
        border-color: #1e3a5f;
        font-weight: normal;
        font-size: 0.875rem;
    }
    
    .table td {
        font-size: 0.875rem;
        vertical-align: middle;
        min-width: 50px;
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

        const dosisData = JSON.parse('{!! json_encode($dosisPendos) !!}');
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
        window.location.href = `{{ route('super_admin.pemantauan.pendos.edit', ['projectId' => ':projectId', 'userId' => ':userId', 'dosisId' => ':dosisId']) }}`
            .replace(':projectId', projectId)
            .replace(':userId', userId)
            .replace(':dosisId', id);
    }

    function deleteDosis(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            const projectId = {{ $project->id }};
            const userId = {{ $user->id }};
            fetch(`{{ route('super_admin.pemantauan.pendos.destroy', ['projectId' => ':projectId', 'userId' => ':userId', 'dosisId' => ':dosisId']) }}`
                .replace(':projectId', projectId)
                .replace(':userId', userId)
                .replace(':dosisId', id), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.headers.get('content-type')?.includes('application/json')) {
                    return response.json();
                } else {
                    throw new Error('Bukan response JSON');
                }
            })
            .then(data => {
                if (data.success) {
                    alert('Data dosis berhasil dihapus');
                    location.reload(); // Reload page to update table
                } else {
                    alert('Terjadi kesalahan: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus data.');
            });
        }
    }
</script>
@endpush

@endsection
