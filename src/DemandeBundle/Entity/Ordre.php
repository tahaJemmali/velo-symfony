<?php

namespace DemandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ordre
 *
 * @ORM\Table(name="ordre")
 * @ORM\Entity(repositoryClass="DemandeBundle\Repository\OrdreRepository")
 */
class Ordre
{

    /**
     *@ORM\OneToOne(targetEntity="\DemandeBundle\Entity\Demande")
     *@ORM\JoinColumn(name="demande_id",referencedColumnName="id")
     *
     *
     */

    private $demande;

    /**
     * @return mixed
     */
    public function getDemande()
    {
        return $this->demande;
    }

    /**
     * @param mixed $demande
     */
    public function setDemande($demande)
    {
        $this->demande = $demande;
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
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="dateOrdre", type="date", length=255)
     */
    private $dateOrdre;


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
     * Set etat
     *
     * @param string $etat
     *
     * @return Ordre
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Get dateOrdre
     *
     * @return int
     */
    public function getDateOrdre()
    {
        return $this->dateOrdre;
    }

    /**
     * Set etat
     *
     * @param string $dateOrdre
     *
     * @return Ordre
     */
    public function setDateOrdre($dateOrdre)
    {
        $this->dateOrdre= $dateOrdre;

        return $this;
    }
}

