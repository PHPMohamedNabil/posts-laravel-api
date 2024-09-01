<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class getData implements ShouldQueue
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
       // Make HTTP request to the specified endpoint
        $response = Http::get('https://randomuser.me/api/');

        // Check if the request was successful
        if ($response->successful()) {
            // Extract the results object from the response
            $results = $response->json('results');

            // Log the results
            Log::info('Fetched Results:', $results);
        } else {
            // Log the error response
            Log::error('Failed to fetch data. Status code: ' . $response->status());
        }
    }
}
