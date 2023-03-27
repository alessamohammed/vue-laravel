<?php

namespace App\Http\Controllers\Api;

use App\Models\Highlight;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HighlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $highlights = Highlight::all()->toArray();
        return array_reverse($highlights);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add(Request $request)
    {
       $highlight = new Highlight([
        'user_id' => $request->input('user_id'),
        'start_offset' => $request->input('start_offset'),
        'end_offset' => $request->input('end_offset')
       ]);
       $highlight->save();
    }

}