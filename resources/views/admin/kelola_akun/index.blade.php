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

<!-- Header -->
<div class="mb-2">
    <h2 class="fw-bold">Kelola Akun</h2>
    <div class="text-muted" style="font-size: 15px;">Kelola dan telusuri akun pengguna disini</div>
</div>

<!-- Alert Messages -->
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

<!-- Filter dan Tambah Akun -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center">
        <label for="search" class="me-2 mb-0">Apply filter</label>
        <input type="text" id="search" class="form-control me-2" placeholder="Search by name or username" style="width: 250px;">
    </div>
    <a href="{{ route('admin.kelola_akun.create') }}" class="btn btn-dark px-4 py-2 d-flex align-items-center" style="border-radius: 18px;">
        <span class="me-2">+</span> Tambah Akun
    </a>
</div>

<!-- Tabel Daftar User -->
<div class="table-responsive">
    <table class="table table-bordered align-middle" style="min-width: 900px;">
        <thead class="bg-dark-blue text-white">
            <tr>
                <th style="width: 40px;">No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Role</th>
                <th>Bidang</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
            <tr style="background: {{ $index % 2 == 0 ? '#e5e7eb' : 'white' }}">
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->role->name }}</td>
                <td>
                    @if($user->jenisPekerja->isNotEmpty())
                        {{ $user->jenisPekerja->pluck('nama')->join(', ') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.kelola_akun.edit', $user->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-warning btn-sm" onclick="toggleUserStatus({{ $user->id }})">
                            <i class="fas fa-power-off"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data pengguna</td>
            </tr>
            @endforelse
        </tbody>
    </table>
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

    .badge.bg-success { 
        background-color: #38b000 !important; 
    }
    
    .badge.bg-secondary { 
        background-color: #a0a0a0 !important; 
    }
    
    .btn-danger { 
        background-color: #e63946 !important; 
        border: none; 
    }
    
    .btn-dark { 
        background-color: #0a2647 !important; 
        border: none; 
    }
    
    .btn-warning { 
        background-color: #ffc107 !important; 
        border: none; 
    }
    
    .table th, .table td { 
        vertical-align: middle; 
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

    .badge {
        font-size: 0.75rem;
    }
</style>

@push('scripts')
<script>
function toggleUserStatus(userId) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Status pengguna ini akan diubah!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#38b000',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Ubah!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/kelola-akun/toggle-status/${userId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Berhasil!', 'Status pengguna berhasil diubah.', 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat mengubah status pengguna.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Gagal!', 'Terjadi kesalahan saat mengubah status pengguna.', 'error');
            });
        }
    });
}

function deleteUser(userId) {
    if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
        // Implement delete functionality
        alert('Fitur hapus pengguna belum diimplementasikan.');
    }
}

$(document).ready(function() {
    // Search functionality
    $('#search').on('keyup', function() {
        const searchValue = $(this).val().toLowerCase();
        let found = false;
        const userTableBody = $('table tbody');

        userTableBody.find('tr').each(function() {
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
        const noResultsRow = userTableBody.find('.no-results');
        if (!found && searchValue !== "") {
            if (noResultsRow.length === 0) {
                userTableBody.append('<tr class="no-results"><td colspan="7" class="text-center">Tidak ada data yang cocok.</td></tr>');
            }
        } else {
            noResultsRow.remove();
        }
    });
});
</script>
@endpush

@endsection
