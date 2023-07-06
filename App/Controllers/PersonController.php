<?php

namespace App\Controllers;

use App\Models\Person;

class PersonController
{
    public function get()
    {
        echo json_encode(Person::all(), JSON_UNESCAPED_UNICODE);
    }

    public function getPersonsForUser(int $userId)
    {
        echo json_encode(Person::findByUserId($userId), JSON_UNESCAPED_UNICODE);
    }

    public function getPersonsForType(int $typeId)
    {
        echo json_encode(Person::findByTypeId($typeId), JSON_UNESCAPED_UNICODE);
    }

    public function getPerson(int $personId)
    {
        echo json_encode(Person::findById($personId), JSON_UNESCAPED_UNICODE);
    }

    public function post(array $data)
    {
        $person = new Person();
        $person->setUserId($data['user']['id']);
        $person->setTypeId($data['type']['id']);
        $person->setFirstname($data['firstname']['id']);
        $person->setLastname($data['lastname']);
        $person->setCompleted(false);
        $person->save();

        echo json_encode($person);
    }

    public function put(int $id, array $data)
    {
        $person = Person::findById($id);
        $person->setUserId($data['user']['id']);
        $person->setTypeId($data['type']['id']);
        $person->setFirstname($data['firstname']);
        $person->setLastname($data['completed']);
        $person->setCompleted($data['lastname']);
        $person->setCompleted(false);
        $person->save();

        echo json_encode($person);
    }

    public function delete(int $id)
    {
        $person = Person::findById($id);
        $person->delete();

        echo json_encode([
            'id' => $id
        ]);
    }
}
