<?php

namespace App\Jobs;

use App\Models\Image;
use App\UpstreamStorage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imagick;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $image;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $jpegDirectory = (new TemporaryDirectory())->create();

        try {
            $jpegPath = $this->convertToJpeg($jpegDirectory);

            $this->image
                ->addMedia($jpegPath)
                ->withResponsiveImages()
                ->toMediaCollection();

        } finally {
            $jpegDirectory->delete();
        }
    }

    private function convertToJpeg(TemporaryDirectory $destinationDirectory)
    {
        $jpegPath = $destinationDirectory->path("{$this->image->id}.jpg");

        $jpegImage = new Imagick();
        $jpegImage->readImageBlob(UpstreamStorage::get($this->image->path));
        $jpegImage->setImageFormat('jpg');

        file_put_contents($jpegPath, $jpegImage);

        return $jpegPath;
    }
}
