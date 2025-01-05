<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendamping extends Model
{
    protected $table = 'pendampings';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function sekolah() {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }
}
