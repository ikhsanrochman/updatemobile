<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center" style="width: 50px;">No</th>
                <th scope="col">Nama Proyek</th>
                <th scope="col" class="d-none d-md-table-cell">Keterangan</th>
                <th scope="col" class="d-none d-md-table-cell">Tanggal Mulai</th>
                <th scope="col" class="d-none d-md-table-cell">Tanggal Selesai</th>
                <th scope="col" class="text-center" style="width: 120px;">Aksi</th>
            </tr>
        </thead>
        <tbody id="projectTableBody">
            @forelse($projects as $project)
            <tr>
                <td class="text-center">{{ $loop->iteration + ($projects->firstItem() - 1) }}</td>
                <td>
                    <div>{{ $project->nama_proyek }}</div>
                    <div class="small text-muted d-md-none">
                        {{ $project->tanggal_mulai->format('d/m/Y') }} - {{ $project->tanggal_selesai->format('d/m/Y') }}
                    </div>
                    <div class="small text-muted d-md-none">
                        {{ Str::limit($project->keterangan, 50) }}
                    </div>
                </td>
                <td class="d-none d-md-table-cell">{{ $project->keterangan }}</td>
                <td class="d-none d-md-table-cell">{{ $project->tanggal_mulai->format('d/m/Y') }}</td>
                <td class="d-none d-md-table-cell">{{ $project->tanggal_selesai->format('d/m/Y') }}</td>
                <td class="text-center">
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('super_admin.projects.edit', $project->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger delete-project" data-id="{{ $project->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-3">Tidak ada data proyek</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mt-4">
    <div class="small text-muted">
        Menampilkan {{ $projects->firstItem() ?? 0 }} sampai {{ $projects->lastItem() ?? 0 }} dari {{ $projects->total() }} data
    </div>
    <nav aria-label="Page navigation" class="ms-md-auto">
        {{ $projects->appends(request()->except('page'))->links() }}
    </nav>
</div>
<div class="d-flex justify-content-between align-items-center mt-4">
    <div>
        <span class="text-muted">Menampilkan {{ $projects->firstItem() ?? 0 }} sampai {{ $projects->lastItem() ?? 0 }} dari {{ $projects->total() }} data</span>
    </div>
    <nav aria-label="Page navigation">
        {{ $projects->appends(request()->except('page'))->links() }}
    </nav>
</div>
