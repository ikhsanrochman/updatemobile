@extends('layouts.admin')

@section('content')
<!-- Breadcrumb Section -->


<div style="margin-top: 50px;"></div>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Tambah Pekerja Radiasi</h2>
        <a href="{{ route('admin.sdm.detail', $project->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-secondary text-white py-3">
            <h5 class="fw-bold mb-0"><i class="fas fa-user-plus me-2"></i>Form Tambah Pekerja Radiasi</h5>
        </div>
        <div class="card-body">
            <form id="addWorkerForm" action="{{ route('admin.sdm.store', $project->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_search" class="form-label">Nama</label>
                            <div class="dropdown-search-container position-relative">
                                <input type="text" 
                                       class="form-control" 
                                       id="user_search" 
                                       placeholder="Ketik nama pekerja..." 
                                       autocomplete="off"
                                       required>
                                <input type="hidden" id="user_id" name="user_id" required>
                                <div id="dropdown_list" class="dropdown-list position-absolute w-100 bg-white border rounded shadow-sm" style="display: none; max-height: 200px; overflow-y: auto; z-index: 1000;">
                                    @foreach($availableUsers as $user)
                                        <div class="dropdown-item p-2 border-bottom cursor-pointer" 
                                             data-id="{{ $user->id }}"
                                             data-name="{{ $user->nama }}"
                                             data-jenis-pekerja="{{ $user->jenisPekerja->pluck('nama')->join(', ') }}"
                                             data-no-sib="{{ $user->no_sib }}"
                                             data-berlaku="{{ $user->berlaku }}"
                                             data-keahlian="{{ $user->keahlian }}">
                                            <strong>{{ $user->nama }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $user->jenisPekerja->pluck('nama')->join(', ') }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jenis_pekerja" class="form-label">Jenis Pekerja</label>
                            <input type="text" class="form-control" id="jenis_pekerja" name="jenis_pekerja" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_sib" class="form-label">No. SIB</label>
                            <input type="text" class="form-control" id="no_sib" name="no_sib" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="berlaku" class="form-label">Berlaku Sampai</label>
                            <input type="date" class="form-control" id="berlaku" name="berlaku" disabled>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="keahlian" class="form-label">Keahlian</label>
                    <textarea class="form-control" id="keahlian" name="keahlian" rows="3" disabled></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
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

    .dropdown-search-container {
        position: relative;
    }

    .dropdown-list {
        border-top: none !important;
        border-top-left-radius: 0 !important;
        border-top-right-radius: 0 !important;
    }

    .dropdown-item {
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa !important;
    }

    .dropdown-item:last-child {
        border-bottom: none !important;
    }

    .dropdown-item.active {
        background-color: #e9ecef !important;
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userSearch = document.getElementById('user_search');
    const userIdInput = document.getElementById('user_id');
    const dropdownList = document.getElementById('dropdown_list');
    const dropdownItems = dropdownList.querySelectorAll('.dropdown-item');
    
    let selectedIndex = -1;

    // Function to filter dropdown items
    function filterDropdown(searchText) {
        let visibleItems = [];
        dropdownItems.forEach(item => {
            const name = item.dataset.name.toLowerCase();
            const jenisPekerja = item.dataset.jenisPekerja.toLowerCase();
            
            if (name.includes(searchText.toLowerCase()) || jenisPekerja.includes(searchText.toLowerCase())) {
                item.style.display = 'block';
                visibleItems.push(item);
            } else {
                item.style.display = 'none';
            }
        });
        
        selectedIndex = -1;
        updateSelection(visibleItems);
        return visibleItems;
    }

    // Function to update selection highlight
    function updateSelection(visibleItems) {
        visibleItems.forEach((item, index) => {
            if (index === selectedIndex) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    // Function to select item
    function selectItem(item) {
        userSearch.value = item.dataset.name;
        userIdInput.value = item.dataset.id;
        dropdownList.style.display = 'none';
        
        // Fill other fields
        document.getElementById('jenis_pekerja').value = item.dataset.jenisPekerja || '';
        document.getElementById('no_sib').value = item.dataset.noSib || '';
        document.getElementById('berlaku').value = item.dataset.berlaku || '';
        document.getElementById('keahlian').value = item.dataset.keahlian || '';
        
        selectedIndex = -1;
    }

    // Function to clear fields
    function clearFields() {
        userIdInput.value = '';
        document.getElementById('jenis_pekerja').value = '';
        document.getElementById('no_sib').value = '';
        document.getElementById('berlaku').value = '';
        document.getElementById('keahlian').value = '';
    }

    // Event listeners
    userSearch.addEventListener('input', function() {
        const searchText = this.value.trim();
        
        if (searchText.length > 0) {
            const visibleItems = filterDropdown(searchText);
            dropdownList.style.display = visibleItems.length > 0 ? 'block' : 'none';
            
            // Clear user_id if text doesn't match exactly
            const exactMatch = Array.from(dropdownItems).find(item => 
                item.dataset.name.toLowerCase() === searchText.toLowerCase()
            );
            if (!exactMatch) {
                clearFields();
            }
        } else {
            dropdownList.style.display = 'none';
            clearFields();
        }
    });

    userSearch.addEventListener('focus', function() {
        if (this.value.trim().length > 0) {
            filterDropdown(this.value.trim());
            dropdownList.style.display = 'block';
        }
    });

    userSearch.addEventListener('keydown', function(e) {
        const visibleItems = Array.from(dropdownItems).filter(item => item.style.display !== 'none');
        
        if (dropdownList.style.display === 'block' && visibleItems.length > 0) {
            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    selectedIndex = Math.min(selectedIndex + 1, visibleItems.length - 1);
                    updateSelection(visibleItems);
                    break;
                    
                case 'ArrowUp':
                    e.preventDefault();
                    selectedIndex = Math.max(selectedIndex - 1, -1);
                    updateSelection(visibleItems);
                    break;
                    
                case 'Enter':
                    e.preventDefault();
                    if (selectedIndex >= 0 && selectedIndex < visibleItems.length) {
                        selectItem(visibleItems[selectedIndex]);
                    }
                    break;
                    
                case 'Escape':
                    dropdownList.style.display = 'none';
                    selectedIndex = -1;
                    break;
            }
        }
    });

    // Click events for dropdown items
    dropdownItems.forEach(item => {
        item.addEventListener('click', function() {
            selectItem(this);
        });
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!userSearch.contains(e.target) && !dropdownList.contains(e.target)) {
            dropdownList.style.display = 'none';
            selectedIndex = -1;
        }
    });

    // Handle form submission
    document.getElementById('addWorkerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data pekerja berhasil ditambahkan',
                    icon: 'success'
                }).then(() => {
                    window.location.href = "{{ route('admin.sdm.detail', $project->id) }}";
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat menambahkan data',
                icon: 'error'
            });
        });
    });

    const sidebar = document.querySelector('.sidebar');
    const breadcrumbContainer = document.getElementById('breadcrumb-container');
    
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                const isSidebarCollapsed = sidebar.classList.contains('collapsed');
                breadcrumbContainer.style.left = isSidebarCollapsed ? '20px' : '280px';
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