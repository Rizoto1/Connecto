<?php

namespace App\Models;

use DateTime;
use Framework\Core\IIdentity;
use Framework\Core\Model;

class User extends Model implements IIdentity
{

    protected ?int $id = null;
    protected ?string $name = null;
    protected ?string $passwordHash = null;
    protected ?string $email = null;
    protected ?DateTime $createdAt = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setPasswordHash(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }
}