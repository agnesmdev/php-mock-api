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
    itemOperations: [
        'get' => [
            'normalizationContext' => ['groups' => ['console:item']]
        ],
        'patch',
        'delete'
    ],
    subresourceOperations: [
        'api_games_console_get_subresource' => [
            'method' => 'GET',
            'path' => '/consoles/{id}/games'
        ]
    ],
    normalizationContext: ['groups' => ['console:all']]
)]
class Console
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['console:item', 'console:all'])]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    #[Assert\NotBlank]
    #[Groups(['console:item', 'console:all'])]
    public string $name;

    #[ORM\Column(type: 'date')]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[Groups('console:item')]
    public ?\DateTimeInterface $launchDate = null;

    #[ORM\OneToMany(mappedBy: 'console', targetEntity: 'Game', cascade: ['persist', 'remove'])]
    #[ApiSubresource(maxDepth: 1)]
    #[Groups('console:item')]
    public iterable $games;

    #[Pure]
    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
