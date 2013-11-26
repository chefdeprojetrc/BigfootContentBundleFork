<?php

namespace Bigfoot\Bundle\ContentBundle\Services;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

use Bigfoot\Bundle\ContentBundle\Entity\Widget;
use Bigfoot\Bundle\ContentBundle\Entity\StaticContent;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;
use Bigfoot\Bundle\ContentBundle\Form\WidgetType;
use Bigfoot\Bundle\ContentBundle\Form\StaticContentType;

use Exception;


/**
 * Service DisplayContent
 *
 * @Route("/")
 *
 */
class DisplayContent
{

    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function displayContentAction($type,$slug)
    {
        if ($type == 'widget') {
            $display = $this->displayWidgetAction($slug);
        }
        elseif ($type == 'static_content') {
            $display = $this->displayStaticContentAction($slug);
        }
        elseif ($type == 'page') {
            $display = $this->displayPageAction($slug);
        }
        else if ($type == 'sidebar') {
            $display = $this->displaySidebarAction($slug);
        }

        return $display;
    }

    /**
     * Display a Widget
     */
    private function displayWidgetAction($slug)
    {
        $em = $this->container->get('doctrine')->getManager();

        $widget = $em->getRepository('BigfootContentBundle:Widget')->findOneBy(array('slug' => $slug));

        if (!$widget) {
            throw new NotFoundHttpException('Unable to find Widget entity.');
        }

        $tabParameter = $widget->getParams();

        return $this->container->get('templating')->render($widget->getTemplate()->getRoute(), array(
            'widget' => $widget,
            'tabParameter' => $tabParameter,
        ));
    }

    /**
     * Display a Static Content
     */
    private function displayStaticContentAction($slug)
    {
        $em = $this->container->get('doctrine')->getManager();

        $staticcontent = $em->getRepository('BigfootContentBundle:StaticContent')->findOneBy(array('slug' => $slug));

        if (!$staticcontent) {
            throw new NotFoundHttpException('Unable to find StaticContent entity.');
        }

        return $this->container->get('templating')->render($staticcontent->getTemplate()->getRoute(), array(
            'staticcontent' => $staticcontent
        ));
    }

    /**
     * Display a Page
     */
    private function displayPageAction($slug)
    {
        $em = $this->container->get('doctrine')->getManager();

        $page = $em->getRepository('BigfootContentBundle:Page')->findOneBy(array('slug' => $slug));

        if (!$page) {
            throw new NotFoundHttpException('Unable to find Page entity.');
        }

        return $this->container->get('templating')->render($page->getTemplate(), array(
            'page' => $page,
        ));
    }

    /**
     * Display a Sidebar
     */
    public function displaySidebarAction($slug)
    {

        $em = $this->container->get('doctrine')->getManager();
        $sidebar = $em->getRepository('BigfootContentBundle:Sidebar')->findOneBy(array('slug' => $slug));

        if (!$sidebar) {
            throw new NotFoundHttpException('Unable to find Sidebar entity.');
        }

        $tabBlock = $sidebar->getBlock();
        $tabFinal = array();

        foreach ($tabBlock as $block) {

            if ($block instanceof Widget) {

                $parameters = $block->getParams();
                $widget = $this->container->getParameter('bigfoot_content.widgets');
                $widget_name = $widget[$block->getName()];
                $widget = new $widget_name($this->container);
                $widget->setParameters($parameters);

                $tabFinal[] = array(
                    'type' => 'widget',
                    'template' => $block->getTemplate()->getRoute(),
                    'data' => $widget->load()
                );
            }
            else if ($block instanceof StaticContent) {
                $tabFinal[] = array(
                    'type' => 'static_content',
                    'slug' => $block->getSlug(),
                );
            }
        }

        return $this->container->get('templating')->render($sidebar->getTemplate()->getRoute(), array(
            'tabFinal' => $tabFinal,
        ));
    }
}
