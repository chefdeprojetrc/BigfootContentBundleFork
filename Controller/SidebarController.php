<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Bigfoot\Bundle\CoreBundle\Crud\CrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;
use Bigfoot\Bundle\ContentBundle\Form\SidebarType;
use Bigfoot\Bundle\CoreBundle\Theme\Menu\Item;

/**
 * Sidebar controller.
 *
 * @Route("/sidebar")
 */
class SidebarController extends CrudController
{

    protected function getName()
    {
        return 'admin_sidebar';
    }

    /**
     * Must return the entity full name (eg. BigfootCoreBundle:Tag).
     *
     * @return string
     */
    protected function getEntity()
    {
        return 'BigfootContentBundle:Sidebar';
    }

    /**
     * Must return an associative array field name => field label.
     *
     * @return array
     */
    protected function getFields()
    {
        return array(
            'id'    => 'id',
            'title' => 'title'
        );
    }

    protected function getFormType()
    {
        return 'bigfoot_bundle_contentbundle_sidebartype';
    }

    /**
     * @Route("/", name="admin_sidebar")
     * @Method("GET")
     * @Template("BigfootContentBundle:Dashboard:default.html.twig")
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * Creates a new Sidebar entity.
     *
     * @Route("/", name="admin_sidebar_create")
     * @Method("POST")
     * @Template("BigfootCoreBundle:crud:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Sidebar();
        $form = $this->createForm($this->getFormType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_dashboard'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Sidebar entity.
     *
     * @Route("/new", name="admin_sidebar_new")
     * @Method("GET")
     * @Template("BigfootCoreBundle:crud:new.html.twig")
     */
    public function newAction()
    {
        $arrayNew = $this->doNew();
        $arrayNew['isAjax'] = true;

        return $arrayNew;
    }

    /**
     * Displays a form to edit an existing Sidebar entity.
     *
     * @Route("/edit/{id}/", name="admin_sidebar_edit")
     * @Method("GET")
     * @Template("BigfootCoreBundle:crud:edit.html.twig")
     */
    public function editAction($id)
    {
        $arrayEdit = $this->doEdit($id);
        $arrayEdit['isAjax'] = true;

        return $arrayEdit;
    }

    /**
     * Edits an existing Sidebar entity.
     *
     * @Route("/{id}", name="admin_sidebar_update")
     * @Method("PUT")
     * @Template("BigfootCoreBundle:crud:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BigfootContentBundle:Sidebar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sidebar entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm($this->getFormType(), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_dashboard'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Sidebar entity.
     *
     * @Route("/delete/{id}", name="admin_sidebar_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BigfootContentBundle:Sidebar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sidebar entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_dashboard'));
    }

    /**
     * Creates a form to delete a Sidebar entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
