<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();

        if($students->count() > 0){
            $data = [
                'status' => 200,
                'students' => $students
            ];
        }
        else{
            $data = [
                'status' => 404,
                'students' => 'No records'
            ];
        }
        

        return response()->json($data, 200);
    }

    

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'course' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',

        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }
        else
        {
            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
        }


        if($student){
            return response()->json([
                'status' => 200,
                'message' => "Student created successfully"
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 500,
                'message' => "Something went wrong"
            ], 500);
        }
    }


    public function show($id)
    {
        $student = Student::find($id);

        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 500,
                'student' => 'No such student found'
            ], 500);
        }
    }
    
    public function edit($id)
    {
        $student = Student::find($id);

        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'No such student found'
            ], 404);
        }
    }

 
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'course' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string'

        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }
        else
        {
            $student = Student::find($id);
        }


        if($student){

            $student->update([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return response()->json([
                'status' => 200,
                'message' => "Student updated successfully"
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => "No student ID found"
            ], 404);
        }


    }

    
    public function destroy($id)
    {
        $student = Student::find($id);

        if($student){
            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => "Student deleted successfully"
            ], 200);
        }

        else
        {
            return response()->json([
                'status' => 404,
                'message' => "No such student found"
            ], 404);
        }
    }
}
