<?php 

namespace Src\Entity\Category;

final class Category {
// name ==> "UNIQUE" en la Base de Datos
    public function __construct(
        private readonly ?int $id,
        private string $name,
        private string $description,
        private bool $deleted
        ){}
//Evaluar si $description es necesario 

    public static function create(string $name, string $description): self
    {
        return new self(null, $name, $description, false);
    }

    public function modify(string $name, string $description): void
    {
        $this->name = $name;
        $this->description = $description;
    }
    

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
    
    public function description(): string
    {
        return $this->description;
    }
    
// Consulta Estado 'DELETED'
    public function isDeleted(): int
    {
        return $this->deleted ? 1 : 0;
    }

// Cambia a Estado 'DELETED'
    public function delete(): void
    {
        $this->deleted = true;
    }
}