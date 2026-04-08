<?php

namespace Models;

// Représente un projet
class Project extends AbstractModel
{
    private array $skills = [];
    private array $pictures = [];
    private ?Category $category = null;
    private ?Picture $picture = null;

    public function __construct(
        private ?string $name = null,
        private ?string $description = null,
        private ?int $primarySkillId = null,
        private ?int $categoryId = null,
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(?string $name): void {
        $this->name = $name;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    public function getPrimarySkillId(): ?int {
        return $this->primarySkillId;
    }

    public function setPrimarySkillId(?int $primarySkillId): void {
        $this->primarySkillId = $primarySkillId;
    }

    public function getCategoryId(): ?int {
        return $this->categoryId;
    }

    public function setCategoryId(?int $categoryId): void {
        $this->categoryId = $categoryId;
    }

    public function getSkills(): array {
        return $this->skills;
    }

    public function setSkills(array $skills): void{
     $this->skills = $skills;
    }


    public function getPictures(): array{
        return $this->pictures;
    }

    public function setPictures(array $pictures): void{
        $this->pictures = $pictures;

        if ($this->picture === null && !empty($pictures) && $pictures[0] instanceof Picture) {
            $this->picture = $pictures[0];
        }
    }

    public function getCategory(): ?Category{
        return $this->category;
    }

    public function setCategory(?Category $category): void{
        $this->category = $category;
    }

    public function getPicture(): ?Picture{
        return $this->picture;
    }

    public function setPicture(?Picture $picture): void{
        $this->picture = $picture;
    }

    public function validate(): array{
        $errors = [];

        if ($this->name === null || trim($this->name) === '') {
            $errors[] = 'Le nom du projet est obligatoire.';
        }

        if ($this->name !== null && mb_strlen(trim($this->name)) > 100) {
            $errors[] = 'Le nom du projet ne doit pas dépasser 100 caractères.';
        }

        if ($this->description === null || trim(strip_tags($this->description)) === '') {
            $errors[] = 'La description du projet est obligatoire.';
        }

        if ($this->categoryId === null) {
            $errors[] = 'La catégorie du projet est obligatoire.';
        }

        if ($this->primarySkillId === null) {
            $errors[] = 'Choisissez au moins une compétence principale.';
        }

        return $errors;
    }
}
