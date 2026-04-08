<?php

namespace Models;

// Représente une image
class Picture extends AbstractModel {
    public function __construct(
        private ?string $imagePath = null,
        private ?string $imageAlt = null,
        private ?int $projectId = null,
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    public function getImagePath(): ?string {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): void {
        $this->imagePath = $imagePath;
    }

    public function getImageAlt(): ?string {
        return $this->imageAlt;
    }

    public function setImageAlt(?string $imageAlt): void {
        $this->imageAlt = $imageAlt;
    }

    public function getProjectId(): ?int {
        return $this->projectId;
    }

    public function setProjectId(?int $projectId): void {
        $this->projectId = $projectId;
    }
}
