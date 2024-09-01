<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Models\Post;

class PostService extends BaseService{

    
    public function __construct()
    {
    	Parent::__construct(new Post);
    }

    public function register(array $data)
    {   


    	if (isset($data['cover_image']))
         {    
            $data['image_path'] = $this->uploadImage($data['cover_image']);
        }
        
        $post = $this->loggedInUser()->post()->create([
            'title'=>$data['title'],
            'body'=>$data['body'],
            'cover_image'=>$data['image_path'],
            'pinned'=>$data['pinned']
        ]);

         $post->tag()->sync($data['tags']);

         return $post;

    }

    public function update(array $data,$id)
    {
    	$post = $this->loggedInUser()->post()->findOrFail($id);

        $this->isValidAction('update',$post);
         
         if (isset($data['cover_image']))
         {    
            $data['image_path'] = $this->uploadImageOldDelete($post->cover_image,$data['cover_image']);
         }

         $post->update([
            'title'=>$data['title'],
            'body'=>$data['body'],
            'cover_image'=>$data['image_path'],
            'pinned'=>$data['pinned']
        ]);



         $post->tag()->sync($data['tags']);

         return $post;
    }

    public function delete($post)
    {
        $this->isValidAction('delete',$post);
        
        return $post->delete();

    }

    public function loggedInUserPost($id)
    {    
       return $this->loggedInUser()->post()->where('id',$id)->get();
    }

}