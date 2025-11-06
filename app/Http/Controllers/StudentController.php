<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return StudentResource::collection(Student::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|unique:students,nim|max:20',
            'email' => 'required|email|unique:students,email|max:255',
        ]); 

        $student = Student::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'email' => $request->email,
        ]);

        return response()->json([
            'message' => 'Student created successfully',
            'data' => $student
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return new StudentResource(Student::findOrfail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'nim' => 'sometimes|required|string|unique:students,nim,' . $student->id,
            'email' => 'sometimes|required|email|unique:students,email,' . $student->id,
        ]);

        $student->update($request->all());

        return response()->json($student);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Student::findOrFail($id)->delete();

        return response()->json(['message' => 'deleted successfully'], 200);
    }

    //tampilkan student beserta grades dan courses berdasarkan ID student
    public function getStudentwithGrades($id)
    {
        $student = Student::with('grades')->findOrFail($id);
        return new StudentResource($student);
    }

}
