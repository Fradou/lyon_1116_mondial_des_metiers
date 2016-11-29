<?php

namespace ChasseBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

class User extends BaseUser
{
    protected $id;

    public function __construct()
    {
        parent::__construct();

    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $interviews;


    /**
     * Add interviews
     *
     * @param \ChasseBundle\Entity\Interview $interviews
     * @return User
     */
    public function addInterview(\ChasseBundle\Entity\Interview $interviews)
    {
        $this->interviews[] = $interviews;

        return $this;
    }

    /**
     * Remove interviews
     *
     * @param \ChasseBundle\Entity\Interview $interviews
     */
    public function removeInterview(\ChasseBundle\Entity\Interview $interviews)
    {
        $this->interviews->removeElement($interviews);
    }

    /**
     * Get interviews
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInterviews()
    {
        return $this->interviews;
    }
}
