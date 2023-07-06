<?php

namespace App\Controllers;

use mysqli;

class DatabaseController
{
    public function createDatabase()
    {
        $conn = new mysqli("localhost", "iso6", "e$681Eab2", "personing_6");

        /* check connection */
        if ($conn->connect_errno) {
            printf("Connect failed: %s\n", $conn->connect_error);
            exit();
        }

        $stmt = $conn->prepare("CREATE TABLE user(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, firstname VARCHAR(255), lastname VARCHAR(255), email VARCHAR(255), password VARCHAR(255));");
        $stmt->execute();

        $stmt = $conn->prepare("CREATE TABLE type(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, label VARCHAR(255));");
        $stmt->execute();

        $stmt = $conn->prepare("CREATE TABLE person(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, user_id INT, type_id INT, firstname VARCHAR(255), lastname MEDIUMTEXT, completed TINYINT, FOREIGN KEY(user_id) REFERENCES user(id), FOREIGN KEY(type_id) REFERENCES type(id));");
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO type(label) VALUES ('ToDo'), ('Bug'), ('Improvement'), ('Feature');");
        $stmt->execute();

        echo "Database created successfully";
    }
}
