<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends DefaultController
{
    public function get(int $id = 0)
    {
        if ($id > 0) {
            echo json_encode(User::findById($id));
        }

        echo json_encode(User::all());
    }

    public function post(array $data)
    {
        $this->validate($data, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'password' => 'required|password'
        ]);

        $user = User::findByEmail($data['email']);

        if (!$user) {
            $user = new User();
            $user->setFirstname($data['firstname']);
            $user->setLastname($data['lastname']);
            $user->setEmail($data['email']);

            $hash = password_hash($data['password'], PASSWORD_BCRYPT);
            $user->setPassword($hash);
            $user->save();

            return "success";
        }

        http_response_code(422);
        return "fail";
    }

    public function put(int $id, array $data)
    {
        $user = User::findById($id);
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setEmail($data['email']);

        $hash = password_hash($data['password'], PASSWORD_BCRYPT);
        $user->setPassword($hash);
        $user->save();

        echo json_encode($user);
    }

    public function delete(int $id)
    {
        $user = User::findById($id);
        $user->delete();

        echo json_encode([
            'id' => $id
        ]);
    }
}
