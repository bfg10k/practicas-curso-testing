<?php declare(strict_types=1);


namespace Controller;


use Model\User;

class UserController
{
    public function register()
    {
        $user = $this->getUser();

        $conn = $this->createConnection("127.0.0.1", "db_user", "db_pass", "rental_db");
        if (!$conn->connect_error) {
            $this->handleFailOnCreateConnection();
        }
        $sql = "INSERT INTO users (firstname, age, mail, password)
         VALUES ('" . $user->getName() . "', '" . $user->getAge() . "', '" . $user->getMail() . "', '" . $user->getPassword() . "')";

        if ($conn->query($sql) === true) {
            $conn->close();
            $this->sendResponse($user);
        } else {
            $conn->close();
            $this->handleFailOnInsert();
        }
    }

    protected function createConnection(string $host, string $user, string $password, string $db)
    {
        return new \mysqli($host, $user, $password, $db);
    }

    protected function getUser(): User
    {
        return new User(
            $_POST['name'],
            $_POST['age'],
            $_POST['mail'],
            $_POST['password'],
        );
    }

    protected function sendResponse(User $user): void
    {
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
    }

    protected function handleFailOnInsert(): void
    {
        echo json_encode(
            ["error" => "Algo ha fallado al guardar los datos."]
        );
    }

    protected function handleFailOnCreateConnection(): void
    {
        echo json_encode(
            ["error" => "Error inesperado."]
        );
    }
}