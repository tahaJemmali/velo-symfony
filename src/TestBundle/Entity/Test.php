<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Test
 *
 * @ORM\Table(name="test")
 * @ORM\Entity(repositoryClass="TestBundle\Repository\TestRepository")
 */
class Test
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="string", type="string", length=255)
     */
    private $string;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTest", type="date")
     */
    private $dateTest;

    /**
     * @var int
     *
     * @ORM\Column(name="entier", type="integer")
     */
    private $entier;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set string
     *
     * @param string $string
     *
     * @return Test
     */
    public function setString($string)
    {
        $this->string = $string;

        return $this;
    }

    /**
     * Get string
     *
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * Set dateTest
     *
     * @param \DateTime $dateTest
     *
     * @return Test
     */
    public function setDateTest($dateTest)
    {
        $this->dateTest = $dateTest;

        return $this;
    }

    /**
     * Get dateTest
     *
     * @return \DateTime
     */
    public function getDateTest()
    {
        return $this->dateTest;
    }

    /**
     * Set entier
     *
     * @param integer $entier
     *
     * @return Test
     */
    public function setEntier($entier)
    {
        $this->entier = $entier;

        return $this;
    }

    /**
     * Get entier
     *
     * @return int
     */
    public function getEntier()
    {
        return $this->entier;
    }
}

