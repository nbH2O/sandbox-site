<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Models\RenderToken;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\Uid\Ulid;

class RenderImage implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Model $model,
        public $payload
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): bool|Ulid
    {
        $ulid = Str::ulid();

        $response = Http::post(config('site.renderer_url'), [
            'payload' => $this->payload
        ]);
        $response = $response->json();

        if ($response['success'] == 1) {
            Storage::disk('public')->put($ulid.'.png', base64_decode($response['base64']));

            Storage::disk('public')->delete($this->model->render_ulid.'.png');

            $this->model->render_ulid = $ulid;
            $this->model->save();

            return $ulid;
        } else {
            return false;
        }
    }
}
