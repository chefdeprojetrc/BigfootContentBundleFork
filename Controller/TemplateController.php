<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

use Bigfoot\Bundle\CoreBundle\Controller\BaseController;

/**
 * Template controller.
 *
 * @Cache(maxage="0", smaxage="0", public="false")
 * @Route("/content/template")
 */
class TemplateController extends BaseController
{
    /**
     * Choose template.
     *
     * @Route("/choose", name="admin_content_template_choose")
     */
    public function chooseAction(Request $request)
    {
        $contentType = $this->getSession()->get('contentType');

        if (!$contentType) {
            $contentType = $this->getContentType($request);
            $this->getSession()->set('contentType', $contentType);
        }

        $templates     = $this->container->getParameter('bigfoot_content.templates');
        $typeTemplates = $templates[$contentType];
        $form          = $this->createForm('admin_template', null, array('data' => $typeTemplates));

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $template = $form['template']->getData();

                if ($template && isset($typeTemplates[$template])) {
                    $this->getSession()->set('contentType', null);

                    return $this->redirect($this->generateUrl('admin_'.$contentType.'_new', array('template' => $template)));
                }
            }
        }

        return $this->render(
            $this->getThemeBundle().':crud:form.html.twig',
            array(
                'form'        => $form->createView(),
                'form_method' => 'POST',
                'form_title'  => $this->getTranslator()->trans('%entity% creation', array('%entity%' => ucfirst($contentType))),
                'form_action' => $this->generateUrl('admin_content_template_choose'),
                'form_submit' => 'Submit',
                'form_cancel' => 'admin_'.$contentType,
            )
        );
    }

    public function getContentType(Request $request)
    {
        if (preg_match('/page/', $request->headers->get('referer'))) {
            return 'page';
        } elseif (preg_match('/sidebar/', $request->headers->get('referer'))) {
            return 'sidebar';
        } elseif (preg_match('/block/', $request->headers->get('referer'))) {
            return 'block';
        } else {
            throw new NotFoundHttpException('Unable to find template.');
        }
    }
}
