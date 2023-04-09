<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        if($users->count() > 0){
            $data = [
                'status' => 200,
                'users' => $users
            ];
        }
        else{
            $data = [
                'status' => 404,
                'users' => 'No records'
            ];
        }
        

        return response()->json($data, 200);
    }

    

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
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
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'location' => $request->location
            ]);
        }


        if($user){
            return response()->json([
                'status' => 200,
                'message' => "User created successfully, now you can login"
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
        $User = User::find($id);

        if($User){
            return response()->json([
                'status' => 200,
                'User' => $User
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 500,
                'User' => 'No such User found'
            ], 500);
        }
    }
    
    public function edit($id)
    {
        $user = User::find($id);

        if($user){
            return response()->json([
                'status' => 200,
                'user' => $user
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'No such User found'
            ], 404);
        }
    }

 
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
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
            $user = User::find($id);
        }


        if($user){

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'location' => $request->location,
            ]);

            if($request->password){
                $user->update([
                    'password' => Hash::make($request->password),
                ]);   
            }
            

            return response()->json([
                'status' => 200,
                'message' => "User updated successfully"
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => "No User ID found"
            ], 404);
        }


    }

    
    public function destroy($id)
    {
        $user = User::find($id);

        if($user){
            $user->delete();
            return response()->json([
                'status' => 200,
                'message' => "User deleted successfully"
            ], 200);
        }

        else
        {
            return response()->json([
                'status' => 404,
                'message' => "No such User found"
            ], 404);
        }
    }
}
