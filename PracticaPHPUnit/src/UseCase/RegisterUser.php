<?php
namespace UseCase;

use Model\User;
use Service\DbConnection;
use Service\InsertException;

class RegisterUser {
    private DbConnection $conn;

    public function __construct(DbConnection $conn){
        $this->conn = $conn;
    }

    /**
     * @throws UserPersistanceException
     */
    public function execute(User $user): User
    {
        $insertSql = "INSERT INTO users (firstname, age, mail, password)
        VALUES ('" . $user->getName() . "', '" . $user->getAge() . "', '" . $user->getMail() . "', '" . $user->getPassword() . "')";


        try {
            $id = $this->conn->insert($insertSql);
        } catch (InsertException $e) {
            throw new UserPersistanceException();
        }

        return $user->setId($id);
    }
}
