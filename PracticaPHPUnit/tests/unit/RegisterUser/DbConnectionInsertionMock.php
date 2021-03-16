<?php
namespace Test\Unit\RegisterUser;

use Service\DbConnection;
use Service\NonValidConnectionException;

class DbConnectionInsertionMock extends DbConnection {

    public function __construct(){
    }

    public function insert(string $sql): int{
        return rand(1,1000);
    }

    public function close(): void{

    }

}