<?php

namespace App\Http\Controllers\Document; // Sesuaikan namespace

use Carbon\Carbon;
use App\Models\User;
use App\Models\Approval;
use App\Models\Document;
use App\Models\Employee;
use App\Models\Position;
use App\Models\FormField;
use Illuminate\Support\Str;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DocumentFieldValue;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // Keep Storage
use Symfony\Component\HttpFoundation\Response; // Change to base Response

class GeneratedDocumentController extends Controller
{

    public function index()
    {
        $documentTypes = DocumentType::where('status', true)->get();

        return view('back-end.document.generate.index', compact('documentTypes'));
    }

    public function create(DocumentType $documentType)
    {
        // Pastikan documentType memiliki formFields
        if ($documentType->formFields()->count() === 0) {
            return redirect()->back()->with('error', 'This document type has no fields defined.');
        }

        $users = User::where('id', '!=', 1)->get();

        return view('back-end.document.generate.create', compact('documentType', 'users'));
    }

    // public function userApprovals(User $user): \Illuminate\Http\JsonResponse
    // {
    //     if ($this->getUserApprovals($user)->isEmpty()) {
    //         return response()->json([
    //             'status' => false,
    //             'data' => [],
    //             'message' => 'No approvals found for this user.',
    //         ], \Illuminate\Http\JsonResponse::HTTP_NOT_FOUND);
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'data' => $this->getUserApprovals($user),
    //         'message' => 'Approvals retrieved successfully.',
    //     ], \Illuminate\Http\JsonResponse::HTTP_OK);
    // }

    public function edit(DocumentType $documentType, Document $document)
    {
        // Pastikan documentType memiliki formFields
        if ($documentType->formFields()->count() === 0) {
            return redirect()->back()->with('error', 'This document type has no fields defined.');
        }
        if (!auth()->user()->getRoleNames()->contains('superadmin') && !auth()->user()->getRoleNames()->contains('admin')) {
            $employees = User::with('employee')->where('id', '!=', Auth::user()->id)
                ->whereHas('employee', function ($query) {
                    $query->whereHas('subDepartment', function ($query) {
                        $query->where('department_id', Auth::user()->employee->subDepartment->department_id);
                        }
                    );
                })->get()->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'department' => $user->employee->subDepartment->department->short_name,
                        'position' => $user->employee->position->name,
                        'nik' => $user->employee->nik,
                    ];
                });

        } else {
            $employees = User::with('employee')->where('id', '!=', Auth::user()->id)->whereHas('roles', function ($query) {
                $query->where('name', '!=', 'superadmin');
            })->get()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'department' => $user->employee->subDepartment->department->short_name,
                    'position' => $user->employee->position->name,
                    'nik' => $user->employee->nik,
                ];
            });
        }
        return view('back-end.document.generate.edit', compact('documentType', 'document', 'employees'));
    }

    public function store(Request $request, DocumentType $documentType)
    {

        // return response()->json(['status' => true, 'data' => $request->all()]);

        $formFields = $documentType->formFields()->get();
        $validationRules = [
            // 'document_title' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            // 'surat_pengantar_rt' => 'required|file|mimes:pdf|max:2048',
            // 'surat_pengantar_rw' => 'required|file|mimes:pdf|max:2048',
            // 'kk' => 'required|file|mimes:pdf|max:2048',
            // 'ktp' => 'required|file|mimes:pdf|max:2048',
        ];

        $validationMessages = [
            'document_title.required' => 'Document title is required.',
        ];

        foreach ($formFields as $field) {
            $rule = $field->is_required ? 'required' : 'nullable';
            $fieldNameForValidation = 'fields.' . $field->id;

            switch ($field->field_type) {
                case 'text':
                case 'textarea':
                    $validationRules[$fieldNameForValidation] = $rule . '|string';
                    break;
                case 'number':
                    $validationRules[$fieldNameForValidation] = $rule . '|numeric';
                    break;
                case 'date':
                    $validationRules[$fieldNameForValidation] = $rule . '|date';
                    break;
                case 'select':
                    // Validasi bahwa nilai yang dipilih ada dalam opsi yang tersedia
                    $options = collect(explode(", ", $field->field_options))->map(function ($option) {
                        return trim(explode(':', trim($option), 2)[0]);
                    })->filter()->all();
                    if (!empty($options)) {
                         $validationRules[$fieldNameForValidation] = $rule . '|in:' . implode(',', $options);
                    } else {
                        $validationRules[$fieldNameForValidation] = $rule;
                    }
                    break;
                case 'checkbox': // Grup Checkbox
                    $validationRules[$fieldNameForValidation] = $rule . '|array'; // Pastikan itu array
                    // Validasi setiap item dalam array checkbox
                    $checkboxOptions = collect(explode(", ", $field->field_checkbox_options))->map(function ($option) {
                        return trim(explode(':', trim($option), 2)[0]);
                    })->filter()->all();

                    if (!empty($checkboxOptions)) {
                        $validationRules[$fieldNameForValidation . '.*'] = 'string|in:' . implode(',', $checkboxOptions);
                    }
                    break;
                case 'file':
                    $validationRules[$fieldNameForValidation] = $rule . '|file|max:2048'; // Contoh: max 2MB
                    break;
            }
            if ($field->is_required) {
                $validationMessages[$fieldNameForValidation . '.required'] = $field->field_label . ' is required.';
            }
        }

        $validator = Validator::make($request->all(), $validationRules, $validationMessages);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $validatedData = $validator->validated();

        $user = $validatedData['user_id'] ? User::find($validatedData['user_id']) : Auth::user();




        // Hitung 'no_urut'
        $number = $this->generateDocumentNumber($documentType, $user);

        $fileData = [];
        foreach (['surat_pengantar_rt', 'surat_pengantar_rw', 'kk', 'ktp'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                try {
                    $file = $request->file($fileKey);
                    $fileName = rand(1000, 9999) . '_' . time() . '_' . $fileKey . '.pdf';
                    $file->storeAs('files', $fileName, 'public');
                    $fileData[$fileKey] = $fileName;
                } catch (\Exception $e) {
                    Log::error("Failed to upload file {$fileKey}: " . $e->getMessage());
                    throw new \Exception("Failed to upload file {$fileKey}. Please try again.");
                }
            }
        }

        // 1. Create the Document
        $document = Document::create([
            'document_type_id' => $documentType->id,
            'number' => $number,
            'user_id' => $validatedData['user_id'] ?? Auth::id(),
            'created_by' => Auth::id(),
            'surat_pengantar_rt' => $fileData['surat_pengantar_rt'] ?? null,
            'surat_pengantar_rw' => $fileData['surat_pengantar_rw'] ?? null,
            'kk' => $fileData['kk'] ?? null,
            'ktp' => $fileData['ktp'] ?? null
        ]);


        if (isset($validatedData['fields'])) {
            foreach ($validatedData['fields'] as $formFieldId => $value) {
                $fieldModel = FormField::find($formFieldId);
                if (!$fieldModel) continue;


                $actualValue = $value;

                if ($fieldModel->field_type === 'file' && $request->hasFile('fields.' . $formFieldId)) {
                    // Handle file upload
                    $filePath = $request->file('fields.' . $formFieldId)->store('document_files/' . $document->id, 'public');
                    $actualValue = $filePath;
                } elseif ($fieldModel->field_type === 'checkbox' && is_array($value)) {
                    // Untuk checkbox group, simpan sebagai JSON string atau format lain
                    $actualValue = json_encode(array_keys($value)); // Menyimpan keys (nilai checkbox yang dipilih)
                }

                DocumentFieldValue::create([
                    'document_id' => $document->id,
                    'form_field_id' => $formFieldId,
                    'value' => $actualValue,
                ]);
            }
        }



        // Redirect dengan pesan sukses
        // Anda mungkin ingin redirect ke halaman detail dokumen yang baru dibuat atau daftar dokumen
        return redirect()->route('dashboard')->with('success', 'Document "' . $document->title . '" has been generated successfully!');
    }

    public function update(Request $request, DocumentType $documentType, Document $document)
    {
        $validationRules = [
            // Menggunakan 'sometimes|required' memastikan 'document_title' hanya divalidasi jika ada dalam request.
            // Ini cocok untuk form atasan yang mungkin tidak mengirim 'document_title'.
            'document_title' => 'sometimes|required|string|max:255',
        ];
        $validationMessages = [
            'document_title.required' => 'Document title is required.',
        ];

        // Iterasi hanya pada field yang dikirim dalam request 'fields'
        $submittedFieldsData = $request->input('fields', []);
        foreach ($submittedFieldsData as $formFieldId => $valueFromRequest) {
            $field = FormField::find($formFieldId);
            if (!$field) {
                // Lewati jika field ID yang dikirim tidak dikenali
                continue;
            }

            $currentFieldRules = [];
            $fieldNameForValidation = 'fields.' . $field->id;

            switch ($field->field_type) {
                case 'text':
                case 'textarea':
                    if ($field->is_required) $currentFieldRules[] = 'required'; else $currentFieldRules[] = 'nullable';
                    $currentFieldRules[] = 'string';
                    break;
                case 'number':
                    if ($field->is_required) $currentFieldRules[] = 'required'; else $currentFieldRules[] = 'nullable';
                    $currentFieldRules[] = 'numeric';
                    break;
                case 'date':
                    if ($field->is_required) $currentFieldRules[] = 'required'; else $currentFieldRules[] = 'nullable';
                    $currentFieldRules[] = 'date';
                    break;
                case 'select':
                    if ($field->is_required) $currentFieldRules[] = 'required'; else $currentFieldRules[] = 'nullable';
                    $options = collect(explode(", ", $field->field_options))->map(function ($option) {
                        return trim(explode(':', trim($option), 2)[0]);
                    })->filter()->all();
                    if (!empty($options)) {
                        $currentFieldRules[] = 'in:' . implode(',', $options);
                    }
                    break;
                case 'checkbox':
                    // Array field 'fields[id]' bisa required, item di dalamnya divalidasi terpisah
                    if ($field->is_required) $currentFieldRules[] = 'required'; else $currentFieldRules[] = 'nullable';
                    $currentFieldRules[] = 'array';
                    $checkboxOptions = collect(explode(", ", $field->field_checkbox_options))->map(function ($option) {
                        return trim(explode(':', trim($option), 2)[0]);
                    })->filter()->all();
                    if (!empty($checkboxOptions)) {
                        // Validasi untuk setiap item dalam array checkbox
                        $validationRules[$fieldNameForValidation . '.*'] = 'string|in:' . implode(',', $checkboxOptions); // Tetap terpisah
                    }
                    break;
                case 'file':
                    $existingFileValue = $document->fieldValues->where('form_field_id', $field->id)->first()?->value;
                    $newFileUploaded = $request->hasFile('fields.' . $field->id); // Cek apakah file baru diupload
                    if ($field->is_required && !$newFileUploaded && !$existingFileValue) {
                        $currentFieldRules[] = 'required'; // Wajib jika field required, tidak ada file baru, dan tidak ada file lama
                    } else {
                        $currentFieldRules[] = 'nullable'; // Jika tidak, maka nullable
                    }
                    $currentFieldRules[] = 'file'; // Selalu validasi sebagai file jika ada
                    $currentFieldRules[] = 'max:2048'; // Batasan ukuran
                    break;
            }
            $validationRules[$fieldNameForValidation] = implode('|', $currentFieldRules);

            // Tambahkan pesan error kustom jika field memang 'required'
            if ($field->is_required) {
                $validationMessages[$fieldNameForValidation . '.required'] = $field->field_label . ' is required.';
            }
        }

        $validator = Validator::make($request->all(), $validationRules, $validationMessages);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $validatedData = $validator->validated();

        // 1. Update the Document
        // $document->update([
        //     'title' => $validatedData['document_title'],
        //     // user_id and document_type_id typically don't change on update
        // ]);

        // 2. Update or Create Field Values
        $kejadianKe = 1;
        if (isset($validatedData['fields'])) {
            foreach ($validatedData['fields'] as $formFieldId => $value) {
                $fieldModel = FormField::find($formFieldId);
                if (!$fieldModel) continue;

                $actualValue = $value;
                $existingFieldValue = $document->fieldValues()->where('form_field_id', $formFieldId)->first();

                if ($fieldModel->field_type === 'file') {
                    if ($request->hasFile('fields.' . $formFieldId)) {
                        // Delete old file if exists
                        if ($existingFieldValue && $existingFieldValue->value && Storage::disk('public')->exists($existingFieldValue->value)) {
                            Storage::disk('public')->delete($existingFieldValue->value);
                        }
                        // Store new file
                        $filePath = $request->file('fields.' . $formFieldId)->store('document_files/' . $document->id, 'public');
                        $actualValue = $filePath;
                    } else {
                        // No new file uploaded, keep the existing value if any
                        $actualValue = $existingFieldValue ? $existingFieldValue->value : null;
                    }
                } elseif ($fieldModel->field_type === 'checkbox') {
                    // For checkbox group, store as JSON string
                    // If $value is null (no checkboxes selected for a non-required field), store empty array.
                    $actualValue = json_encode(is_array($value) ? array_keys($value) : []);
                }

                if ($fieldModel->field_name === 'jenis_kejadian') {
                    $kejadianKe += (new Document)->countJenisBeritaAcara($document->user_id, $value);
                }

                if ($fieldModel->field_name === 'kejadian_ke') {
                    $actualValue = $kejadianKe;
                }

                DocumentFieldValue::updateOrCreate(
                    [
                        'document_id' => $document->id,
                        'form_field_id' => $formFieldId,
                    ],
                    [
                        'value' => $actualValue,
                    ]
                );
            }
        }
        $redirectRoute = $request->input('detail')
            ? route('document.approval.index', $document->id)
            : route('dashboard');

        return redirect($redirectRoute)->with('success', 'Document "' . $document->title . '" has been updated successfully!');
    }

    public function generate(Document $document)
    {
        if (!$document->documentType) {
            return redirect()->back()->with('error', 'Document type is missing for the document.');
        }

        $pdfData = [];

        // Informasi dasar dokumen
        $pdfData['document_title'] = $document->title;
        $pdfData['document_type_name'] = $document->documentType->name;
        $pdfData['creator'] = $document->creator;
        $pdfData['created_at'] = $document->created_at ? Carbon::parse($document->created_at)->locale('id_ID')->translatedFormat('d F Y') : '-';
        // $pdfData['approved_at'] = $document->created_at ? Carbon::parse($document->approval->where(''))->locale('id_ID')->translatedFormat('d F Y') : '-';
        $pdfData['berlaku_hingga'] = $document->approval?->sign_at ? Carbon::parse($document->approval->sign_at)->addMonths(4)->locale('id_ID')->translatedFormat('d F Y') : '-';
        // Informasi pengguna
        $pdfData['user'] = $document->user;
        $pdfData['user_sign'] = $document->approval?->signBy ?? [];
        $roleName = $document->approval?->signBy?->roles->first()->name ?? '';
        $pdfData['role_user_sign'] = ucwords(str_replace('-', ' ', $roleName));
        $pdfData['sign_image'] = $document->approval?->qr_code_image ?? null;
        $pdfData['no_urut'] = $document->number;



        // Menyiapkan nilai-nilai field dinamis
        $pdfData['fields'] = [];

        foreach ($document->fieldValues as $fieldValue) {
            $formField = $fieldValue->formField;
            if (!$formField) continue;

            $fieldName = $formField->field_name; // Ini adalah nama placeholder yang akan digunakan sebagai key
            $value = $fieldValue->value;

            if ($fieldName === 'konsekuensi' && $formField->field_type === 'select') {
                $selectedValue = $value;
                // Ambil opsi dari definisi FormField, atau gunakan default jika tidak ada
                $konsekuensiRawOptions = $formField->field_options ?: 'Coaching, Teguran Lisan, Surat Peringatan, Lain-lain';
                $konsekuensiOptions = array_map('trim', explode(',', $konsekuensiRawOptions));

                foreach ($konsekuensiOptions as $optionText) {
                    $imgKey = $fieldName . '_' . Str::slug($optionText, '_') . '_img';
                    // Jika $checkImgData atau $uncheckImgData null (karena file tidak ada), maka src di PDF akan kosong
                    $pdfData['fields'][$imgKey] = ($selectedValue === $optionText && $checkImgData) ? $checkImgData : $uncheckImgData;
                }
                // Simpan juga nilai asli dari 'konsekuensi' jika diperlukan untuk teks
                $pdfData['fields'][$fieldName] = $value ?? '-';

            } elseif ($formField->field_type == 'date') {
                $pdfData['fields'][$fieldName] = $value ? Carbon::parse($value)->locale('id_ID')->translatedFormat('d F Y') : '-';
            } elseif ($formField->field_type == 'checkbox') {
                $selectedValuesFromDb = json_decode($value, true) ?: [];
                $allCheckboxOptionsString = $formField->field_checkbox_options ?? '';
                $allCheckboxOptions = !empty($allCheckboxOptionsString) ? array_map('trim', explode(',', $allCheckboxOptionsString)) : [];

                $checkSymbol = '✔';
                $noCheckSymbol = '☐'; // Menggunakan karakter kotak kosong yang lebih umum

                foreach ($allCheckboxOptions as $option) {
                    // Buat key untuk setiap opsi checkbox, mirip dengan placeholder di Word
                    // contoh: jika field_name 'konsekuensi' dan opsi 'Coaching', key menjadi 'konsekuensi_Coaching'
                    $optionKey = $fieldName . '_' . Str::slug($option, '_'); // Menggunakan Str::slug untuk key yang aman
                    $isSelected = in_array($option, $selectedValuesFromDb);
                    $displayText = ($isSelected ? $checkSymbol : $noCheckSymbol) . ' ' . $option;
                    $pdfData['fields'][$optionKey] = $displayText;
                    // Jika Anda ingin menyimpan status boolean juga:
                    // $pdfData['fields'][$optionKey . '_selected'] = $isSelected;
                }
            } elseif ($formField->field_type == 'file') {
                // Untuk tipe file, Anda bisa mengirimkan URL atau nama file
                $pdfData['fields'][$fieldName] = $value ? asset('storage/' . $value) : '-';
            } else {
                $pdfData['fields'][$fieldName] = $value ?? '-';
            }
        }


        $template = Str::lower(Str::replace(' ', '_', $document->documentType->name));
        // dd($pdfData);
        try {
            // Simpan PDF ke storage
            return Pdf::loadView('template-doc.'. $template, $pdfData)->stream('text');

        } catch (\Exception $e) {
            Log::error("Gagal membuat PDF untuk dokumen ID {$document->id}: " . $e->getMessage() . "\nStack Trace:\n" . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
    }
}
