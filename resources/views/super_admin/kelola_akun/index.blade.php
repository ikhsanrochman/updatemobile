@extends('layouts.super_admin')

@section('content')
<!-- Breadcrumb Section -->


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
        <label for="search" class="me-2 mb-0">Cari</label>
        <input type="text" id="search" class="form-control me-2" placeholder="Cari nama, username, role, atau bidang" style="width: 250px;">
    </div>
    <a href="{{ route('super_admin.kelola_akun.create') }}" class="btn btn-dark px-4 py-2 d-flex align-items-center" style="border-radius: 18px;">
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
                <td>{{ $users->firstItem() + $index }}</td>
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
                        <a href="{{ route('super_admin.kelola_akun.edit', $user->id) }}" class="btn btn-primary btn-sm">
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

<!-- Pagination -->
<div class="d-flex justify-content-end mt-3">
    {{ $users->links() }}
</div>

<style>
    .container-fluid {
        overflow-x: auto;
        max-width: 100vw;
        padding-left: 15px;
        padding-right: 15px;
    }
    
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
        padding: 12px 0;
    }

    /* Responsive styles */
    @media (max-width: 576px) {
        .breadcrumb-item {
            font-size: 14px;
        }
        .page-breadcrumb {
            padding: 8px 0;
        }
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }
    }

    @media (min-width: 577px) and (max-width: 768px) {
        .breadcrumb-item {
            font-size: 15px;
        }
        .page-breadcrumb {
            padding: 10px 0;
        }
    }

    @media (min-width: 769px) {
        .breadcrumb-item {
            font-size: 16px;
        }
    }

    .bg-dark-blue { background-color: #1e3a5f !important; }
    .badge.bg-success { background-color: #38b000 !important; }
    .badge.bg-secondary { background-color: #a0a0a0 !important; }
    .btn-danger { background-color: #e63946 !important; border: none; }
    .btn-dark { background-color: #0a2647 !important; border: none; }
    .btn-warning { background-color: #ffc107 !important; border: none; }
    .table th, .table td { vertical-align: middle; }
    .breadcrumb-section {
        left: 280px;
        right: 30px;
        top: 85px;
        z-index: 999;
        transition: left 0.3s;
    }
    body.sidebar-collapsed .breadcrumb-section {
        left: 30px;
    }
</style>

@push('scripts')
<script>
// Client-side search filter (Nama, Username, Role, Bidang)
const searchInput = document.getElementById('search');
if (searchInput) {
    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr');
        rows.forEach(row => {
            const nama = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
            const username = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
            const role = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';
            const bidang = row.querySelector('td:nth-child(5)')?.textContent.toLowerCase() || '';
            if (
                nama.includes(filter) ||
                username.includes(filter) ||
                role.includes(filter) ||
                bidang.includes(filter)
            ) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}

// Client-side column search filter
const columnInputs = document.querySelectorAll('.column-search');
if (columnInputs.length) {
    columnInputs.forEach(input => {
        input.addEventListener('keyup', function() {
            const col = parseInt(this.dataset.col);
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');
            rows.forEach(row => {
                const cell = row.querySelector(`td:nth-child(${col})`);
                const text = cell ? cell.textContent.toLowerCase() : '';
                // Cek semua input kolom, semua harus match
                let visible = true;
                columnInputs.forEach(inp => {
                    const c = parseInt(inp.dataset.col);
                    const f = inp.value.toLowerCase();
                    const cell2 = row.querySelector(`td:nth-child(${c})`);
                    const t2 = cell2 ? cell2.textContent.toLowerCase() : '';
                    if (f && !t2.includes(f)) visible = false;
                });
                row.style.display = visible ? '' : 'none';
            });
        });
    });
}

function toggleUserStatus(userId) {
    if (confirm('Apakah Anda yakin ingin mengubah status pengguna ini?')) {
        fetch(`/super-admin/kelola-akun/toggle-status/${userId}`, {
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
                location.reload();
            } else {
                alert('Terjadi kesalahan saat mengubah status pengguna.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengubah status pengguna.');
        });
    }
}

function deleteUser(userId) {
    if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
        // Implement delete functionality
        alert('Fitur hapus pengguna belum diimplementasikan.');
    }
}
</script>
@endpush

@endsection

