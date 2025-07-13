<?php

namespace App\Http\Controllers\Document;

use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentTypeRequest;

class DocumentTypeController extends Controller
{
    public function index()
    {
        $document_types = DocumentType::all();

        return view('back-end.document.type.index', compact('document_types'));
    }

    public function indexFields(DocumentType $document_type)
    {
        return view('back-end.document.type.fields', compact('document_type'));
    }

    public function show(DocumentType $document_type): JsonResponse
    {
        if (!empty($document_type)) {
            return response()->json([
                'status'  => true,
                'data'    => $document_type,
                'message' => 'Data berhasil diambil.',
            ], JsonResponse::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'Data Tidak Ada.',
                'data'    => [],
                'status' => false,
            ], JsonResponse::HTTP_NOT_FOUND);
        }
    }

    public function store(DocumentTypeRequest $request)
    {
        return $this->createData(model: new DocumentType(), request: $request, route: 'document.type.index');
    }

    public function update(DocumentTypeRequest $request, $id)
    {
        // dd($request);
        return $this->updateData(model: new DocumentType(), id: $id, request: $request, route: 'document.type.index');
    }

    public function destroy($id)
    {
        return $this->deleteData(model: new DocumentType(), id: $id, route: 'document.type.index');
    }
}
