<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('documentCategory')->latest()->paginate(10);
        $categories = DocumentCategory::all();
        
        return view('admin.dokumen.index', compact('documents', 'categories'));
    }

    public function create()
    {
        $categories = DocumentCategory::all();
        return view('admin.dokumen.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_dokumen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'document_category_id' => 'required|exists:document_categories,id',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $fileName, 'public');

        Document::create([
            'judul_dokumen' => $request->judul_dokumen,
            'deskripsi' => $request->deskripsi,
            'document_category_id' => $request->document_category_id,
            'file_path' => $filePath,
            'topik' => $request->topik ?? $request->judul_dokumen, // Use topik if provided, otherwise use judul_dokumen
        ]);

        return redirect()->route('admin.dokumen.index')
            ->with('success', 'Dokumen berhasil ditambahkan!');
    }

    public function show(Document $document)
    {
        return view('admin.dokumen.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $categories = DocumentCategory::all();
        return view('admin.dokumen.edit', compact('document', 'categories'));
    }

    public function update(Request $request, Document $document)
    {
        $validator = Validator::make($request->all(), [
            'judul_dokumen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'document_category_id' => 'required|exists:document_categories,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'judul_dokumen' => $request->judul_dokumen,
            'deskripsi' => $request->deskripsi,
            'document_category_id' => $request->document_category_id,
            'topik' => $request->topik ?? $request->judul_dokumen, // Use topik if provided, otherwise use judul_dokumen
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            $data['file_path'] = $filePath;
        }

        $document->update($data);

        return redirect()->route('admin.dokumen.index')
            ->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy(Document $document)
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil dihapus!');
    }

    public function download(Document $document)
    {
        if (!Storage::disk('public')->exists($document->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        return Storage::disk('public')->download($document->file_path, basename($document->file_path));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $documents = \App\Models\Document::with('documentCategory')
            ->when($query, function($qB) use ($query) {
                $qB->where('judul_dokumen', 'like', "%$query%")
                    ->orWhere('topik', 'like', "%$query%")
                    ->orWhere('deskripsi', 'like', "%$query%")
                    ;
            })
            ->latest()
            ->paginate(10);

        $view = view('admin.dokumen.table', compact('documents'))->render();
        return response()->json(['html' => $view]);
    }
} 