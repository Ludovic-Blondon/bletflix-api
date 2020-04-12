<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\VideoDetailRepository")
 */
class VideoDetail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     * @Groups({"media_object_read"})
     */
    private $dimensions = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"media_object_read"})
     */
    private $duration;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MediaObject", inversedBy="videoDetail", cascade={"persist", "remove"})
     */
    private $mediaObject;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"media_object_read"})
     */
    private $codec;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDimensions(): ?array
    {
        return $this->dimensions;
    }

    public function setDimensions(array $dimensions): self
    {
        $this->dimensions = $dimensions;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getMediaObject(): ?MediaObject
    {
        return $this->mediaObject;
    }

    public function setMediaObject(?MediaObject $mediaObject): self
    {
        $this->mediaObject = $mediaObject;

        return $this;
    }

    public function getCodec(): ?string
    {
        return $this->codec;
    }

    public function setCodec(string $codec): self
    {
        $this->codec = $codec;

        return $this;
    }
}
