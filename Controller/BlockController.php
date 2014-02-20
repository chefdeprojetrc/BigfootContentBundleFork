<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

use Bigfoot\Bundle\CoreBundle\Controller\CrudController;

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
     * @return string
     */
    public function getRouteNameForAction($action)
    {
        if (!$action or $action == 'index') {
            return $this->getName();
        } elseif ($action == 'new') {
            return 'admin_content_template_choose';
        }

        return sprintf('%s_%s', $this->getName(), $action);
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
        $templates = $this->container->getParameter('bigfoot_content.templates')['block'];
        $block      = $templates[$template];
        $block      = new $block();
        $form      = $this->createForm('admin_block_'.$template, $block);
        $action    = $this->generateUrl('admin_block_new', array('template' => $template));

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

        $form   = $this->createForm('admin_block_'.$block->getSlugTemplate(), $block);
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
