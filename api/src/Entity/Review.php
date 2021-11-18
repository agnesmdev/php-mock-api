<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[UniqueEntity(
    fields: ['game', 'player'],
    message: 'This player has already done a review of this game'
)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['review:item']]
        ],
        'patch' => [
            "security" => "is_granted('ROLE_ADMIN') or object.player.email == user.email"
        ],
        'delete' => [
            "security" => "is_granted('ROLE_ADMIN') or object.player.email == user.email"
        ]
    ],
    attributes: [
        "security" => "is_granted('ROLE_USER')"
    ],
    normalizationContext: ['groups' => ['review:all']]
)]
class Review
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['game:item', 'player:item', 'review:item', 'review:all'])]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\GreaterThanOrEqual(0)]
    #[Groups(['game:item', 'player:item', 'review:item'])]
    public int $gameTime = 0;

    #[ORM\Column(type: 'decimal', precision: 3, scale: 1)]
    #[Assert\NotBlank]
    #[Groups(['game:item', 'player:item', 'review:item', 'review:all'])]
    public string $note;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Assert\Length(min: 300, max: 3000)]
    #[Groups(['game:item', 'player:item', 'review:item'])]
    public ?string $comment;

    #[ORM\ManyToOne(targetEntity: 'Player', inversedBy: 'reviews')]
    #[Assert\NotNull]
    #[Groups(['game:item', 'review:item'])]
    public ?Player $player = null;

    #[ORM\ManyToOne(targetEntity: 'Game', inversedBy: 'reviews')]
    #[Assert\NotNull]
    #[Groups(['player:item', 'review:item'])]
    public ?Game $game = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
