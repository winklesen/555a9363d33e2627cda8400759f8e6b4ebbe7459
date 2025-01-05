<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'pesertas';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function sekolah() {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }
}
