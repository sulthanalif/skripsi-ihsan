<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
        'user_id',
        'nik',
        'kk',
        'birth_place',
        'birth_date',
        'gender',
        'nationality',
        'religion',
        'marital_status',
        'occupation',
        'address_ktp',
        'address_domisili',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
