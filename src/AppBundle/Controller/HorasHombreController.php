<?php

namespace AppBundle\Controller;

use AppBundle\Entity\HorasHombre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Horashombre controller.
 *
 * @Route("horashombre")
 */
class HorasHombreController extends Controller
{
    /**
     * Lists all horasHombre entities.
     *
     * @Route("/", name="horashombre_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $horasHombres = $em->getRepository('AppBundle:HorasHombre')->findAll();

        return $this->render('horashombre/index.html.twig', array(
            'horasHombres' => $horasHombres,
        ));
    }

    /**
     * Creates a new horasHombre entity.
     *
     * @Route("/new", name="horashombre_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $horasHombre = new Horashombre();
        $form = $this->createForm('AppBundle\Form\HorasHombreType', $horasHombre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($horasHombre);
            $em->flush();

            return $this->redirectToRoute('horashombre_show', array('id' => $horasHombre->getId()));
        }

        return $this->render('horashombre/new.html.twig', array(
            'horasHombre' => $horasHombre,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a horasHombre entity.
     *
     * @Route("/{id}", name="horashombre_show")
     * @Method("GET")
     */
    public function showAction(HorasHombre $horasHombre)
    {
        $deleteForm = $this->createDeleteForm($horasHombre);

        return $this->render('horashombre/show.html.twig', array(
            'horasHombre' => $horasHombre,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing horasHombre entity.
     *
     * @Route("/{id}/edit", name="horashombre_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, HorasHombre $horasHombre)
    {
        $deleteForm = $this->createDeleteForm($horasHombre);
        $editForm = $this->createForm('AppBundle\Form\HorasHombreType', $horasHombre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('horashombre_edit', array('id' => $horasHombre->getId()));
        }

        return $this->render('horashombre/edit.html.twig', array(
            'horasHombre' => $horasHombre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a horasHombre entity.
     *
     * @Route("/{id}", name="horashombre_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, HorasHombre $horasHombre)
    {
        $form = $this->createDeleteForm($horasHombre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($horasHombre);
            $em->flush();
        }

        return $this->redirectToRoute('horashombre_index');
    }

    /**
     * Creates a form to delete a horasHombre entity.
     *
     * @param HorasHombre $horasHombre The horasHombre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(HorasHombre $horasHombre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('horashombre_delete', array('id' => $horasHombre->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
