<?php

namespace Jet\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Jet\ShopBundle\Entity\BotProduct;
use Jet\ShopBundle\Form\BotProductType;

/**
 * BotProduct controller.
 *
 * @Route("/auto/botproduct")
 */
class BotProductController extends Controller
{
    /**
     * Lists all BotProduct entities.
     *
     * @Route("/", name="auto_botproduct")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JetShopBundle:BotProduct')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a BotProduct entity.
     *
     * @Route("/{id}/show", name="auto_botproduct_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JetShopBundle:BotProduct')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BotProduct entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new BotProduct entity.
     *
     * @Route("/new", name="auto_botproduct_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new BotProduct();
        $form   = $this->createForm(new BotProductType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new BotProduct entity.
     *
     * @Route("/create", name="auto_botproduct_create")
     * @Method("post")
     * @Template("JetShopBundle:BotProduct:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new BotProduct();
        $request = $this->getRequest();
        $form    = $this->createForm(new BotProductType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('auto_botproduct_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing BotProduct entity.
     *
     * @Route("/{id}/edit", name="auto_botproduct_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JetShopBundle:BotProduct')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BotProduct entity.');
        }

        $editForm = $this->createForm(new BotProductType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing BotProduct entity.
     *
     * @Route("/{id}/update", name="auto_botproduct_update")
     * @Method("post")
     * @Template("JetShopBundle:BotProduct:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JetShopBundle:BotProduct')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BotProduct entity.');
        }

        $editForm   = $this->createForm(new BotProductType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('auto_botproduct_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a BotProduct entity.
     *
     * @Route("/{id}/delete", name="auto_botproduct_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JetShopBundle:BotProduct')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BotProduct entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('auto_botproduct'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
