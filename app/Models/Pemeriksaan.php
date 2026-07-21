<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    protected $fillable = ['balita_id', 'user_id', 'tanggal_pemeriksaan', 'umur_bulan', 'berat_badan', 'tinggi_badan', 'lila', 'status_pertumbuhan'];

    public function balita()
    {
        return $this->belongsTo(Balita::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
