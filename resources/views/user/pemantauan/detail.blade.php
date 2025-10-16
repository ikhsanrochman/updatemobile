@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Detail Pemantauan - {{ $project->nama_proyek }}</h3>
        <a href="{{ route('user.pemantauan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold mb-0">Dosis TLD</h5>
                        <a href="{{ route('user.pemantauan.tld.create', $project->id) }}" class="btn btn-primary btn-sm">Tambah</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th class="text-end">Dosis</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tlds as $row)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($row->tanggal_pemantauan)->format('Y-m-d') }}</td>
                                        <td class="text-end">{{ number_format($row->dosis, 2) }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('user.pemantauan.tld.edit', [$project->id, $row->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('user.pemantauan.tld.destroy', [$project->id, $row->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold mb-0">Dosis Pendose</h5>
                        <a href="{{ route('user.pemantauan.pendos.create', $project->id) }}" class="btn btn-primary btn-sm">Tambah</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th class="text-end">Dosis</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendoses as $row)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($row->tanggal_pengukuran)->format('Y-m-d') }}</td>
                                        <td class="text-end">{{ number_format($row->hasil_pengukuran, 2) }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('user.pemantauan.pendos.edit', [$project->id, $row->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('user.pemantauan.pendos.destroy', [$project->id, $row->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


