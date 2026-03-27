<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class UserController extends Controller
{
public function index() {
        return response()->json([
            'message' => 'index' 
        ]);
    }
    public function store(Request $request) {
        return response()->json([
            'message' => 'store'
        ]);
    }
    public function show(string $id) {
        return response()->json([
            'message' => "show {$id}"
        ]);
    }
    public function update(Request $request, string $id) {
        return response()->json([
            'message' => "update {$id}" 
        ]);
    }
    public function destroy(string $id) {
        return response()->json([
            'message' => "destroy {$id}"
        ]);
    }
}

