<?php

namespace App\Http\Controllers;

use App\Http\Resources\GradeResource;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //tampilkan semua grade menggunakan resource dan dibatasi 10 per halaman
        return GradeResource::collection(
            Grade::with(['student', 'course'])->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi grade baru
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'grade' => 'required|integer'
        ]);

        //simpan grade baru
        $grade = Grade::create($validated);

        return response()->json($grade, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //tampilkan grade berdasarkan ID grade
        return new GradeResource(
            Grade::with(['student', 'course'])->findOrFail($id)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Update grade berdasarkan ID
        $grade = Grade::findOrFail($id);

        $validated = $request->validate([
            'student_id' => 'sometimes|required|exists:students,id',
            'course_id' => 'sometimes|required|exists:courses,id',
            'grade' => 'sometimes|required|integer|min:0|max:100',
        ]);

        $grade->update($validated);

        return response()->json(['message' => 'Grade updated successfully', 'data' => $grade]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Hapus grade berdasarkan ID
        $grade = Grade::findOrFail($id);
        $grade->delete();

        return response()->json(['message' => 'Grade deleted successfully', 'data' => $grade]);
    }

    // Mendapatkan semua grade untuk seorang siswa berdasarkan ID student
    public function getGradesByStudent($id)
    {
        $grades = Grade::where('student_id', $id)
            ->with(['student', 'course'])
            //membatasi hasil tabel yang ditampilkan sebanyak 10 per halaman
            ->paginate(10);

        return GradeResource::collection($grades);
    }

    // Mendapatkan semua grade untuk sebuah mata kuliah berdasarkan ID course
    public function getGradesByCourse($id)
    {
        $grades = Grade::where('course_id', $id)
        ->with(['course', 'student'])
        ->paginate(10);

        return GradeResource::collection($grades);
    }
}
