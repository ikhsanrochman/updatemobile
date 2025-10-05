@forelse($projects as $project)
<tr>
    <td class="text-center">{{ $loop->iteration }}</td>
    <td>{{ $project->nama_proyek }}</td>
    <td>{{ $project->keterangan }}</td>
    <td>{{ $project->tanggal_mulai->format('d/m/Y') }}</td>
    <td>{{ $project->tanggal_selesai->format('d/m/Y') }}</td>
    <td class="text-center">
        <a href="{{ route('super_admin.perizinan.detail', $project->id) }}" class="btn btn-info btn-sm">
            <i class="fas fa-eye me-1"></i>Detail
        </a>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">Tidak ada data proyek</td>
</tr>
@endforelse 