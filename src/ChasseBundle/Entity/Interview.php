<?php

namespace ChasseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Interview
 */
class Interview
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $bonusWord;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set bonusWord
     *
     * @param string $bonusWord
     * @return Interview
     */
    public function setBonusWord($bonusWord)
    {
        $this->bonusWord = $bonusWord;

        return $this;
    }

    /**
     * Get bonusWord
     *
     * @return string 
     */
    public function getBonusWord()
    {
        return $this->bonusWord;
    }
}
