<?php

namespace App\Entity;

use App\Repository\RequestsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequestsRepository::class)]
class Requests
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\Column(length: 255)]
    private ?string $proof = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prescription = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'requests', targetEntity: User::class,)]
    #[ORM\JoinColumn(nullable: false, name:'user_request_id', referencedColumnName:'id')]
    private ?User $userRequest = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getProof(): ?string
    {
        return $this->proof;
    }

    public function setProof(string $proof): static
    {
        $this->proof = $proof;

        return $this;
    }

    public function getPrescription(): ?string
    {
        return $this->prescription;
    }

    public function setPrescription(?string $prescription): static
    {
        $this->prescription = $prescription;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUserRequest(): ?User
    {
        return $this->userRequest;
    }

    public function setUserRequest(?User $userRequest): static
    {
        $this->userRequest = $userRequest;

        return $this;
    }

   
}
