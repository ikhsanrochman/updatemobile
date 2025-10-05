@forelse($projects as $project)
<tr>
    <td class="text-center">{{ $loop->iteration }}</td>
    <td>{{ $project->nama_proyek }}</td>
    <td>{{ $project->keterangan }}</td>
    <td>{{ $project->tanggal_mulai->format('d/m/Y') }}</td>
    <td>{{ $project->tanggal_selesai->format('d/m/Y') }}</td>
    
    <td class="text-center">
        <button class="btn btn-danger btn-sm me-1 delete-project" data-id="{{ $project->id }}">Hapus</button>
        <a href="{{ route('super_admin.projects.edit', $project->id) }}" class="btn btn-primary btn-sm">Edit</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">Tidak ada data proyek</td>
</tr>
@endforelse 