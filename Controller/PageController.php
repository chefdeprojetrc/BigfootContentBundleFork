<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Doctrine\Common\Collections\ArrayCollection;

use Bigfoot\Bundle\CoreBundle\Controller\CrudController;
use Bigfoot\Bundle\CoreBundle\Util\StringManager;

/**
 * Page controller.
 *
 * @Cache(maxage="0", smaxage="0", public="false")
 * @Route("/page")
 */
class PageController extends CrudController
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'admin_page';
    }

    /**
     * @return string
     */
    protected function getEntity()
    {
        return 'BigfootContentBundle:Page';
    }

    protected function getFields()
    {
        return array(
            'id'       => 'ID',
            'template' => 'Template',
            'name'     => 'Name',
        );
    }

    public function getFormTemplate()
    {
        return $this->getEntity().':edit.html.twig';
    }

    /**
     * Add sucess flash
     */
    protected function addSuccessFlash($message)
    {
        $this->addFlash(
            'success',
            $this->renderView(
                $this->getThemeBundle().':admin:flash.html.twig',
                array(
                    'icon'    => 'ok',
                    'heading' => 'Success!',
                    'message' => $this->getTranslator()->trans($message, array('%entity%' => $this->getEntityName())),
                    'actions' => array(
                        array(
                            'route' => $this->generateUrl($this->getRouteNameForAction('index')),
                            'label' => 'Back to the listing',
                            'type'  => 'success',
                        ),
                        array(
                            'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'page')),
                            'label' => $this->getTranslator()->trans('Add a new %entity%', array('%entity%' => $this->getEntityName())),
                            'type'  => 'success',
                        )
                    )
                )
            )
        );
    }

    /**
     * Return array of allowed global actions
     *
     * @return array
     */
    protected function getGlobalActions()
    {
        $globalActions = array();

        if (method_exists($this, 'newAction')) {
            $globalActions['new'] = array(
                'label'      => 'Add',
                'route'      => 'admin_content_template_choose',
                'parameters' => array('contentType' => 'page'),
                'icon'       => 'pencil',
            );
        }

        return $globalActions;
    }

    /**
     * Lists Page entities.
     *
     * @Route("/", name="admin_page")
     */
    public function indexAction()
    {
        return $this->doIndex();
    }

    /**
     * New Page entity.
     *
     * @Route("/new/{template}", name="admin_page_new")
     */
    public function newAction(Request $request, $template)
    {
        $templates    = $this->container->getParameter('bigfoot_content.templates.page');
        $values       = explode('.', $template);
        $templateName = StringManager::camelize($values[1]);
        $page         = $templates[$values[0]]['class'].'\\'.$templateName;
        $page         = new $page();
        $templateType = implode('_', $values);
        $form         = $this->createForm('admin_page_'.$templateType, $page);
        $action       = $this->generateUrl('admin_page_new', array('template' => implode('.', $values)));

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->persistAndFlush($page);

                return $this->redirect($this->generateUrl('admin_page_edit', array('id' => $page->getId())));
            }
        }

        return $this->renderForm($form, $action, $page);
    }

    /**
     * Edit Page entity.
     *
     * @Route("/edit/{id}", name="admin_page_edit")
     */
    public function editAction(Request $request, $id)
    {
        $page = $this->getRepository($this->getEntity())->find($id);

        if (!$page) {
            throw new NotFoundHttpException('Unable to find Page entity.');
        }

        $form       = $this->createForm('admin_page_'.$page->getParentTemplate().'_'.$page->getSlugTemplate(), $page);
        $action     = $this->generateUrl('admin_page_edit', array('id' => $page->getId()));
        $dbBlocks   = new ArrayCollection();
        $dbSidebars = new ArrayCollection();

        foreach ($page->getBlocks() as $block) {
            $dbBlocks->add($block);
        }

        foreach ($page->getSidebars() as $sidebar) {
            $dbSidebars->add($sidebar);
        }

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                foreach ($dbBlocks as $block) {
                    if ($page->getBlocks()->contains($block) === false) {
                        $page->getBlocks()->removeElement($block);
                        $this->getEntityManager()->remove($block);
                    }
                }

                foreach ($dbSidebars as $sidebar) {
                    if ($page->getSidebars()->contains($sidebar) === false) {
                        $page->getSidebars()->removeElement($sidebar);
                        $this->getEntityManager()->remove($sidebar);
                    }
                }

                $this->persistAndFlush($page);

                return $this->redirect($this->generateUrl('admin_page_edit', array('id' => $page->getId())));
            }
        }

        return $this->renderForm($form, $action, $page);
    }

    /**
     * Delete Page entity.
     *
     * @Route("/delete/{id}", name="admin_page_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->doDelete($request, $id);
    }
}
