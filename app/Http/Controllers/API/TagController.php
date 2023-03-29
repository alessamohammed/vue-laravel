<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;


class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all()->toArray();
        return array_reverse($tags);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add(Request $request)
    {
        $tag = new Tag([
            'name' => $request->input('name')
        ]);
        $tag->save();

        return response()->json('The tag successfully added');
    }


    public function edit($id)
    {
        $tag = Tag::find($id);
        return response()->json($tag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);
        $tag->update($request->all());

        return response()->json('The tag successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $tag = Tag::find($id);
        $tag->delete();

        return response()->json('The tag successfully deleted');
    }
}
