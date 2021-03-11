<?php


namespace Controller;


use Model\User;

class UserController
{
    public function register()
    {
        $user = new User(
            $_POST['name'],
            $_POST['age'],
            $_POST['mail'],
            $_POST['password'],
        );

        $conn = new \mysqli("127.0.0.1", "db_user", "db_pass", "rental_db");
        if (!$conn->connect_error) {
            echo json_encode(
                ["error" => "Error inesperado"]
            );
        }

        $sql = "INSERT INTO users (firstname, age, mail, password)
         VALUES ('" . $user->getName() . "', '" . $user->getAge() . "', '" . $user->getMail() . "', '" . $user->getPassword() . "')";

        if ($conn->query($sql) === true) {
            $conn->close();
            echo json_encode(
                ["user" =>
                    [
                        "id" => $user->getId(),
                        "name" => $user->getName(),
                        "age" => $user->getAge(),
                        "mail" => $user->getMail(),
                        "password" => $user->getPassword(),
                    ]
                ]
            );
        } else {
            $conn->close();
            throw new \Exception();
        }


    }
}