<?php

namespace Models;

// Représente l'utilisateur
class User extends AbstractModel{
    public function __construct(
        private ?string $email = null,
        private ?string $phone = null,
        private ?string $name = null,
        private ?string $familyName = null,
        private ?string $password = null,
        private ?string $description = null,
        private ?string $birthdate = null,
        private ?string $github = null,
        private ?string $linkedin = null,
        private ?string $cv = null,
        private ?int $pictureId = null,
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(?string $email): void { $this->email = $email; }
    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(?string $phone): void { $this->phone = $phone; }
    public function getName(): ?string { return $this->name; }
    public function setName(?string $name): void { $this->name = $name; }
    public function getFamilyName(): ?string { return $this->familyName; }
    public function setFamilyName(?string $familyName): void { $this->familyName = $familyName; }
    public function getPassword(): ?string { return $this->password; }
    public function setPassword(?string $password): void { $this->password = $password; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): void { $this->description = $description; }
    public function getBirthdate(): ?string { return $this->birthdate; }
    public function setBirthdate(?string $birthdate): void { $this->birthdate = $birthdate; }
    public function getGithub(): ?string { return $this->github; }
    public function setGithub(?string $github): void { $this->github = $github; }
    public function getLinkedin(): ?string { return $this->linkedin; }
    public function setLinkedin(?string $linkedin): void { $this->linkedin = $linkedin; }
    public function getCv(): ?string { return $this->cv; }
    public function setCv(?string $cv): void { $this->cv = $cv; }
    public function getPictureId(): ?int { return $this->pictureId; }
    public function setPictureId(?int $pictureId): void { $this->pictureId = $pictureId; }

    public function validate(bool $checkPassword = false): array{
        $errors = [];

        if ($this->name === null || trim($this->name) === '') {
            $errors[] = 'Le prénom est obligatoire.';
        }

        if ($this->familyName === null || trim($this->familyName) === '') {
            $errors[] = 'Le nom est obligatoire.';
        }

        if ($this->email !== null && $this->email !== '' && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'L\'email n\'est pas valide.';
        }

        if ($this->github !== null && $this->github !== '' && !filter_var($this->github, FILTER_VALIDATE_URL)) {
            $errors[] = 'Le lien GitHub n\'est pas valide.';
        }

        if ($this->linkedin !== null && $this->linkedin !== '' && !filter_var($this->linkedin)) {
            $errors[] = 'Le lien LinkedIn n\'est pas valide.';
        }

        if ($checkPassword && ($this->password === null || mb_strlen($this->password) < 8)) {
            $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
        }

        return $errors;
    }
}
