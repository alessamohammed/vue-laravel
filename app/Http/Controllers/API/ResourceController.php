<?php

namespace App\Http\Controllers\Api;

use App\Models\Resource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // include mapped tags
        $resources = Resource::with('tags')->get()->toArray();
        return array_reverse($resources);
    }
    

    // get mapped tags for a resource
    public function getMappedTags($id)
    {
        $resource = Resource::find($id);
        $tags = $resource->tags()->get();
        return $tags;
    }

    public function mapTagToResource(Request $request)
    {
        $resource = Resource::find($request->input('resource_id'));
        $resource->tags()->attach($request->input('tag_id'), ['user_id' => $request->input('user_id')]);
        return response()->json('Resource updated!');
    }

    // unmap tag from resource
    public function unmapTagFromResource(Request $request)
    {
        $resource = Resource::find($request->input('resource_id'));
        $resource->tags()->detach($request->input('tag_id'), ['user_id' => $request->input('user_id')]);
        return response()->json('Resource updated!');
    }
}
