<?php

namespace App\Models;

use Framework\Core\Model;

class Like extends Model
{
    protected ?int $id = null;
    protected ?int $userId = null;
    protected ?int $postId = null;
}