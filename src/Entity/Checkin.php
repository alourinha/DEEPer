<?php

namespace App\Entity;

class CheckIn
{
    public ?int $id;
    public ?int $productId;
    public ?string $name;
    public ?int $rating;
    public ?string $review;
    public ?string $submitted;
}