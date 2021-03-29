<?php

namespace App\Entity;

class User
{
    public ?int $id;
    public string $name;
    public string $emailAddress;
    public string $password;
    public ?string $isAdmin;
}
