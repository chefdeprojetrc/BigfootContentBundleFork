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
     * Creates a new Template entity.
     *
     * @Route("/", name="admin_contentbundle_template_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        return $this->doCreate($request);
    }

    /**
     * Displays a form to create a new Template entity.
     *
     * @Route("/new", name="admin_contentbundle_template_new")
     * @Method("GET")
     */
    public function newAction()
    {
        return $this->doNew();
    }

    /**
     * Displays a form to edit an existing Template entity.
     *
     * @Route("/{id}/edit", name="admin_contentbundle_template_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        return $this->doEdit($id);
    }

    /**
     * Edits an existing Template entity.
     *
     * @Route("/{id}", name="admin_contentbundle_template_update")
     * @Method("GET|POST|PUT")
     */
    public function updateAction(Request $request, $id)
    {
        return $this->doUpdate($request, $id);
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
