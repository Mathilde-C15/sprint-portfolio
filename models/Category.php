<?php

namespace Models;

// Représente une catégorie
class Category extends AbstractModel {
    public function __construct( private ?string $name = null, ?int $id = null) {
        parent::__construct($id);
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(?string $name): void {
        $this->name = $name;
    }

    public function validate(): array {
        $errors = [];

        if ($this->name === null || trim($this->name) === '') {
            $errors[] = 'Le nom de la catégorie est obligatoire.';
        }

        if ($this->name !== null && mb_strlen(trim($this->name)) > 100) {
            $errors[] = 'Le nom de la catégorie ne doit pas dépasser 100 caractères.';
        }

        return $errors;
    }
}
