<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perizinan extends Model
{
    protected $table = 'perizinan';

    protected $fillable = [
        'user_id',
        'jenis',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'lampiran',
        'status',
        'approved_by',
        'approved_at'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
