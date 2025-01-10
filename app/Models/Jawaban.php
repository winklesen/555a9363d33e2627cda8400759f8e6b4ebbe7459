<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'jawabans';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function pertanyaan() {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }
}
