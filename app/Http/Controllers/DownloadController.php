<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function download($id)
    {
        return "Download funcionando ID: " . $id;
    }
}
