<?php

namespace App\Jobs;

use App\Events\UpdatePoint;
use App\Models\Point;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendUpdatePoint implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Point $point)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        UpdatePoint::dispatch([
            'id' => $this->point->id,
            'sekolah_id' => $this->point->sekolah_id,
            'point' => $this->point->text,
            'time' => $this->point->time,
        ]);                
    }
}
