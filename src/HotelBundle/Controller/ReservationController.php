<?php

namespace HotelBundle\Controller;

use HotelBundle\Entity\Reservation;
use HotelBundle\HotelBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use HotelBundle\Entity\Room;

/**
 * Reservation controller.
 *
 * @Route("reservation")
 */
class ReservationController extends Controller
{
    /**
     * Lists all reservation entities.
     *
     * @Route("/", name="reservation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reservations = $em->getRepository('HotelBundle:Reservation')->findAll();

        return $this->render('reservation/index.html.twig', array(
            'reservations' => $reservations,
        ));
    }

    /**
     *
     *
     * @Route("/new/{id}", name="reservation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,$id)
    {
        //$reservation = new Reservation();
        //$form = $this->createForm('HotelBundle\Form\ReservationType', $reservation);
        //$form->handleRequest($request);


            $em = $this->getDoctrine()->getManager();
            $reservation = $em->getRepository('HotelBundle:Reservation')->find($id);



            $rooms = $em->getRepository('HotelBundle:Room')->check_availibility($reservation->getDateArrive(),$reservation->getDateSortie(), $reservation->getTypeChambre());
            $reservation->setRoom( $em->getRepository('HotelBundle:Room')->find(array_values($rooms)[0]));

            $em->flush();

            return $this->render("reservation/check_availibility.html.twig", array ('rooms' => $rooms, 'reservation' =>$reservation));


        return $this->render('reservation/new.html.twig', array(
            'reservation' => $reservation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new reservation entity.
     *
     * @Route("/check", name="reservation_check")
     * @Method({"GET", "POST"})
     */
    public function check_availibilityAction(Request $request)
    {
        $reservation = new Reservation();
        $form = $this->createForm('HotelBundle\Form\ReservationType', $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $reservation->setDateArrive(\DateTime::createFromFormat('Y-m-d',$reservation->getArrive()));
            $reservation->setDateSortie(\DateTime::createFromFormat('Y-m-d',$reservation->getSort()));
             $em->persist($reservation);
             $em->flush();

            $rooms = $em->getRepository('HotelBundle:Room')->check_availibility($reservation->getDateArrive(),$reservation->getDateSortie(), $reservation->getTypeChambre());
            return $this->render("reservation/check_availibility.html.twig", array ('rooms' => $rooms, 'reservation' =>$reservation));
        }

        return $this->render('reservation/new.html.twig', array(
            'reservation' => $reservation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reservation entity.
     *
     * @Route("/{id}", name="reservation_show")
     * @Method("GET")
     */
    public function showAction(Reservation $reservation)
    {
        $deleteForm = $this->createDeleteForm($reservation);

        return $this->render('reservation/show.html.twig', array(
            'reservation' => $reservation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reservation entity.
     *
     * @Route("/{id}/edit", name="reservation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Reservation $reservation)
    {
        $deleteForm = $this->createDeleteForm($reservation);
        $editForm = $this->createForm('HotelBundle\Form\ReservationType', $reservation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_edit', array('id' => $reservation->getId()));
        }

        return $this->render('reservation/edit.html.twig', array(
            'reservation' => $reservation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reservation entity.
     *
     * @Route("delete /{id}", name="reservation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {



            $em = $this->getDoctrine()->getManager();
            $reservation = $em->getRepository('HotelBundle:Reservation')->find($id);
            $em->remove($reservation);
        $em->flush();


        return $this->redirectToRoute('dashboard_reservation');
    }

    /**
     *
     *
     * @Route("traiter/{id}", name="reservation_traiter")
     *
     */
    public function confirmReservationAction($id)
    {


        //$reservation = new Reservation();
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('HotelBundle:Reservation')->find($id);
        $client = $em->getRepository('HotelBundle:Client')->find($reservation->getClient()->getID());
        $reservation->setTreated(1);
        $em->persist($reservation);
        $em->flush();

        $hourdiff = strtotime($reservation->getArrive()) - strtotime($reservation->getSort());
        $diff = abs(round($hourdiff/86400))* $reservation->getTypeChambre()->getPrix();
        $totalprice = $hourdiff * $reservation->getTypeChambre()->getPrix();
        $msg = \Swift_Message::newInstance()
            ->setSubject('Votre Réservation est confirmée')
            ->setFrom('contactgolfroyal@gmail.com')
            ->setTo($client->getEmail())
            ->setBody(
                $this->renderView(
                    'reservation/reservation_mail.html.twig',array(
                        'reservation' => $reservation,'client' => $client, 'total' => $diff)
                ),
                'text/html'
            );
        $this->get('mailer')->send($msg);

        return $this->redirectToRoute('dashboard_reservation');
    }

    /**
     *
     *
     * @Route("archiver/{id}", name="reservation_archiver")
     *
     */
    public function archiverReservationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('HotelBundle:Reservation')->find($id);
        $reservation->setArchive(true);
        $em->persist($reservation);
        $em->flush();
        return $this->redirectToRoute('dashboard_reservation_archive');
    }





    /**
     * Creates a form to delete a reservation entity.
     *
     * @param Reservation $reservation The reservation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reservation $reservation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reservation_delete', array('id' => $reservation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
