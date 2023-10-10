<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadImageToS3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $imagePath;

    /**
     * Create a new job instance.
     */
    public function __construct($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $s3 = Storage::disk('s3');
        $imageName = basename($this->imagePath);
        $s3Path = 'uploads/' . $imageName;
        $uploaded = $s3->put($s3Path, file_get_contents($this->imagePath), 'public');
        if ($uploaded) {
            Log::info('Image uploaded to S3: ' . $s3Path);
        } else {
            Log::error('Failed to upload image to S3.');
        }
    }
}
