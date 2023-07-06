<?php

use App\Controllers\DatabaseController;
use App\Controllers\PersonController;
use App\Controllers\TypeController;
use App\Controllers\UserController;
use App\Controllers\LoginController;
use App\Middleware\Authenticated;

require_once 'vendor/autoload.php';

session_start();

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$auth = new Authenticated();

if (preg_match('#/database/create#', $url)) {
    $controller = new DatabaseController();
    $controller->createDatabase();
}

if (preg_match('#/login#', $url)) {
    $controller = new LoginController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        $controller->login($data);
    }

    die();
}

if (preg_match('#/users$#', $url)) {
    $controller = new UserController();

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $data = json_decode(file_get_contents("php://input"), true);
        echo $controller->post($data);
    } elseif ($_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->get();
    }
    die;
} elseif (preg_match('#/index$#', $url)) {
    include 'index.html.twig';
    die;
} else {
    // Handle other URLs or show an error message
    echo "404 Not Found";
    die;
}


if (preg_match('#/users$#', $url)) {
    $controller = new UserController();

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $data = json_decode(file_get_contents("php://input"), true);
        echo $controller->post($data);
    } elseif ($_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->get();
    }
    die();
}

if (preg_match('#/users/\d+$#', $url)) { // /users/1/tickets

    $matches = array();
    preg_match('/\d+/', $url, $matches);

    $controller = new UserController();
    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->get($matches[0]);
    } elseif ($_SERVER['REQUEST_METHOD'] === "PUT") {
        $data = json_decode(file_get_contents("php://input"), true);
        $controller->put($matches[0], $data);
    } elseif ($_SERVER['REQUEST_METHOD'] === "DELETE") {
        $controller->delete($matches[0]);
    }
    die();
}

if (preg_match('#/users/\d+/persons$#', $url)) {

    $matches = array();
    preg_match('/\d+/', $url, $matches);

    $controller = new PersonController();
    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->getPersonsForUser($matches[0]);
    }
}

if (preg_match('#/users/\d+/persons/\d+$#', $url)) {

    $matches = array();
    preg_match_all('/\d+/', $url, $matches);

    $controller = new PersonController();
    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->getPerson($matches[0][1]);
    }
    die();
}

if ($auth->handle()) {
    if (preg_match('#/persons$#', $url)) {
        $controller = new PersonController();

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $data = json_decode(file_get_contents("php://input"), true);
            $controller->post($data);
        } elseif ($_SERVER['REQUEST_METHOD'] === "GET") {
            $controller->get();
        }
        die();
    }
}


if (preg_match('#/persons/\d+$#', $url)) {

    $matches = array();
    preg_match('/\d+/', $url, $matches);
    $controller = new PersonController();

    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->get($matches[0]);
    } elseif ($_SERVER['REQUEST_METHOD'] === "PUT") {
        $data = json_decode(file_get_contents("php://input"), true);
        $controller->put($matches[0], $data);
    } elseif ($_SERVER['REQUEST_METHOD'] === "DELETE") {
        $controller->delete($matches[0]);
    }
    die();
}

if (preg_match('#/types$#', $url)) {
    $controller = new TypeController();
    $controller->get();
    die();
}

if (preg_match('#/types/\d+/persons$#', $url)) {

    $matches = array();
    preg_match('/\d+/', $url, $matches);

    $controller = new PersonController();
    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->getPersonsForType($matches[0]);
    }
}

if (preg_match('#/types/\d+/persons/\d+$#', $url)) {

    $matches = array();
    preg_match_all('/\d+/', $url, $matches);

    $controller = new PersonController();
    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        $controller->getPerson($matches[0][1]);
    }
    die();
}
