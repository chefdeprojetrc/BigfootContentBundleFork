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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


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

    public function displayContentAction($type, $slug, $parameters = array())
    {
        if ($type == 'widget') {
            $display = $this->displayWidgetAction($slug, $parameters);
        }
        elseif ($type == 'static_content') {
            $display = $this->displayStaticContentAction($slug, $parameters);
        }
        elseif ($type == 'page') {
            $display = $this->displayPageAction($slug, $parameters);
        }
        else if ($type == 'sidebar') {
            $display = $this->displaySidebarAction($slug, $parameters);
        }

        return $display;
    }

    /**
     * Display a Widget
     */
    private function displayWidgetAction($slug, $parameters = array())
    {
        $em = $this->container->get('doctrine')->getManager();

        $widgetEntity = $em->getRepository('BigfootContentBundle:Widget')->findOneBy(array('slug' => $slug));

        if (!$widgetEntity) {
            throw new NotFoundHttpException('Unable to find Widget entity.');
        }

        $widgetsList = $this->container->getParameter('bigfoot_content.widgets');

        if (!isset($widgetsList[$widgetEntity->getName()])) {
            return '';
        }

        $widgetClassName = $widgetsList[$widgetEntity->getName()];
        $widget = new $widgetClassName($this->container);
        $widget->addParameters($parameters);
        if ($params = $widgetEntity->getParams() and is_array($params)) {
            $widget->addParameters($widgetEntity->getParams());
        }

        return $this->container->get('templating')->render($widgetEntity->getTemplate()->getRoute(), $widget->load());
    }

    /**
     * Display a Static Content
     */
    private function displayStaticContentAction($slug, $parameters = array())
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
    private function displayPageAction($slug, $parameters = array())
    {

        $em = $this->container->get('doctrine')->getManager();

        $page = $em->getRepository('BigfootContentBundle:Page')->findOneBy(array('slug' => $slug));

        if (!$page) {
            throw new NotFoundHttpException('Unable to find Page entity.');
        }

        return $this->container->get('templating')->render($page->getTemplate()->getRoute(), array(
            'page' => $page,
        ));
    }

    /**
     * Display a Sidebar
     */
    public function displaySidebarAction($slug, $parameters = array())
    {

        $em = $this->container->get('doctrine')->getManager();
        $sidebar = $em->getRepository('BigfootContentBundle:Sidebar')->findOneBy(array('slug' => $slug));

        if (!$sidebar) {
            throw new NotFoundHttpException('Unable to find Sidebar entity.');
        }

        $tabBlock = $sidebar->getBlock();
        $blocks = array();

        foreach ($tabBlock as $block) {
            $type = 'static_content';
            if ($block instanceof Widget) {
                $type = 'widget';
            }

            $blocks[] = array(
                'type' => $type,
                'slug' => $block->getSlug(),
            );
        }

        return $this->container->get('templating')->render($sidebar->getTemplate()->getRoute(), array(
            'blocks' => $blocks,
            'parameters' => $parameters,
        ));
    }
}
