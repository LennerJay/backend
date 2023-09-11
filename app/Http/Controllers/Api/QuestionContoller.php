<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Questionaire;
use Illuminate\Http\Request;

class QuestionContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        // dd($id);
        $questionaire = Questionaire::where('id', $id)
                                    ->with('criterias.questions')
                                    ->first();
        return view('questions.index',compact('questionaire'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
