<?php

namespace HotelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use HotelBundle\Entity\Contact;

class DefaultController extends Controller
{
    /**
     * @Route("/", name ="home_page")
     */
    public function indexAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm('HotelBundle\Form\ContactType', $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $msg = \Swift_Message::newInstance()
                ->setSubject('Merci '. $contact->getNom().' pour votre intéret !')
                ->setFrom('contactgolfroyal@gmail.com')
                ->setTo($contact->getEmail())
                ->setBody('Votre message a bien été envoyé, à très bientôt ! /n ');
            $this->get('mailer')->send($msg);
            //Notif


            return $this->redirectToRoute('home_page');
        }

        return $this->render('HotelBundle:Default:index.html.twig', array(

            'form' => $form->createView(),
        ));
    }
}
