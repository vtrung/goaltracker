<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields
    /**
     * @ORM\Column(type="integer")
     */
    private $gid;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $status;

    /**
     * @ORM\Column(type="date")
     */
    private $goaldate;

    /**
     * @ORM\Column(type="date")
     */
    private $completedate;

    // GETTER and SETTER
    public function getId()
    {
        return $this->id;
    }

    public function getGid()
    {
        return $this->gid;
    }

    public function setGid($gid)
    {
        $this->gid = $gid;
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

    public function getGoalDate(){
        return $this->goaldate;
    }

    public function setGoalDate($date){
        $this->goaldate = $date;
    }

    public function getCompleteDate(){
        return $this->completedate;
    }

    public function setCompleteDate($date){
        $this->goaldate = $date;
    }
}
