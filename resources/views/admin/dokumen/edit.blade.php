@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold mb-0">Edit Dokumen</h2>
        <a href="{{ route('admin.dokumen.show', $document->id) }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.dokumen.update', $document->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="judul_dokumen" class="form-label">Judul Dokumen</label>
                    <input type="text" class="form-control @error('judul_dokumen') is-invalid @enderror" id="judul_dokumen" name="judul_dokumen" value="{{ old('judul_dokumen', $document->judul_dokumen) }}" required>
                    @error('judul_dokumen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="topik" class="form-label">Topik</label>
                    <input type="text" class="form-control @error('topik') is-invalid @enderror" id="topik" name="topik" value="{{ old('topik', $document->topik) }}">
                    @error('topik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="document_category_id" class="form-label">Kategori</label>
                    <select class="form-select @error('document_category_id') is-invalid @enderror" id="document_category_id" name="document_category_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('document_category_id', $document->document_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('document_category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">File Dokumen (kosongkan jika tidak ingin mengganti)</label>
                    <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
                    @if($document->file_path)
                        <small class="form-text text-muted">File saat ini: <a href="{{ route('admin.dokumen.download', $document->id) }}" target="_blank">Download</a></small>
                    @endif
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5">{{ old('deskripsi', $document->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.dokumen.show', $document->id) }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection 