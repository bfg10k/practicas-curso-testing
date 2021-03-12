<?php declare(strict_types=1);

namespace Controller;

use Service\DbConnection;
use Service\NonValidConnectionException;
use UseCase\UserPersistanceException;
use UseCase\RegisterUser;
use Model\User;

class UserController
{
    public function register(): string
    {
        try {
            $connection = $this->createConnection("127.0.0.1", "db_user", "db_pass", "rental_db");
            $registerUseCase = new RegisterUser($connection);

            $user = $registerUseCase->execute(
                $this->getUser()
            );
            $connection->close();

            return $this->userResponse($user);
        } catch (UserPersistanceException $e) {
            $connection->close();
            return $this->handleFailOnInsert();
        } catch (NonValidConnectionException $e) {
            return $this->handleFailOnCreateConnection();
        }
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

    protected function userResponse(User $user): string
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

    protected function handleFailOnInsert(): string
    {
        return json_encode(
            ["error" => "Algo ha fallado al guardar los datos."]
        );
    }

    protected function handleFailOnCreateConnection(): string
    {
        return json_encode(
            ["error" => "Error inesperado."]
        );
    }

    /** @throws NonValidConnectionException */
    protected function createConnection(string $host, string $user, string $password, string $db)
    {
        return new DbConnection($host, $user, $password, $db);
    }
}