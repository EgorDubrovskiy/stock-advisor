<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log;

/**
 * Class CropAvatarJob
 * @package App\Jobs
 */
class CropAvatarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $avatar;

    /**
     * CropAvatarJob constructor.
     * @param $avatar
     */
    public function __construct(string $avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $avatarsPath = public_path('storage/app/avatars/');
        $croppedAvatarsPath = public_path('storage/app/avatars/cropped');
        $imageInfo = getimagesize($avatarsPath . $this->avatar);
        $imageWidth = $imageInfo[0] > 200 ? 200 : $imageInfo[0];
        $imageHeight = $imageInfo[1] > 200 ? 200 : $imageInfo[1];
        $imageExtension = $imageInfo['mime'];

        switch ($imageExtension) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($avatarsPath . $this->avatar);
                $imageCropped = imagecrop($image, ['x' => 0, 'y' => 0, 'width' => $imageWidth, 'height' => $imageHeight]);
                imagejpeg($imageCropped, $croppedAvatarsPath . $this->avatar);
                imagedestroy($image);
                break;

            case 'image/png':
                $image = imagecreatefrompng($avatarsPath . $this->avatar);
                $imageCropped = imagecrop($image, ['x' => 0, 'y' => 0, 'width' => $imageWidth, 'height' => $imageHeight]);
                imagepng($imageCropped, $croppedAvatarsPath . $this->avatar);
                imagedestroy($image);
                break;

            default:
                Log::error("Received unsupported image type: " . $imageExtension);
                break;
        }
    }
}
