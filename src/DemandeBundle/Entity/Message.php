<?php

namespace DemandeBundle\Entity;

use Cassandra\Date;
use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="DemandeBundle\Repository\MessageRepository")
 */
class Message
{

    /**
     *@ORM\ManyToOne(targetEntity="\DemandeBundle\Entity\Demande")
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
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="senderRole", type="string", length=255)
     */
    private $senderRole;

    /**
     * @return string
     */
    public function getSenderRole()
    {
        return $this->senderRole;
    }

    /**
     * @param string $senderRole
     */
    public function setSenderRole($senderRole)
    {
        $this->senderRole = $senderRole;
    }

    /**
     * @var Date
     *
     * @ORM\Column(name="dateEnvoi", type="date", length=255)
     */
    private $dateEnvoi;

    /**
     * @return Date
     */
    public function getDateEnvoi()
    {
        return $this->dateEnvoi;
    }

    /**
     * @param Date $dateEnvoi
     */
    public function setDateEnvoi($dateEnvoi)
    {
        $this->dateEnvoi = $dateEnvoi;
    }


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
     * Set text
     *
     * @param string $text
     *
     * @return Message
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }






}

