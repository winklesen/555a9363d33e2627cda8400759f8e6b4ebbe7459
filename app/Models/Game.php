<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function provinsi() {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function sekolahs() {
        return $this->belongsToMany(Sekolah::class, 'points')
                    ->withPivot(
                        'point',
                        'status',
                    )
                    ->withTimestamps();
    }

    public function points() {
        return $this->hasMany(Point::class);
    }
}
