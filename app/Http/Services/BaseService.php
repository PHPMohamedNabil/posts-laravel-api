<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

abstract class BaseService{


    protected $model;


    public function __construct($model)
    {
    	 $this->model = $model;
    }

    abstract public function register(array $data);

    abstract public function update(array $data,$id);

    abstract public function delete($request);


    public function uploadImage(UploadedFile $image)
    {
         $path = $image->store('images');
         return Storage::disk('public')->url($path);
    }

    public function uploadImageOldDelete($old_image,UploadedFile $new_image)
    {  

         $filename = basename($old_image);

         Storage::delete('images'.DIRECTORY_SEPARATOR,$filename);

         $path = $new_image->store('images');
         return Storage::disk('public')->url($path);
    }

    public function loggedInUser()
    {
         return Auth::user();
    }

    public function isValidAction($action,$model)
    {
        return  Gate::authorize('update',$model);
    }


}