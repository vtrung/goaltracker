<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /// add your own fields
    /**
     * @ORM\Column(type="integer")
     */
    private $tid;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $status;


    // GETTER and SETTER
    public function getId()
    {
        return $this->id;
    }

    public function getTid()
    {
        return $this->tid;
    }

    public function setGid($tid)
    {
        $this->tid = $tid;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setStatus($status){
        $this->status = $status;
    }
}
