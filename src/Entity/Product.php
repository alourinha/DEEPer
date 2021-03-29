<?php

namespace App\Entity;

class Product
{
    public ?int $id;
    public string $title;
    public string $image_path;
    public string $description;
    public ?float $average_rating;
    public ?string $glutten_free;
    public ?string $has_filling;
    public ?string $keywords;
    /** @var CheckIn[] */
    private  array $checkins = [];

    public function addCheckin(CheckIn $checkIn): void
    {
        $this->checkins[] = $checkIn;
    }

    public function getCheckins(): array
    {
        return $this->checkins;
    }

}