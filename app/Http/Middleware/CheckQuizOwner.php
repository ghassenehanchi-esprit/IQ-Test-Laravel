<?php

namespace App\Http\Middleware;

use App\Models\QuizDetails;
use App\Models\Quizz;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckQuizOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check if the request has an 'id' (for Quiz) or a 'quiz_detail_id' (for QuizDetail)
        if ($request->route('id')) {
            // This is a Quiz
            $quiz = Quizz::find($request->id);

            // If the Quiz doesn't exist or doesn't belong to the authenticated user, or its status isn't 0, return a 403 response
            if (!$quiz || $quiz->user_id != auth('user')->id() || $quiz->quizz_status != 0) {
                return response()->view('errors.403', ['message' => 'You are not authorized to access this quiz.'], 403);
            }
        } elseif ($request->route('quiz_detail_id')) {
            // This is a QuizDetail
            $quizDetail = QuizDetails::find($request->quiz_detail_id);

            // If the QuizDetail doesn't exist or doesn't belong to the authenticated user, return a 403 response
            if (!$quizDetail || $quizDetail->user_id != auth()->id()) {
                return response()->view('errors.403', ['message' => 'You are not authorized to access this quiz detail.'], 403);
            }

            // Retrieve the associated Quiz
            $quiz = Quizz::find($quizDetail->quiz_id);

            // If the Quiz doesn't exist or its status isn't 0, return a 403 response
            if (!$quiz || $quiz->quizz_status != 0) {
                return response()->view('errors.403', ['message' => 'This quiz is not available.'], 403);
            }
        } else {
            // Neither 'id' nor 'quiz_detail_id' was provided in the request
            return response()->view('errors.400', ['message' => 'Bad Request.'], 400);
        }

        return $next($request);
    }

}
