<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

use Bigfoot\Bundle\CoreBundle\Controller\CrudController;
use Bigfoot\Bundle\CoreBundle\Util\StringManager;

/**
 * Block controller.
 *
 * @Cache(maxage="0", smaxage="0", public="false")
 * @Route("/block")
 */
class BlockController extends CrudController
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'admin_block';
    }

    /**
     * @return string
     */
    protected function getEntity()
    {
        return 'BigfootContentBundle:Block';
    }

    protected function getFields()
    {
        return array(
            'id'       => 'ID',
            'template' => 'Template',
            'name'     => 'Name',
        );
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
                            'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'block')),
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
                'parameters' => array('contentType' => 'block'),
                'icon'       => 'pencil',
            );
        }

        return $globalActions;
    }

    /**
     * Lists Block entities.
     *
     * @Route("/", name="admin_block")
     */
    public function indexAction()
    {
        return $this->doIndex();
    }

    /**
     * New Block entity.
     *
     * @Route("/new/{template}", name="admin_block_new")
     */
    public function newAction(Request $request, $template)
    {
        $templates    = $this->container->getParameter('bigfoot_content.templates.block');
        $values       = explode('.', $template);
        $templateName = StringManager::camelize($values[1]);
        $block        = $templates[$values[0]]['class'].'\\'.$templateName;
        $block        = new $block();
        $templateType = implode('_', $values);
        $form         = $this->createForm('admin_block_'.$templateType, $block);
        $action       = $this->generateUrl('admin_block_new', array('template' => implode('.', $values)));

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->persistAndFlush($block);

                return $this->redirect($this->generateUrl('admin_block_edit', array('id' => $block->getId())));
            }
        }

        return $this->renderForm($form, $action, $block);
    }

    /**
     * Edit Block entity.
     *
     * @Route("/edit/{id}", name="admin_block_edit")
     */
    public function editAction(Request $request, $id)
    {
        $block = $this->getRepository($this->getEntity())->find($id);

        if (!$block) {
            throw new NotFoundHttpException('Unable to find block entity.');
        }

        $form   = $this->createForm('admin_block_'.$block->getParentTemplate().'_'.$block->getSlugTemplate(), $block);
        $action = $this->generateUrl('admin_block_edit', array('id' => $block->getId()));

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->persistAndFlush($block);

                return $this->redirect($this->generateUrl('admin_block_edit', array('id' => $block->getId())));
            }
        }

        return $this->renderForm($form, $action, $block);
    }

    /**
     * Delete Block entity.
     *
     * @Route("/delete/{id}", name="admin_block_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->doDelete($request, $id);
    }
}
