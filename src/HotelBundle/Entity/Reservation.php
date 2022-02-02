<?php

namespace HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="HotelBundle\Repository\ReservationRepository")
 */
class Reservation
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
      *@ORM\ManyToOne(targetEntity="Room" , inversedBy="reservations")
      * @ORM\JoinColumn (name="roomId" , referencedColumnName="id", nullable= true)
     */
    private $room;

    /**
     * Reservation constructor.
     * @param \DateTime $dateCreation
     */
    public function __construct()
    {
        $this->setDateCreation(new \DateTime());
        $this->setTreated(false);
        $this->setArchive(false);
    }

    /**
     * @return mixed
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * @param mixed $archive
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;
    }


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
     * @param mixed $typeChambre
     */
    public function setTypeChambre($typeChambre)
    {
        $this->typeChambre = $typeChambre;
    }






    /**
     * @return mixed
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param mixed $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param \DateTime $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }




    /**
     * @var \Date
     *
     * @ORM\Column(name="date_arrive", type="date")
     */
    private $dateArrive;

    /**
     * @var \Date
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $date_creation;

    /**
     *
     *
     * @ORM\Column(name="arrive", type="string")
     */
    private $arrive;

    /**
     *
     *
     * @ORM\Column(name="treated", type="boolean")
     */
    private $treated;

    /**
     *
     *
     * @ORM\Column(name="archive", type="boolean")
     */
    private $archive;

    /**
     * @return mixed
     */
    public function getTreated()
    {
        return $this->treated;
    }

    /**
     * @param mixed $treated
     */
    public function setTreated($treated)
    {
        $this->treated = $treated;
    }

    /**
     *
     *
     * @ORM\Column(name="sort", type="string")
     */
    private $sort;

    /**
     * @return mixed
     */
    public function getArrive()
    {
        return $this->arrive;
    }

    /**
     * @param mixed $arrive
     */
    public function setArrive($arrive)
    {
        $this->arrive = $arrive;
    }

    /**
     * @return mixed
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param mixed $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }



    /**
     * @var \Date
     *
     * @ORM\Column(name="date_sortie", type="date")
     */
    private $dateSortie;



    /**
     *@ORM\ManyToOne(targetEntity="Client" , inversedBy="reservations")
     * @ORM\JoinColumn (name="clientId" , referencedColumnName="id", nullable= true)
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set dateArrive
     *
     * @param \Date $dateArrive
     *
     * @return Reservation
     */
    public function setDateArrive($dateArrive)
    {
        $this->dateArrive = $dateArrive;

        return $this;
    }

    /**
     * Get dateArrive
     *
     * @return \Date
     */
    public function getDateArrive()
    {
        return $this->dateArrive;
    }

    /**
     * Set dateSortie
     *
     * @param \Date $dateSortie
     *
     * @return Reservation
     */
    public function setDateSortie($dateSortie)
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    /**
     * Get dateSortie
     *
     * @return \Date
     */
    public function getDateSortie()
    {
        return $this->dateSortie;
    }


}

