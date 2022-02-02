<?php

namespace HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Room
 *
 * @ORM\Table(name="room")
 * @ORM\Entity(repositoryClass="HotelBundle\Repository\RoomRepository")
 */
class Room
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
     * @return mixed
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * @param mixed $reservations
     */
    public function setReservations($reservations)
    {
        $this->reservations = $reservations;
    }

    /**
     *@ORM\OneToMany(targetEntity="Reservation" , mappedBy="room")
     */
    private $reservations;

    /**
     *@ORM\ManyToOne(targetEntity="typeChambre" , inversedBy="room")
     * @ORM\JoinColumn (name="typeChambreId" , referencedColumnName="id")
     */
    private $typeChambre;

    /**
     * @return mixed
     */
    public function getTypeChambre()
    {
        return $this->typeChambre;
    }


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="checkin", type="date", nullable = true)
     */
    private $checkin;

    /**
     * @return \DateTime
     */
    public function getCheckin()
    {
        return $this->checkin;
    }

    /**
     * @return string
     */
    public function getCheckout()
    {
        return $this->checkout;
    }

    /**
     * @param string $checkout
     */
    public function setCheckout($checkout)
    {
        $this->checkout = $checkout;
    }

    /**
     * @param \DateTime $checkin
     */
    public function setCheckin($checkin)
    {
        $this->checkin = $checkin;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="checkout", type="date", nullable= true)
     */
    private $checkout;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;



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
     * Set titre
     *
     * @param string $titre
     *
     * @return Room
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Room
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


}

