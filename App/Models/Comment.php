<?php

namespace App\Models;

class Comment extends Model
{
    protected ?int $id = null;
    protected ?int $postId = null;
    protected ?int $userId = null;
    protected ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getPostId(): ?int
    {
        return $this->postId;
    }
    public function getUserId(): ?int
    {
        return $this->userId;
    }
    public function getContent(): ?string
    {
        return $this->content;
    }
    public function setPostId(?int $postId): void
    {
        $this->postId = $postId;
    }
    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

}