<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Answer;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::with('answers')->get();
        return Inertia::render('Questions', ['questions' => $questions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestdata = $request->all();
        $question = $requestdata['question'];

        //this code gone save the question in the database
        $newQuestion = new Question();
        $newQuestion->question = $question;
        $newQuestion->save();

        $answers = $requestdata['answers'];
        foreach ($answers as $answer) {
            $newAnswer = new Answer();
            $newAnswer->answer = $answer['answer'];
            $newAnswer->question_id = $newQuestion->id;
            $newAnswer->correct_answer = $answer['correct_answer'];
            $newAnswer->save();
        }

        return redirect('/questions')->with('success', 'Question and answer created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $id = $request['id'];
        $editQuestion = Question::findOrFail($id);
        $editQuestion->question = $request['question'];
        $editQuestion->save();

        return redirect('/questions')->with('success', 'Question edited succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        
    }
}
