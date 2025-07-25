<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Approval extends Model
{
    protected $table = 'approvals';

    protected $fillable = [
        'document_id',
        'user_id',
        'status',
        'note',
        'sign_by',
        'sign_at',
        'generated_at',
        'sign',
    ];

    protected $appends = [
        'qr_code_image',
    ];

    public function getQrCodeImageAttribute()
    {
        $path = 'sign/' . $this->sign . '.png';
        return base64_encode(Storage::disk('public')->get($path));
    }

    public function signBy()
    {
        return $this->belongsTo(User::class, 'sign_by', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
