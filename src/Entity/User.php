<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields

    /**
     * @ORM\Column(type="string", length=100, unique=TRUE)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $fname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\Column(type="date")
     */
    private $dob;


    // Getter and Setters

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getFName(){
        return $this->fname;
    }

    public function setFName($name){
        $this->fname = $name;
    }

    public function getLName(){
        return $this->lname;
    }

    public function setLName($name){
        $this->lname = $name;
    }
    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getDob(){
        return $this->dob;
    }

    public function setDob($dob){
        $this->dob = $dob;
    }
}
