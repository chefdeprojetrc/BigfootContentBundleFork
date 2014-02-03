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
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;

/**
 * Sidebar controller.
 *
 * @Cache(maxage="0", smaxage="0", public="false")
 * @Route("/admin/sidebar")
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
            'id'    => 'ID',
            'title' => 'Title'
        );
    }

    protected function getFormType()
    {
        return 'bigfoot_bundle_contentbundle_sidebartype';
    }

    /**
     * @Route("/", name="admin_sidebar")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('BigfootContentBundle:Dashboard:default.html.twig');
    }

    /**
     * Creates a new Sidebar entity.
     *
     * @Route("/", name="admin_sidebar_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        return $this->doCreate($request);
    }

    /**
     * Displays a form to create a new Sidebar entity.
     *
     * @Route("/new", name="admin_sidebar_new")
     * @Method("GET")
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
     */
    public function updateAction(Request $request, $id)
    {
        return $this->doUpdate($request, $id);
    }

    /**
     * Deletes a Sidebar entity.
     *
     * @Route("/delete/{id}", name="admin_sidebar_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->doDelete($request, $id);
    }
}
