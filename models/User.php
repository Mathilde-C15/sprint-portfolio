<?php

namespace Models;

class User {
    private int $id;
    private int $phone;
    private string $email;
    private string $name;
    private string $familyName;
    private string $password;
    private string $description;
    private date $birthdate;
    private string $github;
    private string $linkedin;
    private string $cv;
    private int $idPicture;

    public function __construct(int $id, 
                                int $phone, 
                                string $email,
                                string $name, 
                                string $familyName, 
                                string $password, 
                                string $description, 
                                date $birthdate, 
                                string $github, 
                                string $linkedin, 
                                string $cv) {
        $this->id = $id;
        $this->phone = $phone;
        $this->email = $email;
        $this->name = $name;
        $this->familyName = $familyName;
        $this->password = $password;
        $this->description = $description;
        $this->birthdate = $birthdate;
        $this->github = $github;
        $this->linkedin = $linkedin;
        $this->cv = $cv;
    }

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getPhone(): int {
        return $this->phone;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getFamilyName(): string {
        return $this->familyName;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getBirthdate(): date {
        return $this->birthdate;
    }

    public function getGithub(): string {
        return $this->github;
    }

    public function getLinkedin(): string {
        return $this->linkedin;
    }

    public function getCv(): string {
        return $this->cv;
    }

    // Setters
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setPhone(int $phone): void {
        $this->phone = $phone;
    }

    public function setEmail(string $email): void{
        $this->email = $email;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setFamilyName(string $familyName): void {
        $this->familyName = $familyName;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setBirthdate($birthdate): void {
        $this->birthdate = $birthdate;
    }

    public function setGithub(string $github): void {
        $this->github = $github;
    }

    public function setLinkedin(string $linkedin): void {
        $this->linkedin = $linkedin;
    }

    public function setCv(string $cv): void {
        $this->cv = $cv;
    }
}