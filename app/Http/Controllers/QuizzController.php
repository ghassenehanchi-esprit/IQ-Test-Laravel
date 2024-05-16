<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessQuizAnswers;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Order;
use App\Models\Question;
use App\Models\QuizDetails;
use App\Models\QuizOrder;
use App\Models\Quizz;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use TCPDF;

class QuizzController extends Controller
{
    public function create()
    {
        // Fetch categories
        $verbalCategory = Category::where('category_name', 'Verbal')->first();
        $numericalCategory = Category::where('category_name', 'Numerical')->first();
        $logicalCategory = Category::where('category_name', 'Logical')->first();
        $spatialCategory = Category::where('category_name', 'Spatial')->first();

        // Fetch 10 questions from each category randomly
        $verbalQuestions = Question::where('category_id', $verbalCategory->id)->inRandomOrder()->take(1)->get();
        $numericalQuestions = Question::where('category_id', $numericalCategory->id)->inRandomOrder()->take(1)->get();
        $logicalQuestions = Question::where('category_id', $logicalCategory->id)->inRandomOrder()->take(1)->get();
        $spatialQuestions = Question::where('category_id', $spatialCategory->id)->inRandomOrder()->take(1)->get();

        // Merge the questions into one collection
        $questions = $verbalQuestions->concat($numericalQuestions)->concat($logicalQuestions)->concat($spatialQuestions);

        // Create a new quiz instance
        $quiz = new Quizz();
        $quiz->quizz_status = 0; // Status 0 indicates that the quiz has not been completed yet
        $quiz->quizz_score = 0; // Status 0 indicates that the quiz has not been completed yet
        $quiz->created_at = now(); // Set the start date as the current date
        $quiz->save();

        // Create quiz details for each question and attach them to the quiz
        foreach ($questions as $question) {
            $quizDetail = new QuizDetails();
            $quizDetail->quizz_id = $quiz->id;
            $quizDetail->question_id = $question->id;
            $quizDetail->save();
        }

        // Redirect the user to the quiz view with the quiz ID
        return redirect()->route('quizz.show', ['id' => $quiz->id]);
    }

    public function show($id)
    {
        // Fetch the quiz with the given ID
        $quiz = Quizz::with('quizDetails.question.answers')->findOrFail($id);

        $totalQuestions = $quiz->quizDetails->count();

        // Pass the quiz data and total number of questions to the view
        return view('quizz.show', compact('quiz', 'totalQuestions'));
    }


    public function updateQuizDetail(Request $request, $quiz_detail_id)
    {
        $validated = $request->validate([
            'answer_id' => 'required|exists:answers,id',
        ]);

        // Debugging: Check the validated data

        $quizDetail = QuizDetails::find($quiz_detail_id);
        if ($quizDetail) {
            $quizDetail->user_answer = $validated['answer_id'];
            $quizDetail->save();
        }

        // Return a success response (no need to redirect)
        return response()->json(['message' => 'Answer updated successfully']);
    }


    public function showOrderCompleted($id)
    {
        // Fetch the quiz order with the given ID
        $order = QuizOrder::findOrFail($id);



        // Load the view and pass data
        return view('order.quizz_score', compact('order'));
    }

    public function showOrder(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'fullName' => 'required|string',
            'emailAddress' => 'required|email',
        ]);

        // Retrieve the full name and email from the request
        $fullName = $request->input('fullName');
        $emailAddress = $request->input('emailAddress');

        // Retrieve the order data based on the provided ID (assuming you have an Order model)
        $order = QuizOrder::find($id);

        // Return the view with compacted data
        return view('order.pdf', compact('fullName', 'emailAddress', 'order'));
    }


}
