<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    protected $fillable = ['orang_tua_id', 'nik', 'nama', 'tanggal_lahir', 'jenis_kelamin'];

    public function orangTua()
    {
        return $this->belongsTo(OrangTua::class);
    }

    public function pemeriksaans()
    {
        return $this->hasMany(Pemeriksaan::class);
    }
}
