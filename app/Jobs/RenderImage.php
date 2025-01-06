<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Models\RenderToken;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;

class RenderImage implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Model $model,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ulid = Str::ulid();
        RenderToken::insert([
            'token' => $ulid,
            'renderable_id' => 1,
            'renderable_type' => get_class($this->model),
            'expires_at' => now()->addMinutes(2)
        ]);

        $response = Http::post(config('site.renderer_url'), [
            'json' => json_encode([
                'hi' => 'hi'
            ]),
            'token' => $ulid,
            'callback' => url(config('site.renderer_callback')),
        ]);
    }
}
