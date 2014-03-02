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
 * Sidebar controller.
 *
 * @Cache(maxage="0", smaxage="0", public="false")
 * @Route("/sidebar")
 */
class SidebarController extends CrudController
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'admin_sidebar';
    }

    /**
     * @return string
     */
    protected function getEntity()
    {
        return 'BigfootContentBundle:Sidebar';
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
                            'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'sidebar')),
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
                'parameters' => array('contentType' => 'sidebar'),
                'icon'       => 'pencil',
            );
        }

        return $globalActions;
    }

    /**
     * Lists Sidebar entities.
     *
     * @Route("/", name="admin_sidebar")
     */
    public function indexAction()
    {
        return $this->doIndex();
    }

    /**
     * New Sidebar entity.
     *
     * @Route("/new/{template}", name="admin_sidebar_new")
     */
    public function newAction(Request $request, $template)
    {
        $pTemplate = $this->getParentTemplate($template);
        $templates = $this->getTemplates($pTemplate);
        $sidebar   = $templates['class'];
        $sidebar   = new $sidebar();
        $sidebar->setTemplate($template);

        $action = $this->generateUrl('admin_sidebar_new', array('template' => $template));
        $form   = $this->createForm(
            'admin_sidebar_template_'.$pTemplate,
            $sidebar,
            array(
                'template'  => $template,
                'templates' => $templates
            )
        );

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->persistAndFlush($sidebar);

                return $this->redirect($this->generateUrl('admin_sidebar_edit', array('id' => $sidebar->getId())));
            }
        }

        return $this->renderForm($form, $action, $sidebar);
    }

    /**
     * Edit Sidebar entity.
     *
     * @Route("/edit/{id}", name="admin_sidebar_edit")
     */
    public function editAction(Request $request, $id)
    {
        $sidebar = $this->getRepository($this->getEntity())->find($id);

        if (!$sidebar) {
            throw new NotFoundHttpException('Unable to find Sidebar entity.');
        }

        $form = $this->createForm(
            'admin_sidebar_template_'.$sidebar->getParentTemplate(),
            $sidebar,
            array(
                'template'  => $template,
                'templates' => $templates
            )
        );

        $action   = $this->generateUrl('admin_sidebar_edit', array('id' => $sidebar->getId()));
        $dbBlocks = new ArrayCollection();

        foreach ($sidebar->getBlocks() as $block) {
            $dbBlocks->add($block);
        }

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                foreach ($dbBlocks as $block) {
                    if ($sidebar->getBlocks()->contains($block) === false) {
                        $sidebar->getBlocks()->removeElement($block);
                        $this->getEntityManager()->remove($block);
                    }
                }

                $this->persistAndFlush($sidebar);

                return $this->redirect($this->generateUrl('admin_sidebar_edit', array('id' => $sidebar->getId())));
            }
        }

        return $this->renderForm($form, $action, $sidebar);
    }

    /**
     * Delete Sidebar entity.
     *
     * @Route("/delete/{id}", name="admin_sidebar_delete")
     */
    public function deleteAction(Request $request, $id)
    {
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
        $templates = $this->container->getParameter('bigfoot_content.templates.sidebar');

        return $templates[$parent];
    }
}
