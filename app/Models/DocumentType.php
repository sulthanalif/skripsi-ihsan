<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentType extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model
    protected $table = 'document_types';

    // Kolom-kolom yang bisa diisi (fillable) secara massal
    protected $fillable = [
        'name',
        'description',
        'template_file_path',
        'status',
    ];

    /**
     * Definisi relasi: Satu jenis dokumen memiliki banyak form_fields.
     */
    public function formFields(): HasMany
    {
        return $this->hasMany(FormField::class);
    }

    /**
     * Definisi relasi: Satu jenis dokumen memiliki banyak dokumen.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
