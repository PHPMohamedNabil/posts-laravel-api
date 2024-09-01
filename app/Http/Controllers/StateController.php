<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Cache;
use App\Models\Post;
use App\Models\User;


class StateController extends Controller
{


   public function __invoke()
   {
        $data = [
        	    'message'=>'done',
                'users'=>User::count(),
                'posts'=>Post::count(),
                'zero_post_user'=> User::doesntHave('post')->count()
   	    ];

     	$stats = Cache::remember('stats', now()->addMinutes(10), function () use($data) {
            return $data;
        });

        if (Cache::has('states')) {
            $stats = Cache::get('states');
        } else {
            $stats = [
                'users' => User::count(),
                'posts' => Post::count(),
                'zero_post_user' => User::doesntHave('post')->count(),
            ];

         
            Cache::put('states', $stats, now()->addMinutes(60));
        }

   	    return response()->json($stats,200);
   }

}