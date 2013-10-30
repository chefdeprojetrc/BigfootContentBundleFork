<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Bigfoot\Bundle\CoreBundle\Crud\CrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bigfoot\Bundle\ContentBundle\Entity\StaticContent;
use Bigfoot\Bundle\ContentBundle\Form\StaticContentType;
use Bigfoot\Bundle\CoreBundle\Theme\Menu\Item;

/**
 * StaticContent controller.
 *
 * @Route("/staticcontent")
 */
class StaticContentController extends CrudController
{

    /**
     * Used to generate route names.
     * The helper method of this class will use routes named after this name.
     * This means if you extend this class and use its helper methods, if getName() returns 'my_controller', you must implement a route named 'my_controller'.
     *
     * @return string
     */
    protected function getName()
    {
        return 'admin_staticcontent';
    }

    /**
     * Must return the entity full name (eg. BigfootCoreBundle:Tag).
     *
     * @return string
     */
    protected function getEntity()
    {
        return 'BigfootContentBundle:StaticContent';
    }

    /**
     * Must return an associative array field name => field label.
     *
     * @return array
     */
    protected function getFields()
    {
        return array(
            'id'    => 'ID',
            'title' => 'Title'
        );
    }

    protected function getFormType()
    {
        return 'bigfoot_bundle_contentbundle_staticcontenttype';
    }

    /**
     * Lists all StaticContent entities.
     *
     * @Route("/", name="admin_staticcontent")
     * @Method("GET")
     * @Template("BigfootCoreBundle:crud:index.html.twig")
     */
    public function indexAction()
    {
        return $this->doIndex();
    }
    /**
     * Creates a new StaticContent entity.
     *
     * @Route("/", name="admin_staticcontent_create")
     * @Method("POST")
     * @Template("BigfootContentBundle:StaticContent:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new StaticContent();
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
     * Displays a form to create a new StaticContent entity.
     *
     * @Route("/new", name="admin_staticcontent_new")
     * @Method("GET")
     * @Template("BigfootCoreBundle:crud:new.html.twig")
     */
    public function newAction()
    {
        return $this->doNew();
    }

    /**
     * Displays a form to create a new StaticContent entity.
     *
     * @Route("/colorbox-new", name="admin_staticcontent_colorbox_new")
     * @Method("GET")
     * @Template("BigfootCoreBundle:crud:new.html.twig")
     */
    public function newColorboxAction()
    {
        $arrayNew = $this->doNew();
        $arrayNew['full_page'] = true;

        return $arrayNew;
    }

    /**
     * Displays a form to edit an existing StaticContent entity into a colorbox
     *
     * @Route("/colorbox-staticcontent/{id}/{mode}/{id_sidebar}/{position}", name="admin_staticcontent_colorbox_edit")
     * @Method("GET")
     * @Template("BigfootContentBundle:StaticContent:edit-colorbox.html.twig")
     */
    public function editColorboxAction($id, $mode, $id_sidebar, $position)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BigfootContentBundle:StaticContent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaticContent entity.');
        }

        $editForm = $this->createForm('bigfoot_bundle_contentbundle_staticcontenttype', $entity);
        $deleteForm = $this->createDeleteForm($id);

        if ($mode == 'new') {
            $form_action    = $this->container->get('router')->generate('admin_staticcontent_create');
            $form_method    = 'POST';
            $form_submit    = 'Create';
            $form_title     = 'New Static Content';
        }
        else {
            $form_action    = $this->container->get('router')->generate('admin_staticcontent_update', array(
                'id' => $id
            ));
            $form_method    = 'PUT';
            $form_submit    = 'Edit';
            $form_title     = 'Edit Static Content';
        }

        return array(
            'entity'                => $entity,
            'id'                    => $id,
            'position'              => $position,
            'id_sidebar'            => $id_sidebar,
            'form'                  => $editForm->createView(),
            'delete_form'           => $deleteForm->createView(),
            'form_action'           => $form_action,
            'form_method'           => $form_method,
            'form_submit'           => $form_submit,
            'form_title'            => $form_title,
            'full_page'             => true,
        );
    }

    /**
     * Edits an existing StaticContent entity.
     *
     * @Route("/{id}", name="admin_staticcontent_update")
     * @Method("PUT")
     * @Template("BigfootContentBundle:StaticContent:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BigfootContentBundle:StaticContent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaticContent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm('bigfoot_bundle_contentbundle_staticcontenttype', $entity);
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
     * Deletes a StaticContent entity.
     *
     * @Route("/delete/{id}", name="admin_staticcontent_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BigfootContentBundle:StaticContent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaticContent entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_dashboard'));
    }

    /**
     * Creates a form to delete a StaticContent entity by id.
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
