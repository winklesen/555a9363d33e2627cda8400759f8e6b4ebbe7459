<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $table = 'temas';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function provinsi() {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function pertanyaans() {
        return $this->hasMany(Pertanyaan::class);
    }
}
