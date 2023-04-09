<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    //
    public function show($id){
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
                'status' => 500,
                'user' => 'No such student found'
            ], 500);
        }
    }
}
