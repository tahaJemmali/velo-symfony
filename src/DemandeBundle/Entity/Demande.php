<?php

namespace DemandeBundle\Entity;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Demande
 *
 * @ORM\Table(name="demande")
 * @ORM\Entity(repositoryClass="DemandeBundle\Repository\DemandeRepository")
 */
class Demande
{

    /**
     *@ORM\ManyToOne(targetEntity="\LoginBundle\Entity\User")
     *@ORM\JoinColumn(name="client_id",referencedColumnName="id")
     *
     *
     */
    private $client;

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
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
     * @return bool
     */
    public function isNotificationClient()
    {
        return $this->notificationClient;
    }

    /**
     * @param bool $notificationClient
     */
    public function setNotificationClient($notificationClient)
    {
        $this->notificationClient = $notificationClient;
    }

    /**
     * @var boolean
     * @ORM\Column(name="notificationClient", type="boolean", nullable=true, options={"default":false})
     */
    protected $notificationClient;

    /**
     * @var boolean
     * @ORM\Column(name="notificationAdmin", type="boolean", nullable=true, options={"default":false})
     */
    protected $notificationAdmin;

    /**
     * @return bool
     */
    public function isNotificationAdmin()
    {
        return $this->notificationAdmin;
    }

    /**
     * @param bool $notificationAdmin
     */
    public function setNotificationAdmin($notificationAdmin)
    {
        $this->notificationAdmin = $notificationAdmin;
    }



    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDemande", type="date")
     */
    private $dateDemande;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


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
     * Set description
     *
     * @param string $description
     *
     * @return Demande
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateDemande
     *
     * @param \DateTime $dateDemande
     *
     * @return Demande
     */
    public function setDateDemande($dateDemande)
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    /**
     * Get dateDemande
     *
     * @return \DateTime
     */
    public function getDateDemande()
    {
        return $this->dateDemande;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Demande
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
     * Set image
     *
     * @param string $image
     *
     * @return Demande
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}

