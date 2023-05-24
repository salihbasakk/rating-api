<?php

namespace App\Entity;

use App\Repository\VicoRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use JsonSerializable;

#[ORM\Entity(repositoryClass: VicoRepository::class)]
#[Index(columns: ['name'], name: 'name_idx')]
class Vico extends BaseEntity implements JsonSerializable
{
    #[ORM\Column(name: 'name', length: 64, nullable: false)]
    private string $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Vico
     */
    public function setName(string $name): Vico
    {
        $this->name = $name;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];
    }
}
