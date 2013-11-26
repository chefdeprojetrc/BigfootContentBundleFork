<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Bigfoot\Bundle\CoreBundle\Crud\CrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
        return array('id' => 'ID', 'type' => 'Type', 'name' => 'Name', 'route' => 'Route');
    }
    /**
     * Lists all Template entities.
     *
     * @Route("/", name="admin_contentbundle_template")
     * @Method("GET")
     * @Template("BigfootCoreBundle:crud:index.html.twig")
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
     * @Template("BigfootCoreBundle:crud:new.html.twig")
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
     * @Template("BigfootCoreBundle:crud:new.html.twig")
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
     * @Template("BigfootCoreBundle:crud:edit.html.twig")
     */
    public function editAction($id)
    {
        return $this->doEdit($id);
    }

    /**
     * Edits an existing Template entity.
     *
     * @Route("/{id}", name="admin_contentbundle_template_update")
     * @Method("PUT")
     * @Template("BigfootCoreBundle:crud:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        return $this->doUpdate($request, $id);
    }
    /**
     * Deletes a Template entity.
     *
     * @Route("/{id}", name="admin_contentbundle_template_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->doDelete($request, $id);
    }
}
