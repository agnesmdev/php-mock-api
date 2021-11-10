<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource]

class Gamer
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    public string $username;

    #[ORM\Column(unique: true)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\GreaterThan(10)]
    public ?int $age = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}