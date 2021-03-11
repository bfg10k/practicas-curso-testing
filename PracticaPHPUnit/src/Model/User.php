<?php declare(strict_types=1);

namespace Model;

class User
{
    private int $id;

    private string $name;

    private int $age;

    private string $mail;

    private string $password;

    public function __construct(string $name, int $age, string $mail, string $password)
    {
        if ($age < 6) {
            throw new \InvalidArgumentException();
        }

        $this->name = $name;
        $this->age = $age;
        $this->mail = $mail;
        $this->password = $password;
    }

    public function isAnAdult(): bool
    {
        return $this->age >= 18;
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