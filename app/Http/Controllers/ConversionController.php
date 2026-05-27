<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversion;
use Symfony\Component\Process\Process;
use App\Jobs\ProcessConversion;

class ConversionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conversions = Conversion::latest()->get();
        return response()->json($conversions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 
public function store(Request $request)
{

    $request->validate([
        'source' => 'required|url',
        'target_format' => 'required|in:mp3,mp4'
    ]);

    $conversion = Conversion::create([
        'user_id' =>null,
        'source' => $request->source,
        'target_format' => $request->target_format,
        'source_type' => 'youtube',
        'status' => 'pending'
    ]);

    ProcessConversion::dispatch($conversion);

    return response()->json([
        'id' => $conversion->id,
        'status' => 'pending'
    ]);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function show($id)
{
    $conversion = Conversion::findOrFail($id);

    return response()->json([
        'id' => $conversion->id,
        'status' => $conversion->status,
        'file_path' => $conversion->file_path,
        'created_at' => $conversion->started_at,
        'completed_at' => $conversion->completed_at
    ]);
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return response()->json([
        'message' => 'Update'
       ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
    {
        $conversion = Conversion::findOrFail($id);
        $conversion->delete();
        return response()->json([
            'message' => 'Conversão deletada com sucesso'

        ]);
    }

  public function status($id)
    {
        $conversion = Conversion::findOrFail($id);
        return response()->json([

            'id' => $conversion->id,
            'status' => $conversion->status,
            'started_at' => $conversion->started_at,
            'completed_at' => $conversion->completed_at

        ]);
    }

    public function retry($id)
    {
        return response()->json([
        'message' => 'Retry' . ' ' . $id
       ]);
    }


}
