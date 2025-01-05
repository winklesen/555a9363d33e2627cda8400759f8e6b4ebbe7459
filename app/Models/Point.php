<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table = 'points';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function sekolah() {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }
}
