<?php

namespace App\Http\Controllers\Document;

use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('documentType')
            ->when(!auth()->user()->can('document-list-all'), function ($query) {
                $query->where(function ($query) {
                    $query->where('created_by', auth()->user()->id)
                        ->orWhere('user_id', auth()->user()->id)
                        ->orWhereHas('approvals', function ($query) {
                            $query->where('user_id', auth()->user()->id);
                        });
                });
            })->latest()->get();

        $types = DocumentType::select('id', 'name')->get();

        return view('back-end.document.index', compact('documents', 'types'));
    }

    public function approve(Document $document)
    {
        $document->approval()->create([
            'user_id' => Auth::id(),
            'status' => 'approved',
            'note' => null,
            'sign' => null,
        ]);

        return back()->with('success', 'Document has been approved');
    }
}
