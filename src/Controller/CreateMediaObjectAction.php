<?php

namespace App\Controller;

use App\Entity\MediaObject;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CreateMediaObjectAction
{
    public function __invoke(Request $request): MediaObject
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

//        $ffprobe = FFProbe::create();
//
//        $duration = $ffprobe
//            ->streams($uploadedFile)
//            ->videos()
//            ->first();
//        dump($duration);


        $mediaObject = new MediaObject();
        $mediaObject->file = $uploadedFile;

        return $mediaObject;
    }
}