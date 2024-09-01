<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Tag;

class TagController  extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum')
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['tags'=>Tag::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
              'name'=>'required|unique:tags'
        ]);

         $tag = Tag::Create($request->all());
         return response()->json(['status'=>'tag added successfully','data'=>$tag],201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

       $request->validate([
              'name'=>'required|unique:tags,id:'.$id
        ]);

         $tag = Tag::where('id',$id)->update($request->all());

        return response()->json(['status'=>'tag updated successfully','data'=>Tag::where('id',$id)->get()],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        $request->validate([
              'id'=>'required|exists:tags'
        ]);

         Tag::findorFail($id)->delete();

        return response()->json(['status'=>'tag deleted successfully'],201);
    }
}
