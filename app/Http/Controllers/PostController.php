<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Intervention\Image;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Http\Services\PostService;

class PostController extends Controller implements HasMiddleware
{

    protected $service;


    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json(['data'=>$request->user()->post()->orderBy('pinned','desc')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {    
        $post = $this->service->register($request->all());

         return response()->json(['status'=>'post added successfully','data'=>$post],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,string $id)
    {
      return response()->json(['data'=>$this->service->loggedInUserPost($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, string $id)
    {  
        $post = $this->service->update($request->all(),$id);
        
         return response()->json(['status'=>'post updated successfully','data'=>$post],201);
       //    return response()->json(['status'=>'post added successfully'],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Post $post)
    {
        $this->service->delete($post);

        return response()->json(['status'=>'post deleted successfully'],201);
    }

    public function trashed(Request $request)
    {
       $post = $request->user()->post()->onlyTrashed()->get();
   
        return response()->json($post);
    }


    public function restore(Request $request,$id)
    {

       $post = $request->user()->post()->onlyTrashed()->findOrFail($id);
       
        $post->restore();

        return response()->json($post);
    }

}
