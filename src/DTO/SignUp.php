<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SignUp.
 */
class SignUp
{
    /**
     * @var
     * @Assert\NotBlank
     */
    private $nickname;
    /**
     * @var
     * @Assert\NotBlank
     */
    private $password;
    /**
     * @var
     * @Assert\NotBlank
     */
    private $firstname;
    /**
     * @var
     * @Assert\NotBlank
     */
    private $lastname;
    /**
     * @var
     * @Assert\NotBlank
     * @Assert\GreaterThan(0)
     * @Assert\LessThan(100)
     */
    private $age;

    /**
     * SignUp constructor.
     * @param $nickname
     * @param $password
     * @param $firstname
     * @param $lastname
     * @param $age
     */
    public function __construct($nickname, $firstname, $lastname, $age, $password)
    {
        $this->nickname = $nickname;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->age = $age;
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

}