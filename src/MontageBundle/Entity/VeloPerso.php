<?php

namespace MontageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * VeloPerso
 *
 * @ORM\Table(name="velo_perso")
 * @ORM\Entity(repositoryClass="MontageBundle\Repository\VeloPersoRepository")
 */
class VeloPerso
{
    /**
     * @return int
     */
    public function getPrix(): int
    {
        return $this->prix;
    }

    /**
     * @param int $prix
     */
    public function setPrix(int $prix): void
    {
        $this->prix = $prix;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    /**
     * @var integer
     *
     * @ORM\Column(name="prix", type="integer")
     * @Assert\NotBlank
     */

    private $prix;

    /**
     * @var integer
     *
     * @ORM\Column(name="corp", type="integer")
     * @Assert\NotBlank
     */
    private $corp;

    /**
     * @var integer
     *
     * @ORM\Column(name="roue", type="integer")
     * @Assert\NotBlank
     */
    private $roue;

    /**
     * @var integer
     *
     * @ORM\Column(name="pedale", type="integer")
     * @Assert\NotBlank
     */
    private $pedale;

    /**
     * @return int
     */
    public function getCorp(): int
    {
        return $this->corp;
    }

    /**
     * @param int $corp
     */
    public function setCorp(int $corp): void
    {
        $this->corp = $corp;
    }

    /**
     * @return int
     */
    public function getRoue(): int
    {
        return $this->roue;
    }

    /**
     * @param int $roue
     */
    public function setRoue(int $roue): void
    {
        $this->roue = $roue;
    }

    /**
     * @return int
     */
    public function getPedale(): int
    {
        return $this->pedale;
    }

    /**
     * @param int $pedale
     */
    public function setPedale(int $pedale): void
    {
        $this->pedale = $pedale;
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


}
