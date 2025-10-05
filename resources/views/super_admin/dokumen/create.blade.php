@extends('layouts.super_admin')

@section('content')
<!-- Breadcrumb Section -->


<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark-blue text-white">
            <h5 class="mb-0">Tambah Dokumen Baru</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('super_admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="judul_dokumen" class="form-label">Judul Dokumen</label>
                    <input type="text" class="form-control @error('judul_dokumen') is-invalid @enderror" id="judul_dokumen" name="judul_dokumen" value="{{ old('judul_dokumen') }}" required>
                    @error('judul_dokumen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="topik" class="form-label">Topik</label>
                    <input type="text" class="form-control @error('topik') is-invalid @enderror" id="topik" name="topik" value="{{ old('topik') }}">
                    @error('topik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="document_category_id" class="form-label">Kategori</label>
                    <div class="input-group flex-wrap">
                        <select class="form-select @error('document_category_id') is-invalid @enderror" id="document_category_id" name="document_category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('document_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <i class="fas fa-plus"></i>
                            <span class="d-none d-sm-inline ms-1">Tambah Kategori</span>
                        </button>
                    </div>
                    @error('document_category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">File Dokumen</label>
                    <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-dark-blue">
                        <i class="fas fa-save me-1"></i> Simpan Dokumen
                    </button>
                    <a href="{{ route('super_admin.documents.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark-blue text-white">
                <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm">
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="category_name" name="name" required>
                        <div class="invalid-feedback" id="category_name_error"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-dark-blue" id="saveCategoryBtn">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    Simpan Kategori
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const saveCategoryBtn = $('#saveCategoryBtn');
    const categorySelect = $('#document_category_id');
    const categoryNameInput = $('#category_name');
    const categoryNameError = $('#category_name_error');

    saveCategoryBtn.on('click', function() {
        const categoryName = categoryNameInput.val().trim();
        
        if (!categoryName) {
            categoryNameInput.addClass('is-invalid');
            categoryNameError.text('Nama kategori wajib diisi.');
            return;
        }

        // Show loading state
        saveCategoryBtn.prop('disabled', true);
        saveCategoryBtn.find('.spinner-border').removeClass('d-none');
        saveCategoryBtn.text('Menyimpan...');

        // Send AJAX request
        $.ajax({
            url: '{{ route("super_admin.document_categories.store") }}',
            method: 'POST',
            data: JSON.stringify({
                name: categoryName
            }),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function(data) {
                console.log('Success response:', data);
                
                if (data.success) {
                    // Add new category to select
                    const option = $('<option>', {
                        value: data.category.id,
                        text: data.category.name
                    });
                    categorySelect.append(option);
                    
                    // Select the new category
                    categorySelect.val(data.category.id);
                    
                    // Close modal
                    $('#addCategoryModal').modal('hide');
                    
                    // Reset form
                    categoryNameInput.val('');
                    categoryNameInput.removeClass('is-invalid');
                    categoryNameError.text('');
                    
                    // Show success message
                    showAlert('Kategori berhasil ditambahkan!', 'success');
                } else {
                    // Show error message
                    categoryNameInput.addClass('is-invalid');
                    categoryNameError.text(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                categoryNameInput.addClass('is-invalid');
                categoryNameError.text('Terjadi kesalahan sistem. Silakan coba lagi.');
            },
            complete: function() {
                // Reset button state
                saveCategoryBtn.prop('disabled', false);
                saveCategoryBtn.find('.spinner-border').addClass('d-none');
                saveCategoryBtn.text('Simpan Kategori');
            }
        });
    });

    // Reset form when modal is closed
    $('#addCategoryModal').on('hidden.bs.modal', function() {
        categoryNameInput.val('');
        categoryNameInput.removeClass('is-invalid');
        categoryNameError.text('');
        saveCategoryBtn.prop('disabled', false);
        saveCategoryBtn.find('.spinner-border').addClass('d-none');
        saveCategoryBtn.text('Simpan Kategori');
    });

    // Remove invalid class when user starts typing
    categoryNameInput.on('input', function() {
        if ($(this).val().trim()) {
            $(this).removeClass('is-invalid');
            categoryNameError.text('');
        }
    });

    // Function to show alert
    function showAlert(message, type) {
        const alertDiv = $('<div>', {
            class: `alert alert-${type} alert-dismissible fade show`,
            html: `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `
        });
        
        $('.container-fluid').prepend(alertDiv);
        
        // Auto remove after 5 seconds
        setTimeout(function() {
            alertDiv.remove();
        }, 5000);
    }
});
</script>
@endpush
