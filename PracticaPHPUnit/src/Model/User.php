<?php declare(strict_types=1);

namespace Model;

class User {

    private const LEGAL_AGE_FOR_DRIVING=18; 
    
    private const MINIMUM_USER_AGE=6; 

    private int $id;

    private string $name;

    private int $age;

    private string $mail;

    private string $password;

    public function __construct(string $name, int $age, string $mail, string $password){
        if($age < self::MINIMUM_USER_AGE){
            throw new \InvalidArgumentException();
        }

        $this->name = $name;
        $this->age = $age;
        $this->mail = $mail;
        $this->password = $password;
    }

    public function isAnAdult(): bool{
        return $this->age >= self::LEGAL_AGE_FOR_DRIVING;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }
}



