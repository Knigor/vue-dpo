<?php

declare(strict_types=1);

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document(collection: 'resume')]
class Resume
{
    #[ODM\Id]
    private ?string $id = null;

    #[ODM\Field(type: 'string')]
    private string $name;

    #[ODM\Field(type: 'string')]
    private string $profession;

    #[ODM\Field(type: 'int')]
    private int $age;

    #[ODM\Field(type: 'string')]
    private string $status; // Новый, Назначено собеседование, Принят, Отказ

    #[ODM\Field(type: 'string')]
    private string $photo; // URL или путь к фото

    public function __construct(string $name, string $profession, int $age, string $status, string $photo)
    {
        $this->name = $name;
        $this->profession = $profession;
        $this->age = $age;
        $this->status = $status;
        $this->photo = $photo;
    }

    // Геттеры и сеттеры
    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getProfession(): string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): void
    {
        $this->profession = $profession;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }
}
