<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libur extends Model
{
    protected $table = 'libur';

    protected $fillable = [
        'tanggal',
        'keterangan'
    ];
}
