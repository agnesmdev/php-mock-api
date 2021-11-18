<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['player:item']]
        ],
        'patch',
        'delete'
    ],
    subresourceOperations: [
        'api_reviews_player_get_subresource' => [
            'method' => 'GET',
            'path' => '/players/{id}/reviews',
            'normalization_context' => ['groups' => ['review:player']]
        ]
    ]
)]
class Player
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['player:item', 'player:all', 'review:item'])]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    #[Assert\NotBlank]
    #[Groups(['player:item', 'player:all', 'review:item'])]
    public string $username;

    #[ORM\Column(unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups('player:item')]
    public string $email;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\GreaterThan(10)]
    #[Groups('player:item')]
    public ?int $age = null;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: 'Review', cascade: ['persist', 'remove'])]
    #[Groups('player:item')]
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
