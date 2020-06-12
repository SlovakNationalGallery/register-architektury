<?php

namespace App\Jobs;

use App\Models\Image;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $jpegImage->readImageBlob($this->getContent());
        $jpegImage->setImageFormat('jpg');

        file_put_contents($jpegPath, $jpegImage);

        return $jpegPath;
    }

    private function getContent()
    {
        $sourcePath = Str::of($this->image->path)->replace('\\', '/');
        $upstreamStorage = Storage::disk(Config('filesystems.upstream'));

        if (Str::startsWith($sourcePath, '//AA20/OddArch/AA20 dáta/')) {
            return $upstreamStorage->get($sourcePath->replaceFirst('//AA20/OddArch/AA20 dáta/',''));
        }

        if (Str::startsWith($sourcePath, 'S:/AA20 dáta/')) {
            return $upstreamStorage->get($sourcePath->replaceFirst('S:/AA20 dáta/',''));
        }

        throw new Exception("Unrecognized source path {$this->image->path} for image ID {$this->image->id}");
    }
}
