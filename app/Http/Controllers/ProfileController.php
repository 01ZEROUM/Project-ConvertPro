<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
      
    public function show() {
        return response()->json([
            'message' => 'show'
        ]);
    }
     
    public function update(Request $request) {
        return response()->json([
            'message' => 'uptade'
        ]);
    }
     
    public function destroy() {
        return response()->json([
            'message' => 'destroy'
        ]);
    }
}
