<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    protected $fillable = [
        'document_type_id',
        'number',
        // 'title',
        'user_id',
        'created_by',
        'path',
        'active_date',
    ];

    /**
     * Definisi relasi: Satu dokumen dimiliki oleh satu document_type.
     */
    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id', 'id');
    }

    /**
     * Definisi relasi: Satu dokumen memiliki banyak document_field_values.
     */
    public function fieldValues(): HasMany
    {
        return $this->hasMany(DocumentFieldValue::class);
    }

    /**
     * Mendapatkan nilai field berdasarkan nama field.
     * Ini akan sangat memudahkan Anda.
     */
    public function getFieldValue(string $fieldName): ?string
    {
        // Mencari form_field yang terkait dengan fieldName
        $formField = $this->documentType->formFields->where('field_name', $fieldName)->first();

        if ($formField) {
            // Mencari document_field_value yang sesuai untuk dokumen ini dan form_field tersebut
            $documentFieldValue = $this->fieldValues->where('form_field_id', $formField->id)->first();
            return $documentFieldValue ? $documentFieldValue->value : null;
        }

        return null;
    }

    public function getLastUserApproval()
    {
        return $this->approvals()->where('status', '!=', 'approved')->exists()
            ? $this->approvals()->where('status', '!=', 'approved')->orderBy('order', 'asc')->first()
            : $this->approvals()->orderBy('order', 'desc')->first();
    }

    public function approvalExists(): bool
    {
        return $this->approvals()->where('status', '=', ['approved', 'rejected'])->exists();
    }

    public function countDocumentApproval($user_id)
    {
        return $this->where('user_id', $user_id)->whereDoesntHave('approvals', function ($query) {
            $query->where('status', '!=', 'approved');
        })->whereHas('approvals')->count();
    }

    public function countJenisBeritaAcara($user_id, $jenis_kejadian)
    {
        return $this->where('user_id', $user_id)
            ->whereHas('documentType', function ($query) {
                $query->where('name', 'like', '%Berita Acara%');
            })
            ->whereHas('fieldValues', function ($query) use ($jenis_kejadian) {
                $query->whereHas('formField', function ($q) {
                    $q->where('field_name', 'jenis_kejadian');
                })->where('value', $jenis_kejadian);
            })
            ->count();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function creator() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class, 'document_id', 'id');
    }
}
