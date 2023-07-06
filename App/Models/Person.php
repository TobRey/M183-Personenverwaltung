<?php

namespace App\Models;

use App\Gateways\PersonGateway;
use App\Gateways\UserGateway;
use JsonSerializable;

class Person implements JsonSerializable
{
    private int $id = 0;
    private int $userId;
    private int $typeId;
    private string $firstname;
    private string $lastname;
    private bool $completed;

    public function __construct(int $id = 0)
    {
        $this->id = $id;
    }

    public static function all(): array
    {
        $gateway = new PersonGateway();
        $persons = [];

        $tmpPersons = $gateway->all();

        if ($tmpPersons) {
            while ($tmpPerson = $tmpPersons->fetch_assoc()) {
                $person = new Person();
                $person->id = $tmpPerson['id'];
                $person->userId = $tmpPerson['user_id'];
                $person->typeId = $tmpPerson['type_id'];
                $person->firstname = $tmpPerson['firstname'];
                $person->lastname = $tmpPerson['lastname'];
                $person->completed = $tmpPerson['completed'];

                $persons[] = $person;
            }
        }

        return $persons;
    }

    public static function findById(int $id): ?Person
    {
        $gateway = new PersonGateway();

        $tmpPerson = $gateway->findById($id);

        $person = null;

        if ($tmpPerson) {
            $person = new Person();
            $person->id = $tmpPerson['id'];
            $person->userId = $tmpPerson['user_id'];
            $person->typeId = $tmpPerson['type_id'];
            $person->firstname = $tmpPerson['firstname'];
            $person->lastname = $tmpPerson['lastname'];
            $person->completed = $tmpPerson['completed'];
        }

        return $person;
    }

    public static function findByUserId(int $userId): array
    {
        $gateway = new PersonGateway();
        $persons = [];

        $tmpPersons = $gateway->findByFields([
            'user_id' => $userId
        ]);

        if ($tmpPersons) {
            while ($tmpPerson = $tmpPersons->fetch_assoc()) {
                $person = new Person();
                $person->id = $tmpPerson['id'];
                $person->userId = $tmpPerson['user_id'];
                $person->typeId = $tmpPerson['type_id'];
                $person->firstname = $tmpPerson['firstname'];
                $person->lastname = $tmpPerson['lastname'];
                $person->completed = $tmpPerson['completed'];

                $persons[] = $person;
            }
        }

        return $person;
    }

    public static function findByTypeId(int $typeId): array
    {
        $gateway = new PersonGateway();
        $persons = [];

        $tmpPersons = $gateway->findByFields([
            'type_id' => $typeId
        ]);

        if ($tmpPersons) {
            while ($tmpPerson = $tmpPersons->fetch_assoc()) {
                $person = new Person();
                $person->id = $tmpPerson['id'];
                $person->userId = $tmpPerson['user_id'];
                $person->typeId = $tmpPerson['type_id'];
                $person->firstname = $tmpPerson['firstname'];
                $person->lastname = $tmpPerson['lastname'];
                $person->completed = $tmpPerson['completed'];

                $persons[] = $person;
            }
        }

        return $persons;
    }

    public function save()
    {
        $gateway = new PersonGateway();

        if (!$this->id) {
            $this->id = $gateway->insert([
                'user_id' => $this->userId,
                'type_id' => $this->typeId,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'completed' => $this->completed
            ]);
        } else {
            $gateway->update($this->id, [
                'user_id' => $this->userId,
                'type_id' => $this->typeId,
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'completed' => $this->completed
            ]);
        }
    }

    public function delete()
    {
        $gateway = new PersonGateway();
        $gateway->delete($this->id);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
    }

    public function isCompleted()
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed)
    {
        $this->completed = $completed;
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    public function getUser(): ?User
    {
        $gateway = new PersonGateway();

        $tmpUser = $gateway->getRelation($this->userId, "user", "1");
        $user = null;

        if ($tmpUser && $tmpUser->num_rows == 1) {
            $tmpUser = $tmpUser->fetch_assoc();
            $user = new User($tmpUser['id']);
            $user->setFirstname($tmpUser['firstname']);
            $user->setLastname($tmpUser['lastname']);
            $user->setEmail($tmpUser['email']);
        }

        return $user;
    }

    public function setTypeId(int $typeId)
    {
        $this->typeId = $typeId;
    }

    public function getType(): ?Type
    {
        $gateway = new PersonGateway();

        $tmpType = $gateway->getRelation($this->typeId, "type", "1");
        $type = null;

        if ($tmpType && $tmpType->num_rows == 1) {
            $tmpType = $tmpType->fetch_assoc();
            $type = new Type($tmpType['id']);
            $type->setLabel($tmpType['label']);
        }

        return $type;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'user' => $this->getUser(),
            'type' => $this->getType(),
            'firstname' => $this->firstname,
            'lastname' => $this->lastname
        ];
    }
}
