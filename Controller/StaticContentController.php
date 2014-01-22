<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

use Bigfoot\Bundle\CoreBundle\Controller\CrudController;
use Bigfoot\Bundle\ContentBundle\Entity\StaticContent;

/**
 * StaticContent controller.
 *
 * @Cache(maxage="0", smaxage="0", public="false")
 * @Route("/admin/staticcontent")
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
     * @Template("BigfootCoreBundle:crud:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new StaticContent();
        $form = $this->container->get('form.factory')->create($this->getFormType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->container->get('doctrine')->getManager();
            $em->persist($entity);
            $em->flush();

            return new RedirectResponse($this->container->get('router')->generate('admin_dashboard'));
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
        $arrayNew['isAjax'] = true;

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
        $em = $this->container->get('doctrine')->getManager();
        $entity = $em->getRepository('BigfootContentBundle:StaticContent')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find StaticContent entity.');
        }

        $editForm = $this->container->get('form.factory')->create('bigfoot_bundle_contentbundle_staticcontenttype', $entity);
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
            'isAjax'             => true,
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
        $em = $this->container->get('doctrine')->getManager();
        $entity = $em->getRepository('BigfootContentBundle:StaticContent')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find StaticContent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->container->get('form.factory')->create('bigfoot_bundle_contentbundle_staticcontenttype', $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return new RedirectResponse($this->container->get('router')->generate('admin_dashboard'));
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

        $em = $this->container->get('doctrine')->getManager();
        $entity = $em->getRepository('BigfootContentBundle:StaticContent')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find StaticContent entity.');
        }

        $em->remove($entity);
        $em->flush();

        return new RedirectResponse($this->container->get('router')->generate('admin_dashboard'));
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
        return $this->container->get('form.factory')->createBuilder('form', array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
