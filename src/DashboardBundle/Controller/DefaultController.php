<?php

namespace DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name ="dashboard")
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return $this->render('back.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    
    //// RESERVATION /////
    
    /**
     * @Route("/res", name = "dashboard_reservation")
     */
    public function backReservationAction(){
        $em = $this->getDoctrine()->getManager();
        $reservations = $em->getRepository('HotelBundle:Reservation')->findBy(array('archive'=> '0'));

        return $this->render('reservation/reservationBack.html.twig', array(
            'reservations' => $reservations,
        ));
    }

    /**
     * @Route("/res/archive", name = "dashboard_reservation_archive")
     */
    public function ArchiveReservationAction(){
        $em = $this->getDoctrine()->getManager();
        $reservations = $em->getRepository('HotelBundle:Reservation')->findBy(array('archive'=> '1'));

        return $this->render('reservation/archive_reservation.html.twig', array(
            'reservations' => $reservations,
        ));
    }

    /**
     * @Route("/res/calendar", name = "dashboard_reservation_calendar")
     */
    public function backReservationCalendar(){
        $em = $this->getDoctrine()->getManager();
        $reservations = $em->getRepository('HotelBundle:Reservation')->findAll();

        return $this->render('reservation/reservation_calendar_back.html.twig', array(
            'reservations' => $reservations,
        ));
    }
    
    /// CLIENTS ////

    /**
     * @Route("/client", name = "dashboard_client")
     */
    public function backClient(){
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('HotelBundle:Client')->findAll();
        $reservation = $em->getRepository('HotelBundle:Reservation')->findall();

        return $this->render('client/clientBack.html.twig', array(
            'clients' => $clients,
            'reservations'=>$reservation
        ));
    }

    /// Type_Chambre ////

    /**
     * @Route("/type-chambre", name = "dashboard_type_chambre")
     */
    public function backType_cAction(){
        $em = $this->getDoctrine()->getManager();
        $chambres = $em->getRepository('HotelBundle:typeChambre')->findAll();


        return $this->render('typechambre/typeChambreBack.html.twig', array(
            'chambres' => $chambres,
        ));
    }

    /// ROOMS
    /**
     * @Route("/rooms", name = "dashboard_rooms")
     */
    public function backRoomsAction(){
        $em = $this->getDoctrine()->getManager();
        $chambres = $em->getRepository('HotelBundle:Room')->findAll();


        return $this->render('room/roomBack.html.twig', array(
            'chambres' => $chambres,
        ));
    }
}
