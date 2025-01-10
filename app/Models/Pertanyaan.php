<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $table = 'pertanyaans';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function tema() {
        return $this->belongsTo(Tema::class, 'tema_id');
    }

    public function jawabans() {
        return $this->hasMany(Jawaban::class);
    }

    public function jawaban() {
        return $this->hasOne(Jawaban::class);
    }
}
