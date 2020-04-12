<?php

namespace App\Controller;

use App\Entity\MediaObject;
use App\Entity\VideoDetail;
use Doctrine\ORM\EntityManagerInterface;
use FFMpeg\FFProbe;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CreateMediaObjectAction
{
    private  $em;

    /**
     * CreateMediaObjectAction constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Request $request
     * @return MediaObject
     */
    public function __invoke(Request $request): MediaObject
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile)
        {
            throw new BadRequestHttpException('"file" is required');
        }

        $mediaObject = new MediaObject();
        $mediaObject->file = $uploadedFile;

        $this->callServices($uploadedFile, $mediaObject);

        return $mediaObject;
    }

    /**
     * @param UploadedFile $file
     * @param MediaObject $media
     */
    private function callServices(UploadedFile $file, MediaObject $media): void
    {
        $mimeType = explode('/', $file->getClientMimeType());

        switch ($mimeType[0])
        {
            case 'video':
                $ffprobe = FFProbe::create();

                $first = $ffprobe
                    ->streams($file)
                    ->videos()
                    ->first()
                ;

                dump($ffprobe->format($file));

                $video_detail = new VideoDetail();
                $video_detail->setMediaObject($media)
                    ->setDuration($this->getDuration($ffprobe, $file))
                    ->setDimensions($this->getDimensions($first))
                    ->setCodec($this->getCodec($first))
                ;

                $this->em->persist($video_detail);
                break;
        }
    }

    private function getDuration(FFProbe $ffprobe, $file): string
    {
        $duration = $ffprobe->streams($file)->videos()->first()->get('duration');

        if (empty($duration))
        {
            $duration = $ffprobe->format($file)->get('duration');
        }

        if (empty($duration))
        {
            $duration = "undefined";
        }

        return $duration;
    }

    private function getDimensions($first): array
    {
        $dimensions = array();

        $width = $first->get('width') ?? 0;
        $height = $first->get('height') ?? 0;

        array_push($dimensions, $width);
        array_push($dimensions, $height);

        return$dimensions;
    }

    private function getCodec($first): string
    {
        $codec = $first->get('codec_name');

        if (empty($codec))
        {
            $codec = "undefined";
        }

        return $codec;
    }
}