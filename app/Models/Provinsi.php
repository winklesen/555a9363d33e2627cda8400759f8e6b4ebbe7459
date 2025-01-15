<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinsis';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function user() {
        return $this->hasOne(User::class);
    }

    public function sekolahs() {
        return $this->hasMany(Sekolah::class);
    }

    public function provinsis() {
        return $this->hasMany(Provinsi::class);
    }

    public function temas() {
        return $this->hasMany(Tema::class);
    }

    public function pertanyaans() {
        return $this->hasMany(Pertanyaan::class);
    }
}
