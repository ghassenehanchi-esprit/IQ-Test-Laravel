<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Category;
use App\Models\QuizOrder;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Display a listing of the questions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pageTitle = 'Questions';
        // Retrieve all questions from the database
        $questions = Question::all();

        // Return the view with the questions data
        return view('admin.Question.index', compact('pageTitle', 'questions'));
    }

    /**
     * Show the form for creating a new question.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $pageTitle = 'Add a new question';

        // Fetch all categories
        $categories = Category::all();

        // Return the create view
        return view('admin.Question.add', compact('pageTitle', 'categories'));
    }

    /**
     * Store a newly created question in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'question_text' => 'required|string',
            'question_image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'answers.*' => 'nullable|string',
            'answer_images.*' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'is_correct' => 'required|integer',
        ]);

        // Handle the question image upload
        $questionImageName = null;
        if ($request->hasFile('question_image')) {
            $questionImage = $request->file('question_image');
            $questionImageName = time() . '_' . $questionImage->getClientOriginalName();
            $questionImage->storeAs('public/questions', $questionImageName);
        }

        // Create a new question
        $question = Question::create([
            'question_text' => $validatedData['question_text'],
            'question_image' => $questionImageName,
            'category_id' => $validatedData['category_id'],
        ]);

        // Handle the answer uploads and create the answers
        foreach ($request->input('answers', []) as $index => $answerText) {
            $answerImageName = null;
            if ($request->hasFile('answer_images.' . $index)) {
                $answerImage = $request->file('answer_images.' . $index);
                $answerImageName = time() . '_' . $answerImage->getClientOriginalName();
                $answerImage->storeAs('public/answers', $answerImageName);
            }

            $isCorrect = $request->input('is_correct') == $index;

            Answer::create([
                'question_id' => $question->id,
                'answer_text' => $answerText,
                'answer_image' => $answerImageName,
                'is_correct' => $isCorrect ? 1 : 0,
            ]);
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Question added successfully!');
    }

    /**
     * Remove the specified question from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy($id)
    {
        // Find the question by ID
        $question = Question::findOrFail($id);

        // Delete the associated answers' images from storage
        foreach ($question->answers as $answer) {
            if ($answer->answer_image) {
                Storage::delete('public/answers/' . $answer->answer_image);
            }
        }

        // Delete the question image from storage if exists
        if ($question->question_image) {
            Storage::delete('public/questions/' . $question->question_image);
        }

        // Delete the question and its answers from the database
        $question->answers()->delete();
        $question->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Question deleted successfully!');
    }

    //detail method
    public function show(Question $question)
    {
        $pageTitle = 'Question details';

        // Load the related category and answers
        $question->load('category', 'answers');

        // Return the view with the question data
        return view('admin.Question.detail', compact('pageTitle','question'));
    }
    public function orders()
    {
        $pageTitle = 'Paid Orders';

        $paidOrders = QuizOrder::where('is_paid', 1)->get();
        return view('admin.quiz.index', compact('paidOrders','pageTitle'));
    }

    // Other controller methods like edit, update, destroy can be added here as needed
}
