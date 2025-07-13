<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormField extends Model
{
    use HasFactory;

    protected $table = 'form_fields';

    protected $fillable = [
        'document_type_id',
        'field_name',
        'field_label',
        'field_type',
        'field_options',
        'field_checkbox_options',
        'is_required',
        'order',
        'hint',
    ];

    // Kolom yang harus di-cast ke tipe data tertentu
    protected $casts = [
        'is_required' => 'boolean',
        // 'is_header' => 'boolean',
        'order' => 'integer',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($formField) {
            $formField->order = static::where('document_type_id', $formField->document_type_id)->max('order') + 1;
        });
    }

    /**
     * Definisi relasi: Satu form_field dimiliki oleh satu document_type.
     */
    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    /**
     * Definisi relasi: Satu form_field memiliki banyak document_field_values.
     */
    public function documentFieldValues(): HasMany
    {
        return $this->hasMany(DocumentFieldValue::class);
    }
}
