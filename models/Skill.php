<?php

namespace Models;

// Représente une compétence
class Skill extends AbstractModel{
    public function __construct(
        private ?string $name = null,
        private ?int $level = null,
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    public function getName(): ?string{
        return $this->name;
    }

    public function setName(?string $name): void{
        $this->name = $name;
    }

    public function getLevel(): ?int{
        return $this->level;
    }

    public function setLevel(?int $level): void{
        $this->level = $level;
    }

    public function validate(): array{
        $errors = [];

        if ($this->name === null || trim($this->name) === '') {
            $errors[] = 'Le nom de la compétence est obligatoire.';
        }

        if ($this->name !== null && mb_strlen(trim($this->name)) > 100) {
            $errors[] = 'Le nom de la compétence ne doit pas dépasser 100 caractères.';
        }

        if ($this->level === null || $this->level < 1 || $this->level > 100) {
            $errors[] = 'Le niveau doit être compris entre 1 et 100.';
        }

        return $errors;
    }
}
