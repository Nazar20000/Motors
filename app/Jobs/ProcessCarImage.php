<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ProcessCarImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;
    public $tries = 3;

    protected $imagePath;
    protected $carId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $imagePath, int $carId)
    {
        $this->imagePath = $imagePath;
        $this->carId = $carId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $fullPath = Storage::path($this->imagePath);
            
            if (!file_exists($fullPath)) {
                Log::error("Image file not found: {$this->imagePath}");
                return;
            }

            // Create different image sizes
            $this->createThumbnail($fullPath);
            $this->createMedium($fullPath);
            $this->createLarge($fullPath);
            
            Log::info("Image processed successfully for car ID: {$this->carId}");
            
        } catch (\Exception $e) {
            Log::error("Error processing image for car ID {$this->carId}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create thumbnail
     */
    private function createThumbnail(string $fullPath): void
    {
        $thumbnailPath = str_replace('.', '_thumb.', $this->imagePath);
        $thumbnailFullPath = Storage::path($thumbnailPath);
        
        $image = Image::make($fullPath);
        $image->fit(300, 200, function ($constraint) {
            $constraint->upsize();
        });
        $image->save($thumbnailFullPath, 80);
    }

    /**
     * Create medium size
     */
    private function createMedium(string $fullPath): void
    {
        $mediumPath = str_replace('.', '_medium.', $this->imagePath);
        $mediumFullPath = Storage::path($mediumPath);
        
        $image = Image::make($fullPath);
        $image->fit(800, 600, function ($constraint) {
            $constraint->upsize();
        });
        $image->save($mediumFullPath, 85);
    }

    /**
     * Create large size
     */
    private function createLarge(string $fullPath): void
    {
        $largePath = str_replace('.', '_large.', $this->imagePath);
        $largeFullPath = Storage::path($largePath);
        
        $image = Image::make($fullPath);
        $image->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->save($largeFullPath, 90);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Image processing job failed for car ID {$this->carId}: " . $exception->getMessage());
    }
} 