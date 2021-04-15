<?php

namespace Service;

use mysqli;

class DbConnection {
    private mysqli $conn;


    /**
     * @throws NonValidConnectionException
     */
    public function __construct(string $host, string $dbUser, string $dbPass, string $dbName) {
        $this->conn = new mysqli($host, $dbUser, $dbPass, $dbName);

        if ($this->conn->connect_error) {
            throw new NonValidConnectionException();
        }
    }

    /**
     * @throws InsertException
     */
    public function insert(string $sql): int{
        $inserted = $this->conn->query($sql);

        if(!$inserted){
            $this->close();
            throw new InsertException();
        }

        return $this->conn->insert_id;
    }

    /** @throws DbConnectionFailedException */
    public function query(string $sql): ?array {
        return [];
    }

    public function close(){
        $this->conn->close();
    }

    public function query(string $string): array
    {
        return [];
    }
}