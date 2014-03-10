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
     * @Route("/choose/{contentType}", name="admin_content_template_choose")
     * @Template()
     */
    public function chooseAction(Request $request, $contentType = null)
    {
        $templates = $this->container->getParameter('bigfoot_content.templates.'.$contentType);
        $form      = $this->createForm('admin_template', null, array('data' => $templates, 'contentType' => $contentType));

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $template = $form['template']->getData();

                if ($template) {
                    return $this->redirect($this->generateUrl('admin_'.$contentType.'_new', array('template' => $template)));
                }
            }
        }

        return array(
            'form'        => $form->createView(),
            'form_method' => 'POST',
            'form_title'  => $this->getTranslator()->trans('%entity% creation', array('%entity%' => ucfirst($contentType))),
            'form_action' => $this->generateUrl('admin_content_template_choose', array('contentType' => $contentType)),
            'form_submit' => 'Submit',
            'form_cancel' => 'admin_'.$contentType,
        );
    }
}
