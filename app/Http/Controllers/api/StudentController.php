<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
   
    public function index()
    {
        return response()->json(Student::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string",
            "email"=>"required|email",
            "address" =>"required"
        ]);

        Student::create($data);
        return response()->json([
            "status" =>true,
            "message" => "Student created scueessfulluy"
        ]);
    }

    public function show(Student $student)
    {
        return response()->json([
            'status' =>'true',
            'message' => 'Student Data',
            'data '=> $student
        ]);
    }

    
    public function update(Request $request,Student $student)
    {
        $request->validate([
            "name" => "required|string",
            "email"=>"required|email",
            "address" =>"required"
        ]);

        $student->update($request->all() );
        return response()->json([
            "status" => "true",
            "message" => "student successfully updates"
        ]);
    }

    
    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json([
              "status" => "true",
            "message" => "student successfully deleted"
        ]);
    }
}
