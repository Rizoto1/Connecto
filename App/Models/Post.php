<?php

namespace App\Models;

use Framework\Core\Model;

/**
 * Post model representing a simple user post.
 * Default conventions: table name "posts", primary key "id".
 */
class Post extends Model
{
    // DB columns according to DefaultConventions: id, title, content, createdAt
    protected ?int $id = null;
    protected ?string $title = null;
    protected ?string $content = null;
    protected ?string $image = null; // Add image path/filename
    protected ?string $createdAt = null; // DATETIME stored as string
    protected ?int $userId = null; // author of the post


    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getContent(): ?string
    {
        return $this->content;
    }
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    // Setters

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }
    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }
}
