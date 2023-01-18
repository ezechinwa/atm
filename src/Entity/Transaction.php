<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['transaction'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user_transaction'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[Groups(['transaction_denomination'])]
    private ?Denomination $denomination = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column]
    private ?int $notes_dispensed = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timestamp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDenomination(): ?Denomination
    {
        return $this->denomination;
    }

    public function setDenomination(?Denomination $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getNotesDispensed(): ?int
    {
        return $this->notes_dispensed;
    }

    public function setNotesDispensed(int $notes_dispensed): self
    {
        $this->notes_dispensed = $notes_dispensed;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }
}
