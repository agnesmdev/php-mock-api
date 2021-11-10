<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[UniqueEntity(
    fields: ['game', 'gamer'],
    message: 'This gamer has already done a review of this game'
)]
#[ApiResource]
class Review
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $gameTime = 0;

    #[ORM\Column(type: 'decimal', precision: 3, scale: 1)]
    #[Assert\NotNull]
    public string $note;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Assert\Length(min: 300, max: 3000)]
    public ?string $comment;

    #[ORM\ManyToOne(targetEntity: 'Gamer', inversedBy: 'reviews')]
    #[Assert\NotNull]
    public ?Gamer $gamer = null;

    #[ORM\ManyToOne(targetEntity: 'Game', inversedBy: 'reviews')]
    #[Assert\NotNull]
    public ?Game $game = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
