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
<div class="d-flex justify-content-between align-items-center mt-3">
    <small class="text-muted">Menampilkan {{ $documents->firstItem() }} sampai {{ $documents->lastItem() }} dari {{ $documents->total() }} dokumen</small>
    <nav aria-label="Page navigation">
        {{ $documents->links('pagination::bootstrap-5') }}
    </nav>
</div> 