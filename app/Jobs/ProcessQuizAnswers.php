<?php

namespace App\Jobs;

use App\Models\QuizDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessQuizAnswers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $quizDetailId;
    protected $answerId;

    public function __construct($quizDetailId, $answerId)
    {
        $this->quizDetailId = $quizDetailId;
        $this->answerId = $answerId;
    }

    public function handle()
    {
        $quizDetail = QuizDetails::find($this->quizDetailId);
        if ($quizDetail) {
            $quizDetail->user_answer = $this->answerId;
            $quizDetail->save();
        }
    }
}
