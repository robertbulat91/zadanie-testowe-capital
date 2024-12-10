<?php

namespace App\Entity;

use App\Repository\RefreshTokenRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RefreshTokenRepository::class)]
class RefreshTokens
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $refreshTokenId = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $tokenId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefreshTokenId(): ?string
    {
        return $this->refreshTokenId;
    }

    public function setRefreshTokenId(string $refreshTokenId): static
    {
        $this->refreshTokenId = $refreshTokenId;

        return $this;
    }

    public function getTokenId(): ?string
    {
        return $this->tokenId;
    }

    public function setTokenId(string $tokenId): static
    {
        $this->tokenId = $tokenId;

        return $this;
    }
}
