<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    protected $fillable = ['no_kk', 'nama_ayah', 'nama_ibu', 'no_hp', 'alamat'];

    public function balitas()
    {
        return $this->hasMany(Balita::class);
    }
}
