<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreateMediaObjectAction;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ApiResource(
 *     iri="http://schema.org/MediaObject",
 *     normalizationContext={
 *         "groups"={"media_object_read"}
 *     },
 *     collectionOperations={
 *         "post"={
 *             "controller"=CreateMediaObjectAction::class,
 *             "deserialize"=false,
 *             "validation_groups"={"Default", "media_object_create"},
 *             "openapi_context"={
 *                 "requestBody"={
 *                     "content"={
 *                         "multipart/form-data"={
 *                             "schema"={
 *                                 "type"="object",
 *                                 "properties"={
 *                                     "file"={
 *                                         "type"="string",
 *                                         "format"="binary"
 *                                     }
 *                                 }
 *                             }
 *                         }
 *                     }
 *                 }
 *             }
 *         },
 *         "get"
 *     },
 *     itemOperations={
 *         "get"
 *     }
 * )
 * @Vich\Uploadable
 * @ORM\EntityListeners({"App\Doctrine\MediaObjectListener"})
 */
class MediaObject
{
    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @ORM\Id
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ApiProperty(iri="http://schema.org/contentUrl")
     * @Groups({"media_object_read"})
     */
    public $contentUrl;

    /**
     * @var File|null
     *
     * @Assert\NotNull(groups={"media_object_create"})
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="filePath", mimeType="mimeType", size="fileSize",  originalName="originalName")
     */
    public $file;

    /**
     * @var string|null
     *
     * @ORM\Column(nullable=true)
     */
    public $filePath;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"media_object_read"})
     */
    private $mimeType;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"media_object_read"})
     */
    private $fileSize;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"media_object_read"})
     */
    private $originalName;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\VideoDetail", mappedBy="mediaObject", cascade={"persist", "remove"})
     * @Groups({"media_object_read"})
     */
    private $videoDetail;

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(?string $originalName): self
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function setFileSize(?int $fileSize): self
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    public function getVideoDetail(): ?VideoDetail
    {
        return $this->videoDetail;
    }

    public function setVideoDetail(?VideoDetail $videoDetail): self
    {
        $this->videoDetail = $videoDetail;

        // set (or unset) the owning side of the relation if necessary
        $newMediaObject = null === $videoDetail ? null : $this;
        if ($videoDetail->getMediaObject() !== $newMediaObject) {
            $videoDetail->setMediaObject($newMediaObject);
        }

        return $this;
    }

    public function originalMediaLocation()
    {
        $source = $this->file->getRealPath();
        if($source)
        {
            return str_replace(realpath('.'),'',$source);
        }
        return null;
    }
}