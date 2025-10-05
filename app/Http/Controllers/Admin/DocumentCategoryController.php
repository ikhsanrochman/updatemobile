<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentCategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:document_categories,name',
        ]);

        $category = \App\Models\DocumentCategory::create([
            'name' => $validated['name'],
        ]);

        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }
} 