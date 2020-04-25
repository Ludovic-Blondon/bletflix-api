<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\WorkRepository")
 */
class Work
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get_prod"})
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Production", inversedBy="work", cascade={"persist", "remove"})
     */
    private $production;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Season", inversedBy="works")
     * @Groups({"get_prod"})
     */
    private $season;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MediaObject", cascade={"persist", "remove"})
     * @Groups({"get_prod"})
     */
    private $mediaObject;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"get_prod"})
     */
    private $languages = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"get_prod"})
     */
    private $subtitles = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"get_prod"})
     */
    private $country;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"get_prod"})
     */
    private $number;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduction(): ?Production
    {
        return $this->production;
    }

    public function setProduction(?Production $production): self
    {
        $this->production = $production;

        return $this;
    }

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): self
    {
        $this->season = $season;

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

    public function getLanguages(): ?array
    {
        return $this->languages;
    }

    public function setLanguages(array $languages): self
    {
        $this->languages = $languages;

        return $this;
    }

    public function getSubtitles(): ?array
    {
        return $this->subtitles;
    }

    public function setSubtitles(?array $subtitles): self
    {
        $this->subtitles = $subtitles;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): self
    {
        $this->number = $number;

        return $this;
    }
}
