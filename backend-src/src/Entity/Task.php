<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=140)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=300, nullable=true)
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="smallint", unique=true)
     */
    private int $position_index;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPositionIndex(): ?int
    {
        return $this->position_index;
    }

    public function setPositionIndex(int $position_index): self
    {
        $this->position_index = $position_index;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'position_index' => $this->position_index
        ];
    }
}
