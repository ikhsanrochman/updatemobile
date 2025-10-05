@forelse($projects as $project)
<tr>
    <td class="text-center">{{ $loop->iteration }}</td>
    <td>{{ $project->nama_proyek }}</td>
    <td>{{ $project->keterangan }}</td>
    <td>{{ $project->tanggal_mulai->format('d/m/Y') }}</td>
    <td>{{ $project->tanggal_selesai->format('d/m/Y') }}</td>
    <td class="text-center">
        <a href="{{ route('super_admin.sdm.detail', $project->id) }}" class="btn btn-info btn-sm">Detail</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">Tidak ada data proyek</td>
</tr>
@endforelse