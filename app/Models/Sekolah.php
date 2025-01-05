<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolahs';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function provinsi() {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function pesertas() {
        return $this->hasMany(Peserta::class);
    }

    public function pendampings() {
        return $this->hasMany(Sekolah::class);
    }

    public function points() {
        return $this->hasMany(Point::class);
    }
}
