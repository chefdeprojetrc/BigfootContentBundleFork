<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Bigfoot\Bundle\ContentBundle\Entity\SidebarCategory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Bigfoot\Bundle\CoreBundle\Controller\CrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * SidebarCategory controller.
 *
 * @Route("/admin/contentbundle_sidebar_category")
 */
class SidebarCategoryController extends CrudController
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'admin_contentbundle_sidebar_category';
    }

    /**
     * @return string
     */
    protected function getEntity()
    {
        return 'BigfootContentBundle:SidebarCategory';
    }

    protected function getFields()
    {
        return array(
            'id'    => 'ID',
            'title' => 'Title'
        );
    }
    /**
     * Lists all SidebarCategory entities.
     *
     * @Route("/", name="admin_contentbundle_sidebar_category")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->doIndex();
    }
    /**
     * Creates a new SidebarCategory entity.
     *
     * @Route("/", name="admin_contentbundle_sidebar_category_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        return $this->doCreate($request);
    }

    /**
     * Displays a form to create a new SidebarCategory entity.
     *
     * @Route("/new", name="admin_contentbundle_sidebar_category_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $arrayNew = $this->doNew();
        $arrayNew['isAjax'] = true;

        return $arrayNew;
    }

    /**
     * Displays a form to edit an existing SidebarCategory entity.
     *
     * @Route("/{id}/edit", name="admin_contentbundle_sidebar_category_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $arrayEdit = $this->doEdit($id);
        $arrayEdit['isAjax'] = true;

        return $arrayEdit;
    }

    /**
     * Edits an existing SidebarCategory entity.
     *
     * @Route("/{id}", name="admin_contentbundle_sidebar_category_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        return $this->doUpdate($request, $id);
    }

    /**
     * Deletes a SidebarCategory entity.
     *
     * @Route("/delete/{id}", name="admin_contentbundle_sidebar_category_delete")
     * @Method("GET|DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->doDelete($request, $id);
    }
}
