<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource]
class Player
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    #[Assert\NotBlank]
    public string $username;

    #[ORM\Column(unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\GreaterThan(10)]
    public ?int $age = null;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: 'Review', cascade: ['persist', 'remove'])]
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
