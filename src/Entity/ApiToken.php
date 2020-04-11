<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApiTokenRepository")
 */
class ApiToken
{
    /**
     * @ORM\Id() @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expireAt;

    /**
     * @ORM\Id() @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="apiTokens")
     */
    private $user;

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeInterface
    {
        return $this->expireAt;
    }

    public function setExpireAt(\DateTimeInterface $expireAt): self
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
