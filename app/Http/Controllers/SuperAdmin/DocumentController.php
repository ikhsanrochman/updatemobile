<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::with('documentCategory')->paginate(10);
        return view('super_admin.dokumen.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = DocumentCategory::all();
        return view('super_admin.dokumen.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_dokumen' => 'required|string|max:255',
            'topik' => 'nullable|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,xlsx,jpg,jpeg,png|max:10240',
            'deskripsi' => 'nullable|string',
            'document_category_id' => 'required|exists:document_categories,id',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
        }

        Document::create([
            'judul_dokumen' => $request->judul_dokumen,
            'topik' => $request->topik,
            'file_path' => $filePath,
            'deskripsi' => $request->deskripsi,
            'document_category_id' => $request->document_category_id,
        ]);

        return redirect()->route('super_admin.documents.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return view('super_admin.dokumen.detail', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        $categories = DocumentCategory::all();
        return view('super_admin.dokumen.edit', compact('document', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'judul_dokumen' => 'required|string|max:255',
            'topik' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xlsx,jpg,jpeg,png|max:10240',
            'deskripsi' => 'nullable|string',
            'document_category_id' => 'required|exists:document_categories,id',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            $filePath = $request->file('file')->store('documents', 'public');
        } else {
            $filePath = $document->file_path;
        }

        $document->update([
            'judul_dokumen' => $request->judul_dokumen,
            'topik' => $request->topik,
            'file_path' => $filePath,
            'deskripsi' => $request->deskripsi,
            'document_category_id' => $request->document_category_id,
        ]);

        return redirect()->route('super_admin.documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();

        return redirect()->route('super_admin.documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Download the specified document file.
     */
    public function download(Document $document)
    {
        // Check if file exists
        if (!$document->file_path || !Storage::disk('public')->exists($document->file_path)) {
            return redirect()->route('super_admin.documents.index')
                ->with('error', 'File tidak ditemukan atau telah dihapus.');
        }

        // Get file path and name
        $filePath = Storage::disk('public')->path($document->file_path);
        $fileName = basename($document->file_path);

        // Return file download response
        return response()->download($filePath, $fileName);
    }
}
