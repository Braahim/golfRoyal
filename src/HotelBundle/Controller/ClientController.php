<?php

namespace HotelBundle\Controller;

use HotelBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Client controller.
 *
 * @Route("client")
 */
class ClientController extends Controller
{
    /**
     * Lists all client entities.
     *
     * @Route("/", name="client_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('HotelBundle:Client')->findAll();

        return $this->render('client/index.html.twig', array(
            'clients' => $clients,
        ));
    }

    /**
     * Creates a new client entity.
     *
     * @Route("/new/{id}", name="client_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id)
    {
        $client = new Client();
        $form = $this->createForm('HotelBundle\Form\ClientType', $client);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('HotelBundle:Reservation')->find($id);
        $rooms = $em->getRepository('HotelBundle:Room')->check_availibility($reservation->getDateArrive(),$reservation->getDateSortie(), $reservation->getTypeChambre());


        if ($form->isSubmitted() && $form->isValid()) {


            $reservation->setClient($client);
            $reservation->setRoom( $em->getRepository('HotelBundle:Room')->find(array_values($rooms)[0]));
            $em->persist($client);
            $em->flush();
            $msg = \Swift_Message::newInstance()
                ->setSubject('Merci Mr/Mme'. $client->getPrenom().' '. $client->getNom().' pour votre réservation !')
                ->setFrom('contactgolfroyal@gmail.com')
                ->setTo($client->getEmail())
                ->setBody('Votre réservation a été effectué avec succés 
                                     un employé vous appelera pour confirmer ');
            $this->get('mailer')->send($msg);
            //Notif



            return $this->redirectToRoute('client_show', array('id' => $client->getId()));
        }

        return $this->render('client/new.html.twig', array(
            'client' => $client,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a client entity.
     *
     * @Route("/{id}", name="client_show")
     * @Method("GET")
     */
    public function showAction(Client $client)
    {
        $deleteForm = $this->createDeleteForm($client);

        return $this->render('client/show.html.twig', array(
            'client' => $client,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing client entity.
     *
     * @Route("/{id}/edit", name="client_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Client $client)
    {
        $deleteForm = $this->createDeleteForm($client);
        $editForm = $this->createForm('HotelBundle\Form\ClientType', $client);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_edit', array('id' => $client->getId()));
        }

        return $this->render('client/edit.html.twig', array(
            'client' => $client,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a client entity.
     *
     * @Route("/delete/{id}", name="client_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $client = $em->getRepository('HotelBundle:Client')->find($id);

        $em->remove($client);
        $em->flush();


        return $this->redirectToRoute('dashboard_client');
    }

    /**
     * Creates a form to delete a client entity.
     *
     * @param Client $client The client entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Client $client)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('client_delete', array('id' => $client->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
