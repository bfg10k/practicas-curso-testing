<?php
namespace Test\Unit;

use Service\DbConnection;
use UseCase\UserPersistanceException;

class DbConnectionInsertFailMock extends DbConnection {

    public function __construct(){

    }

    public function insert(string $sql): int{
        throw new UserPersistanceException();
    }

    public function close(): void{
    }

}