<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'patch', 'delete'],
    subresourceOperations: [
        'api_reviews_game_get_subresource' => [
            'method' => 'GET',
            'path' => '/games/{id}/reviews'
        ]
    ]
)]
class Game
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['console:item'])]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    #[Assert\NotBlank]
    #[Groups(['console:item'])]
    public string $name;

    #[ORM\Column(type: 'date')]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    public ?\DateTimeInterface $launchDate = null;

    #[ORM\ManyToOne(targetEntity: 'Console', inversedBy: 'games')]
    #[Assert\NotNull]
    public ?Console $console = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: 'Review', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    public iterable $reviews;

    #[Pure]
    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
