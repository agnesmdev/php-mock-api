<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [
            "security" => "is_granted('ROLE_ADMIN')"
        ]
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['game:item']]
        ],
        'patch' => [
            "security" => "is_granted('ROLE_ADMIN')"
        ],
        'delete' => [
            "security" => "is_granted('ROLE_ADMIN')"
        ]
    ],
    subresourceOperations: [
        'api_reviews_game_get_subresource' => [
            'method' => 'GET',
            'path' => '/games/{id}/reviews'
        ]
    ],
    attributes: [
        "security" => "is_granted('ROLE_USER') and object.owner == user"
    ],
    normalizationContext: ['groups' => ['game:all']]
)]
class Game
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['console:item', 'game:item', 'game:all', 'review:item'])]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    #[Assert\NotBlank]
    #[Groups(['console:item', 'game:item', 'game:all', 'review:item'])]
    public string $name;

    #[ORM\Column(type: 'date')]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[Groups(['console:item', 'game:item', 'game:all'])]
    public ?\DateTimeInterface $launchDate = null;

    #[ORM\ManyToOne(targetEntity: 'Console', inversedBy: 'games')]
    #[Assert\NotNull]
    #[Groups(['game:item', 'game:all'])]
    public ?Console $console = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: 'Review', cascade: ['persist', 'remove'])]
    #[Groups(['game:item'])]
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
