<?php

namespace HotelBundle\Controller;

use HotelBundle\Entity\typeChambre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typechambre controller.
 *
 * @Route("typechambre")
 */
class typeChambreController extends Controller
{
    /**
     * Lists all typeChambre entities.
     *
     * @Route("/", name="typechambre_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeChambres = $em->getRepository('HotelBundle:typeChambre')->findAll();

        return $this->render('typechambre/index.html.twig', array(
            'typeChambres' => $typeChambres,
        ));
    }

    /**
     * Creates a new typeChambre entity.
     *
     * @Route("/new", name="typechambre_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeChambre = new Typechambre();
        $form = $this->createForm('HotelBundle\Form\typeChambreType', $typeChambre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeChambre);
            $em->flush();

            return $this->redirectToRoute('typechambre_show', array('id' => $typeChambre->getId()));
        }

        return $this->render('typechambre/new.html.twig', array(
            'typeChambre' => $typeChambre,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeChambre entity.
     *
     * @Route("/{id}", name="typechambre_show")
     * @Method("GET")
     */
    public function showAction(typeChambre $typeChambre)
    {
        $deleteForm = $this->createDeleteForm($typeChambre);

        return $this->render('typechambre/show.html.twig', array(
            'typeChambre' => $typeChambre,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeChambre entity.
     *
     * @Route("/{id}/edit", name="typechambre_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, typeChambre $typeChambre)
    {
        $deleteForm = $this->createDeleteForm($typeChambre);
        $editForm = $this->createForm('HotelBundle\Form\typeChambreType', $typeChambre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dashboard_type_chambre', array('id' => $typeChambre->getId()));
        }

        return $this->render('typechambre/edit.html.twig', array(
            'typeChambre' => $typeChambre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeChambre entity.
     *
     * @Route("delete/{id}", name="typechambre_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $typeChambre = $em->getRepository('HotelBundle:typeChambre')->find($id);

            $em->remove($typeChambre);
            $em->flush();


        return $this->redirectToRoute('dashboard_type_chambre');
    }

    /**
     * Creates a form to delete a typeChambre entity.
     *
     * @param typeChambre $typeChambre The typeChambre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(typeChambre $typeChambre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typechambre_delete', array('id' => $typeChambre->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
