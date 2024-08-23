<?php

declare(strict_types=1);

namespace app\dto;

use app\models\Author;

final readonly class TopAuthorDto
{
    public function __construct(public Author $author, public int $booksCount)
    {
    }
}
