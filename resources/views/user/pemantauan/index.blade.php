@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-3">Pemantauan Dosis - Proyek Saya</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Proyek</th>
                            <th>Keterangan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td>{{ $project->nama_proyek }}</td>
                                <td>{{ $project->keterangan }}</td>
                                <td>{{ optional($project->tanggal_mulai)->format('Y-m-d') }}</td>
                                <td>{{ optional($project->tanggal_selesai)->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('user.pemantauan.detail', $project->id) }}" class="btn btn-primary btn-sm">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada proyek terkait.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


