@forelse($projects as $project)
<tr>
    <td class="text-center">{{ $loop->iteration }}</td>
    <td>{{ $project->nama_proyek }}</td>
    <td>{{ $project->keterangan }}</td>
    <td>{{ $project->tanggal_mulai->format('d/m/Y') }}</td>
    <td>{{ $project->tanggal_selesai->format('d/m/Y') }}</td>    <td class="text-center">
        <div class="btn-group" role="group">
            @if (Request::routeIs('admin.tld.search'))
                <a href="{{ route('admin.tld.detail', $project->id) }}" class="btn btn-primary btn-sm me-2">
                    <i class="fas fa-radiation me-1"></i> TLD
                </a>
            @endif
            @if (Request::routeIs('admin.pendos.search'))
                <a href="{{ route('admin.pendos.detail', $project->id) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-radiation-alt me-1"></i> Pendos
                </a>
            @endif
            
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">Tidak ada data proyek</td>
</tr>
@endforelse 