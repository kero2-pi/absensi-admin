<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table = 'shift';
    protected $fillable = [
        'nama_shift',
        'mulai',
        'selesai'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
