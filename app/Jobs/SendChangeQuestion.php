<?php

namespace App\Jobs;

use App\Events\ChangeQuestion;
use App\Models\Pertanyaan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendChangeQuestion implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Pertanyaan $question)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ChangeQuestion::dispatch([
            'id' => $this->question->id,            
            'tema_id' => $this->question->tema_id,
            'pertanyaan' => $this->question->pertanyaan,
            'sisi' => $this->question->sisi,
            'sesi' => $this->question->sesi,
            'status' => $this->question->status,

        ]);                        
    }
}
