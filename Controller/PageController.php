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
        $pTemplate = $this->getParentTemplate($template);
        $templates = $this->getTemplates($pTemplate);
        $page      = $templates['class'];
        $page      = new $page();
        $page->setTemplate($template);

        $action = $this->generateUrl('admin_page_new', array('template' => $template));
        $form   = $this->createForm(
            'admin_page_template_'.$pTemplate,
            $page,
            array(
                'template'  => $template,
                'templates' => $templates
            )
        );

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->persistAndFlush($page);

                $this->addSuccessFlash(
                    'Page successfully added!',
                    $this->generateUrl('admin_content_template_choose', array('contentType' => 'page'))
                );

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

        $templates = $this->getTemplates($page->getParentTemplate());
        $action    = $this->generateUrl('admin_page_edit', array('id' => $page->getId()));
        $form      = $this->createForm(
            'admin_page_template_'.$page->getParentTemplate(),
            $page,
            array(
                'template'  => $page->getSlugTemplate(),
                'templates' => $templates
            )
        );

        $dbBlocks    = new ArrayCollection();
        $dbBlocks2   = new ArrayCollection();
        $dbBlocks3   = new ArrayCollection();
        $dbBlocks4   = new ArrayCollection();
        $dbBlocks5   = new ArrayCollection();
        $dbSidebars  = new ArrayCollection();
        $dbSidebars2 = new ArrayCollection();
        $dbSidebars3 = new ArrayCollection();
        $dbSidebars4 = new ArrayCollection();
        $dbSidebars5 = new ArrayCollection();

        foreach ($page->getBlocks() as $block) {
            $dbBlocks->add($block);
        }

        foreach ($page->getBlocks2() as $block2) {
            $dbBlocks2->add($block2);
        }

        foreach ($page->getBlocks3() as $block3) {
            $dbBlocks3->add($block3);
        }

        foreach ($page->getBlocks4() as $block4) {
            $dbBlocks4->add($block4);
        }

        foreach ($page->getBlocks5() as $block5) {
            $dbBlocks5->add($block5);
        }

        foreach ($page->getSidebars() as $sidebar) {
            $dbSidebars->add($sidebar);
        }

        foreach ($page->getSidebars2() as $sidebar2) {
            $dbSidebars2->add($sidebar2);
        }

        foreach ($page->getSidebars3() as $sidebar3) {
            $dbSidebars3->add($sidebar3);
        }

        foreach ($page->getSidebars4() as $sidebar4) {
            $dbSidebars4->add($sidebar4);
        }

        foreach ($page->getSidebars5() as $sidebar5) {
            $dbSidebars5->add($sidebar5);
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

                foreach ($dbBlocks2 as $block2) {
                    if ($page->getBlocks2()->contains($block2) === false) {
                        $page->getBlocks2()->removeElement($block2);
                        $this->getEntityManager()->remove($block2);
                    }
                }

                foreach ($dbBlocks3 as $block3) {
                    if ($page->getBlocks3()->contains($block3) === false) {
                        $page->getBlocks3()->removeElement($block3);
                        $this->getEntityManager()->remove($block3);
                    }
                }

                foreach ($dbBlocks4 as $block4) {
                    if ($page->getBlocks4()->contains($block4) === false) {
                        $page->getBlocks4()->removeElement($block4);
                        $this->getEntityManager()->remove($block4);
                    }
                }

                foreach ($dbBlocks5 as $block5) {
                    if ($page->getBlocks5()->contains($block5) === false) {
                        $page->getBlocks5()->removeElement($block5);
                        $this->getEntityManager()->remove($block5);
                    }
                }

                foreach ($dbSidebars as $sidebar) {
                    if ($page->getSidebars()->contains($sidebar) === false) {
                        $page->getSidebars()->removeElement($sidebar);
                        $this->getEntityManager()->remove($sidebar);
                    }
                }

                foreach ($dbSidebars2 as $sidebar2) {
                    if ($page->getSidebars2()->contains($sidebar2) === false) {
                        $page->getSidebars2()->removeElement($sidebar2);
                        $this->getEntityManager()->remove($sidebar2);
                    }
                }

                foreach ($dbSidebars3 as $sidebar3) {
                    if ($page->getSidebars3()->contains($sidebar3) === false) {
                        $page->getSidebars3()->removeElement($sidebar3);
                        $this->getEntityManager()->remove($sidebar3);
                    }
                }

                foreach ($dbSidebars4 as $sidebar4) {
                    if ($page->getSidebars4()->contains($sidebar4) === false) {
                        $page->getSidebars4()->removeElement($sidebar4);
                        $this->getEntityManager()->remove($sidebar4);
                    }
                }

                foreach ($dbSidebars5 as $sidebar5) {
                    if ($page->getSidebars5()->contains($sidebar5) === false) {
                        $page->getSidebars5()->removeElement($sidebar5);
                        $this->getEntityManager()->remove($sidebar5);
                    }
                }

                $this->persistAndFlush($page);

                $this->addSuccessFlash(
                    'Page successfully updated!',
                    $this->generateUrl('admin_content_template_choose', array('contentType' => 'page'))
                );

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
        $entity = $this->getRepository($this->getEntity())->find($id);

        if (!$entity) {
            throw new NotFoundHttpException(sprintf('Unable to find %s entity.', $this->getEntity()));
        }

        $this->removeAndFlush($entity);

        if (!$request->isXmlHttpRequest()) {
            $this->addSuccessFlash(
                'Page successfully deleted!',
                $this->generateUrl('admin_content_template_choose', array('contentType' => 'page'))
            );


            return $this->redirect($this->generateUrl($this->getRouteNameForAction('index')));
        }

        return $this->doDelete($request, $id);
    }

    public function getParentTemplate($template)
    {
        $values = explode('_', $template);
        $end    = call_user_func('end', array_values($values));

        return str_replace('_'.$end, '', $template);
    }

    public function getTemplates($parent)
    {
        $templates = $this->container->getParameter('bigfoot_content.templates.page');

        return $templates[$parent];
    }
}
