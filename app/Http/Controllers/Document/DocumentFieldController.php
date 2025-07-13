<?php

namespace App\Http\Controllers\Document;

use App\Models\FormField;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\DocumentFieldRequest;

class DocumentFieldController extends Controller
{
    public function importTemplate(Request $request, DocumentType $document_type)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'template_file' => 'required|mimes:doc,docx',
        ]);

        if ($validator->fails()) {
            return redirect()->route('document.field.index', $document_type->id)->with('error', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();
            if ($document_type->template_file_path) {
                if (Storage::disk('public')->exists($document_type->template_file_path)) {
                    Storage::disk('public')->delete($document_type->template_file_path);
                }
            }
            $document_type->template_file_path = $request->file('template_file')->store('template', 'public');
            $document_type->save();
            DB::commit();

            return redirect()->route('document.field.index', $document_type->id)->with('success', 'Template berhasil diunggah.');

        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error($th);
            return redirect()->route('document.field.index', $document_type->id)->with('error', 'Gagal mengunggah template: Terjadi kesalahan pada sistem.');
        }
    }

    public function show(FormField $form_field): JsonResponse
    {
        if (!empty($form_field)) {
            return response()->json([
                'status'  => true,
                'data'    => $form_field,
                'message' => 'Data berhasil diambil.',
            ], JsonResponse::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'Data Tidak Ada.',
                'data'    => [],
                'status' => false,
            ]);
        }
    }

    public function store(DocumentFieldRequest $request, DocumentType $document_type)
    {
        return $this->createData(model: new FormField(), request: $request, route: "document.field.index", routeParameter: $document_type->id,
            beforeSubmit: function ($model, $request, &$validatedData) use ($document_type) {
                $validatedData['document_type_id'] = $document_type->id;
            }
        );
    }

    public function update(DocumentFieldRequest $request, DocumentType $document_type, FormField $form_field)
    {
        return $this->updateData(model: new FormField(), id: $form_field->id, request: $request, route: "document.field.index", routeParameter: $document_type->id);
    }

    public function destroy(DocumentType $document_type, FormField $form_field)
    {
        return $this->deleteData(model: new FormField(), id: $form_field->id, route: "document.field.index", routeParameter: $document_type->id);
    }

}
