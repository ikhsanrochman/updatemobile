<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentCategoryController extends Controller
{
    public function store(Request $request)
    {
        try {
            \Log::info('DocumentCategory store method called', ['request' => $request->all()]);
            
            // Validasi input
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:document_categories,name',
            ], [
                'name.required' => 'Nama kategori wajib diisi.',
                'name.string' => 'Nama kategori harus berupa teks.',
                'name.max' => 'Nama kategori maksimal 255 karakter.',
                'name.unique' => 'Nama kategori sudah ada. Silakan gunakan nama yang berbeda.',
            ]);

            if ($validator->fails()) {
                \Log::warning('DocumentCategory validation failed', ['errors' => $validator->errors()]);
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }

            // Buat kategori baru
            $category = DocumentCategory::create([
                'name' => $request->name,
            ]);

            \Log::info('DocumentCategory created successfully', ['category' => $category]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan.',
                'category' => $category
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error creating document category: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
