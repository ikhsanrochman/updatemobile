@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Input Dosis Pendose</h3>
        <a href="{{ route('user.pemantauan.detail', $project->id) }}" class="btn btn-secondary">Kembali</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('user.pemantauan.pendos.store', $project->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Tanggal Pengukuran</label>
                    <input type="date" name="tanggal_pemantauan" class="form-control" value="{{ old('tanggal_pemantauan') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dosis (mSv)</label>
                    <input type="number" step="0.01" min="0" name="dosis" class="form-control" value="{{ old('dosis') }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection


