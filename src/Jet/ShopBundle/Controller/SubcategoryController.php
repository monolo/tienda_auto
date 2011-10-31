<?php

namespace Jet\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jet\ShopBundle\Entity\Subcategory;
use Jet\ShopBundle\Form\SubcategoryType;

/**
 * Subcategory controller.
 *
 * @Route("/auto/subcategory")
 */
class SubcategoryController extends Controller
{
    /**
     * Lists all Subcategory entities.
     *
     * @Route("/", name="auto_subcategory")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JetShopBundle:Subcategory')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Subcategory entity.
     *
     * @Route("/{id}/show", name="auto_subcategory_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JetShopBundle:Subcategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subcategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Subcategory entity.
     *
     * @Route("/new", name="auto_subcategory_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Subcategory();
        $form   = $this->createForm(new SubcategoryType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Subcategory entity.
     *
     * @Route("/create", name="auto_subcategory_create")
     * @Method("post")
     * @Template("JetShopBundle:Subcategory:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Subcategory();
        $request = $this->getRequest();
        $form    = $this->createForm(new SubcategoryType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('auto_subcategory_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Subcategory entity.
     *
     * @Route("/{id}/edit", name="auto_subcategory_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JetShopBundle:Subcategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subcategory entity.');
        }

        $editForm = $this->createForm(new SubcategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Subcategory entity.
     *
     * @Route("/{id}/update", name="auto_subcategory_update")
     * @Method("post")
     * @Template("JetShopBundle:Subcategory:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JetShopBundle:Subcategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subcategory entity.');
        }

        $editForm   = $this->createForm(new SubcategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('auto_subcategory_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Subcategory entity.
     *
     * @Route("/{id}/delete", name="auto_subcategory_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JetShopBundle:Subcategory')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Subcategory entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('auto_subcategory'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
