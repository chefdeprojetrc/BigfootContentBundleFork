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
use Bigfoot\Bundle\ContentBundle\Entity\Widget;

/**
 * Widget controller.
 *
 * @Cache(maxage="0", smaxage="0", public="false")
 * @Route("/admin/widget")
 */
class WidgetController extends CrudController
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
        return 'admin_widget';
    }

    /**
     * Must return the entity full name (eg. BigfootCoreBundle:Tag).
     *
     * @return string
     */
    protected function getEntity()
    {
        return 'BigfootContentBundle:Widget';
    }

    /**
     * Must return an associative array field name => field label.
     *
     * @return array
     */
    protected function getFields()
    {
        return array(
            'id' => 'ID'
        );
    }

    protected function getFormType()
    {
        return 'bigfoot_bundle_contentbundle_widgettype';
    }

    /**
     * Lists all Widget entities.
     *
     * @Route("/", name="admin_widget")
     * @Method("GET")
     * @Template("BigfootCoreBundle:Crud:index.html.twig")
     */
    public function indexAction()
    {
        return $this->doIndex();
    }
    /**
     * Creates a new Widget entity.
     *
     * @Route("/{form_name}/", name="admin_widget_create")
     * @Method("POST")
     * @Template("BigfootContentBundle:Widget:new.html.twig")
     */
    public function createAction(Request $request,$form_name)
    {
        $entity       = new Widget();
        $widget       = $this->container->getParameter('bigfoot_content.widgets');
        $form         = $request->get($form_name);
        $widget_name  = $widget[$form['name']];
        $widget       = new $widget_name($this->container);
        $formTypeName = $widget->getParametersType();
        $form         = $this->container->get('form.factory')->create(new $formTypeName($this->container), $entity);
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
     * Displays a form to create a new Widget entity.
     *
     * @Route("/colorbox-new/{widget_name}/{mode}/{id_sidebar}/{position}", name="admin_widget_colorbox_new")
     * @Method("GET")
     * @Template("BigfootContentBundle:Widget:new-colorbox.html.twig")
     */
    public function newColorboxAction($widget_name, $mode, $id_sidebar, $position)
    {
        $widget      = $this->container->getParameter('bigfoot_content.widgets');
        $widget_name = $widget[$widget_name];
        $widgetTemp  = new $widget_name($this->container);
        $entity      = new Widget();

        $entity->setRoute($widgetTemp->getRoute());
        $entity->setLabel($widgetTemp->getLabel());
        $entity->setName($widgetTemp->getName());
        $entity->setParams($widgetTemp->getDefaultParameters());

        $formTypeName = $widgetTemp->getParametersType();
        $widgetObject = new $formTypeName($this->container);
        $form_name    = $widgetObject->getName();
        $form         = $this->container->get('form.factory')->create($widgetObject, $entity);

        $form_action    = $this->container->get('router')->generate('admin_widget_create', array(
            'form_name' => $form_name
        ));
        $form_method    = 'POST';
        $form_submit    = 'Create';
        $form_title     = 'New Widget';

        return array(
            'form_action' => $form_action,
            'form_method' => $form_method,
            'form_submit' => $form_submit,
            'form_title'  => $form_title,
            'id_sidebar'  => $id_sidebar,
            'position'    => $position,
            'mode'        => $mode,
            'entity'      => $entity,
            'form'        => $form->createView(),
            'form_name'   => $form_name,
            'isAjax'      => true
        );
    }

    /**
     * Displays a form to edit an existing Widget entity.
     *
     * @Route("/colorbox-widget/{id}/{widget_name}/{form_name}/{id_sidebar}/{position}/edit", name="admin_widget_colorbox_edit")
     * @Method("GET")
     * @Template("BigfootContentBundle:Widget:edit-colorbox.html.twig")
     */
    public function editColorboxAction($id, $widget_name, $form_name, $id_sidebar, $position)
    {
        $em = $this->container->get('doctrine')->getManager();
        $entity = $em->getRepository('BigfootContentBundle:Widget')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find Widget entity.');
        }

        $editForm   = $this->container->get('form.factory')->create($form_name, $entity);
        $deleteForm = $this->createDeleteForm($id);

        $form_action = $this->container->get('router')->generate('admin_widget_update', array(
            'id'        => $id,
            'form_name' => $form_name
        ));

        $form_method = 'PUT';
        $form_submit = 'Edit';
        $form_title  = 'Edit Widget';

        return array(
            'entity'      => $entity,
            'id'          => $id,
            'id_sidebar'  => $id_sidebar,
            'position'    => $position,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'form_action' => $form_action,
            'form_method' => $form_method,
            'form_submit' => $form_submit,
            'form_title'  => $form_title,
            'isAjax'      => true,
        );
    }

    /**
     * Edits an existing Widget entity.
     *
     * @Route("/{id}/{form_name}", name="admin_widget_update")
     * @Method("PUT")
     * @Template("BigfootContentBundle:Widget:edit.html.twig")
     */
    public function updateAction(Request $request, $id, $form_name)
    {
        $em = $this->container->get('doctrine')->getManager();
        $entity = $em->getRepository('BigfootContentBundle:Widget')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find Widget entity.');
        }

        $deleteForm   = $this->createDeleteForm($id);
        $widget       = $this->container->getParameter('bigfoot_content.widgets');
        $form         = $request->get($form_name);
        $widget_name  = $widget[$form['name']];
        $widget       = new $widget_name($this->container);
        $formTypeName = $widget->getParametersType();
        $formObject   = new $formTypeName($this->container);
        $editForm     = $this->container->get('form.factory')->create($formObject, $entity);
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
            'form_name'   => $formObject->getName(),
        );
    }
    /**
     * Deletes a Widget entity.
     *
     * @Route("/delete/{id}", name="admin_widget_delete")
     * @Method("GET|DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $this->doDelete($request, $id);
    }

    /**
     * Creates a form to delete a Widget entity by id.
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
