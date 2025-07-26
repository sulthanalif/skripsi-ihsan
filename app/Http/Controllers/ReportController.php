<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {

        $documents = Document::query()
            ->with('documentType')
            ->latest()->get();

        $types = DocumentType::select('id', 'name')->get();

        return view('back-end.report.index', compact('documents', 'types'));
    }
}
