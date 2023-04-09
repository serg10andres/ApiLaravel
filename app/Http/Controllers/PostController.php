<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        if($posts->count() > 0){
            $data = [
                'status' => 200,
                'posts' => $posts
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
            'title' => 'required|string',
            'category' => 'required|string',
            'content' => 'required|string',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }
        else
        {
            $post = Post::create([
                'title' => $request->title,
                'category' => $request->category,
                'content' => $request->content,
                'status' => !$request->status ? 0 : 1,
                'created_by' => $request->created_by
            ]);
        }


        if($post){
            return response()->json([
                'status' => 200,
                'message' => "Post created successfully"
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
        $post = Post::find($id);

        if($post){
            return response()->json([
                'status' => 200,
                'post' => $post
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 500,
                'post' => 'No such post found'
            ], 500);
        }
    }

    public function edit($id)
    {
        $post = Post::find($id);

        if($post){
            return response()->json([
                'status' => 200,
                'post' => $post
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'No such post found'
            ], 404);
        }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string',
            'category' => 'required|string',
            'content' => 'required|string',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }
        else
        {
            $post = Post::find($id);
        }


        if($post){

            $post->update([
                'title' => $request->title,
                'category' => $request->category,
                'content' => $request->content,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => 200,
                'message' => "Post updated successfully"
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => "No post ID found"
            ], 404);
        }
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if($post){
            $post->delete();
            return response()->json([
                'status' => 200,
                'message' => "Post deleted successfully"
            ], 200);
        }

        else
        {
            return response()->json([
                'status' => 404,
                'message' => "No such post found"
            ], 404);
        }
    }



}
