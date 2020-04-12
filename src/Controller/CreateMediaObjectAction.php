<?php

namespace App\Controller;

use App\Entity\MediaObject;
use App\Entity\VideoDetail;
use Doctrine\ORM\EntityManagerInterface;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CreateMediaObjectAction
{
    private  $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Request $request): MediaObject
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $mediaObject = new MediaObject();
        $mediaObject->file = $uploadedFile;

        $this->callServices($uploadedFile, $mediaObject);

        return $mediaObject;
    }

    private function callServices(UploadedFile $file, MediaObject $media): void
    {
        $mimeType = explode('/', $file->getClientMimeType());

        switch ($mimeType[0]) {
            case 'video':
                $ffprobe = FFProbe::create();

                $duration = $ffprobe
                    ->streams($file)
                    ->videos()
                    ->first();
                dump($duration);

                $video_detail = new VideoDetail();
                $video_detail->setMediaObject($media)
                    ->setDuration($duration->get('duration'))
                    ->setDimensions([$duration->get('width'), $duration->get('height')]);

                $this->em->persist($video_detail);

                break;
        }
    }
}