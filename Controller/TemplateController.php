<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Bigfoot\Bundle\CoreBundle\Controller\CrudController;

/**
 * Template controller.
 *
 * @Route("/admin/contentbundle_template")
 */
class TemplateController extends CrudController
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'admin_contentbundle_template';
    }

    /**
     * @return string
     */
    protected function getEntity()
    {
        return 'BigfootContentBundle:Template';
    }

    protected function getFields()
    {
        return array(
            'id'    => 'ID',
            'type'  => 'Type',
            'name'  => 'Name',
            'route' => 'Route'
        );
    }

    /**
     * Lists all Template entities.
     *
     * @Route("/", name="admin_contentbundle_template")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->doIndex();
    }

    /**
     * Displays a form to create a new Template entity.
     *
     * @Route("/new", name="admin_contentbundle_template_new")
     * @Method("GET")
     */
    public function newAction(Request $request)
    {
        return $this->doNew($request);
    }

    /**
     * Displays a form to edit an existing Template entity.
     *
     * @Route("/edit/{id}", name="admin_contentbundle_template_edit")
     */
    public function editAction(Request $request, $id)
    {
        return $this->doEdit($request, $id);
    }

    /**
     * Deletes a Template entity.
     *
     * @Route("/{id}", name="admin_contentbundle_template_delete")
     * @Method("GET|DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->doDelete($request, $id);
    }
}
