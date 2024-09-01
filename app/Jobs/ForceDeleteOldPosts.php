<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use App\Models\Post;

class ForceDeleteOldPosts implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Calculate the date 30 days ago from now
        $date = Carbon::now()->subDays(30);

        // Get all posts that have been softly deleted and are older than 30 days
        $oldPosts = Post::onlyTrashed()->where('deleted_at', '<=', $date)->get();

        // Force delete them
        foreach ($oldPosts as $post) {
            $post->forceDelete();
        }
    }
}
