@extends('layouts.admin')

@section('content')
<!-- Breadcrumb Section -->


<div style="margin-top: 50px;"></div>

<div class="container-fluid">
    <!-- Header and Add Button Row -->
    <div class="d-flex align-items-center mb-4 justify-content-between">
        <h2 class="fw-bold mb-0">Dokumen Instansi</h2>
        <a href="{{ route('admin.dokumen.create') }}" class="btn btn-dark-blue">
            <i class="fas fa-plus me-2"></i>Tambah Data
        </a>
    </div>
    <p class="text-muted mb-4">Menampilkan dokumen yang dapat diakses oleh pengguna aplikasi melalui halaman ini</p>

    <!-- Petunjuk Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body bg-light rounded-3 py-3">
            <h6 class="fw-bold text-dark-blue mb-2"><i class="fas fa-exclamation-circle me-2"></i>PETUNJUK !</h6>
            <ul class="list-unstyled mb-0 ms-4">
                <li>Gunakan kolom pencarian di atas tabel untuk mencari daftar dokumen</li>
                <li>Gunakan tombol detail untuk mengakses informasi mengenai data dokumen</li>
                <li>Klik tombol download untuk mengunduh file dokumen</li>
            </ul>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center">
            <span class="me-2">Menampilkan</span>
            <select class="form-select form-select-sm me-2" style="width: auto;">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            <span>data per halaman</span>
        </div>
        <div class="d-flex align-items-center">
            <span class="me-2">Apply filter</span>
            <div class="input-group input-group-sm" style="width: 200px;">
                <input type="text" class="form-control" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-secondary" type="button"></button>
            </div>
        </div>
    </div>

    <!-- Documents Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="documentsTable">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 py-3 px-4">ID</th>
                            <th class="border-0 py-3 px-4">Judul Dokumen</th>
                            <th class="border-0 py-3 px-4">Topik</th>
                            <th class="border-0 py-3 px-4">File</th>
                            <th class="border-0 py-3 px-4">Deskripsi</th>
                            <th class="border-0 py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($documents as $document)
                        <tr>
                            <td class="px-4">{{ $document->id }}</td>
                            <td>{{ $document->judul_dokumen }}</td>
                            <td>{{ $document->topik }}</td>
                            <td>
                                @if ($document->file_path && Storage::disk('public')->exists($document->file_path))
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file me-2 text-primary"></i>
                                        <a href="{{ route('admin.dokumen.download', $document->id) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Download {{ basename($document->file_path) }}">
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                        <small class="text-muted ms-2">{{ Str::limit(basename($document->file_path), 20) }}</small>
                                    </div>
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-exclamation-triangle me-1"></i>File tidak tersedia
                                        @if($document->file_path)
                                            <br><small>Path: {{ $document->file_path }}</small>
                                        @endif
                                    </span>
                                @endif
                            </td>
                            <td>{{ Str::limit($document->deskripsi, 50) }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.dokumen.show', $document->id) }}" class="btn btn-info btn-sm me-2">Detail</a>
                                    <a href="{{ route('admin.dokumen.edit', $document->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                                    <form action="{{ route('admin.dokumen.destroy', $document->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No documents found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination at bottom -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <small class="text-muted">Menampilkan {{ $documents->firstItem() }} sampai {{ $documents->lastItem() }} dari {{ $documents->total() }} dokumen</small>
        <nav aria-label="Page navigation">
            {{ $documents->links('pagination::bootstrap-5') }}
        </nav>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar');
        const breadcrumbContainer = document.getElementById('breadcrumb-container');
        
        // Sidebar responsive behavior
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

        // Search functionality (simple client-side for demonstration)
        const searchInput = document.querySelector('div.input-group-sm input[type="text"]');
        const table = document.getElementById('documentsTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                // Adjust to search relevant columns only
                const documentName = row.cells[1].textContent.toLowerCase(); 
                const topic = row.cells[2].textContent.toLowerCase();
                const file = row.cells[3].textContent.toLowerCase();
                const description = row.cells[4].textContent.toLowerCase();
                
                if (documentName.includes(searchTerm) || topic.includes(searchTerm) || file.includes(searchTerm) || description.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });

        // Pagination buttons (client-side placeholder)
        const prevButton = document.querySelector('.pagination .page-item:first-child a');
        const nextButton = document.querySelector('.pagination .page-item:last-child a');
        const currentPageSpan = document.querySelector('.pagination .page-item.active a');

        let currentPage = parseInt(currentPageSpan.textContent);
        const totalPages = 1; // Placeholder, replace with actual logic

        function updatePaginationButtons() {
            prevButton.parentNode.classList.toggle('disabled', currentPage === 1);
            nextButton.parentNode.classList.toggle('disabled', currentPage === totalPages);
        }

        prevButton.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                currentPageSpan.textContent = currentPage;
                // In a real application, you would load data for the new page
                updatePaginationButtons();
            }
        });

        nextButton.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                currentPageSpan.textContent = currentPage;
                // In a real application, you would load data for the new page
                updatePaginationButtons();
            }
        });

        updatePaginationButtons(); // Initial state
    });
</script>
@endpush
@endsection
