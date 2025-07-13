<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentFieldValue extends Model
{
    use HasFactory;

    protected $table = 'document_field_values';

    protected $fillable = [
        'document_id',
        'form_field_id',
        'value',
    ];

    /**
     * Definisi relasi: Satu nilai field dimiliki oleh satu dokumen.
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * Definisi relasi: Satu nilai field dimiliki oleh satu form_field.
     */
    public function formField(): BelongsTo
    {
        return $this->belongsTo(FormField::class);
    }
}
