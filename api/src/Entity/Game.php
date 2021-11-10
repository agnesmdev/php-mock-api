<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource]
class Game
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    public string $name;

    #[ORM\Column(type: 'date')]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    public ?\DateTimeInterface $launchDate = null;

    #[ORM\ManyToOne(targetEntity: 'Console', inversedBy: 'games')]
    #[Assert\NotNull]
    public ?Console $console = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
