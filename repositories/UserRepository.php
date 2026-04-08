<?php

namespace Repositories;

use Models\User;

// Gère les requêtes SQL pour l'utilisateur
class UserRepository extends AbstractRepository {
    public function getDefaultUser(): ?User {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => DEFAULT_USER_ID]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new User(
            $row['email'],
            $row['phone'],
            $row['name'],
            $row['familyName'],
            $row['password'],
            $row['description'],
            $row['birthdate'],
            $row['github'],
            $row['linkedin'],
            $row['cv'],
            isset($row['id_picture']) ? (int) $row['id_picture'] : null,
            (int) $row['id']
        );
    }

    public function findByEmail(string $email): ?User {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new User(
            $row['email'],
            $row['phone'],
            $row['name'],
            $row['familyName'],
            $row['password'],
            $row['description'],
            $row['birthdate'],
            $row['github'],
            $row['linkedin'],
            $row['cv'],
            isset($row['id_picture']) ? (int) $row['id_picture'] : null,
            (int) $row['id']
        );
    }

    public function save(User $user, bool $updatePassword = false): bool {
        $sql = 'UPDATE user SET
                    email = :email,
                    phone = :phone,
                    name = :name,
                    familyName = :familyName,
                    description = :description,
                    birthdate = :birthdate,
                    github = :github,
                    linkedin = :linkedin,
                    cv = :cv';

        $params = [
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'name' => $user->getName(),
            'familyName' => $user->getFamilyName(),
            'description' => $user->getDescription(),
            'birthdate' => $user->getBirthdate(),
            'github' => $user->getGithub(),
            'linkedin' => $user->getLinkedin(),
            'cv' => $user->getCv(),
            'id' => $user->getId(),
        ];

        if ($updatePassword) {
            $sql .= ', password = :password';
            $params['password'] = $user->getPassword();
        }

        if ($user->getPictureId() !== null) {
            $sql .= ', id_picture = :picture_id';
            $params['picture_id'] = $user->getPictureId();
        }

        $sql .= ' WHERE id = :id';

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
