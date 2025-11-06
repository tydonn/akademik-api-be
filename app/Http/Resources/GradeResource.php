<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'course_id' => $this->course_id,
            'student_id' => $this->student_id,
            'grade' => $this->grade,

            // ambil data relasi student
            'student' => [
                'id' => $this->student->id,
                'name' => $this->student->name,
                'nim' => $this->student->nim,
                'email' => $this->student->email,
            ],

            //ambil data relasi course
            'course' => [
                'id' => $this->course->id,
                'name' => $this->course->name,
                'code' => $this->course->code,
                'sks' => $this->course->sks,
            ],
        ];
    }
}
