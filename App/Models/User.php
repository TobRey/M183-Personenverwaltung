<?php

namespace App\Models;

use App\Gateways\UserGateway;
use JsonSerializable;

class User implements JsonSerializable
{
    private int $id = 0;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $password;
    private string $token;

    public function __construct(int $id = 0)
    {
        $this->id = $id;
    }

    public static function all(): array
    {
        $gateway = new UserGateway();
        $users = [];

        $tmpUsers = $gateway->all();

        if ($tmpUsers) {
            while ($tmpUser = $tmpUsers->fetch_assoc()) {
                $user = new User();
                $user->id = $tmpUser['id'];
                $user->firstname = $tmpUser['firstname'];
                $user->lastname = $tmpUser['lastname'];
                $user->email = $tmpUser['email'];
                $user->password = $tmpUser['password'];

                $users[] = $user;
            }
        }

        return $users;
    }

    public static function findById(int $id): ?User
    {
        $gateway = new UserGateway();

        $tmpUser = $gateway->findById($id);

        $user = null;

        if ($tmpUser) {
            $user = new User();
            $user->id = $tmpUser['id'];
            $user->firstname = $tmpUser['firstname'];
            $user->lastname = $tmpUser['lastname'];
            $user->email = $tmpUser['email'];
            $user->password = $tmpUser['password'];
        }

        return $user;
    }

    public static function findByEmail(string $email): ?User
    {
        $gateway = new UserGateway();
        $user = null;

        $tmpUser = $gateway->findByFields([
            'email' => $email
        ]);

        if ($tmpUser && $tmpUser->num_rows == 1) {
            $tmpUser = $tmpUser->fetch_assoc();
            $user = new User();
            $user->id = $tmpUser['id'];
            $user->firstname = $tmpUser['firstname'];
            $user->lastname = $tmpUser['lastname'];
            $user->email = $tmpUser['email'];
            $user->password = $tmpUser['password'];
        }

        return $user;
    }

    public function save()
    {
        $gateway = new UserGateway();

        if (!$this->id) {
            $this->id = $gateway->insert([
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'email' => $this->email,
                'password' => $this->password
            ]);
        } else {
            $gateway->update($this->id, [
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'email' => $this->email,
                'password' => $this->password
            ]);
        }
    }

    public function delete()
    {
        $gateway = new UserGateway();
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password ?? "";
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function setToken(string $token)
    {
        $this->token = $token;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'token' => $this->token
        ];
    }
}
