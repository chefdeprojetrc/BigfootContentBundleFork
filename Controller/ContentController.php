<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
 * Content controller.
 *
 * @Cache(maxage="0", smaxage="0", public="false")
 * @Route("/")
 *
 */
class ContentController extends Controller
{

    /**
     * Display Dashboard
     * @Route("/content/dashboard/", name="admin_dashboard")
     * @Method("GET")
     * @Template()
     */
    public function displayDashBoardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $widgetList = array();
        $sidebarList = array();
        $widgetsConfig = $this->container->getParameter('bigfoot_content.widgets');

        foreach ($widgetsConfig as $widgetConf) {
            if (class_exists($widgetConf)) {
                $tmpObject = new $widgetConf;
                $widgetList[] = array(
                    'label'         => $tmpObject->getLabel(),
                    'name'          => $tmpObject->getName(),
                    'parameters'    => $tmpObject->getDefaultParameters(),
                );
            }
        }

        $staticContentList = $em->getRepository('BigfootContentBundle:StaticContent')->findAll();
        $sidebarRepo = $em->getRepository('BigfootContentBundle:Sidebar')->findAll();

        foreach ($sidebarRepo as $sidebar) {

            $tempBlock = $sidebar->getBlock();
            $formBlock = array();
            $type = '';

            foreach ($tempBlock as $block) {

                $form_name      = '';
                $widget_name_lbl    = '';

                if ($block instanceof Widget) {
                    $widget_name_lbl = $block->getName();
                    $widget = $this->container->getParameter('bigfoot_content.widgets');
                    $widget_name = $widget[$block->getName()];
                    $widget = new $widget_name;
                    $formTypeName = $widget->getParametersType();
                    $widgetObject = new $formTypeName($this->container);
                    $form_name = $widgetObject->getName();
                    $tempForm = $this->createForm($widgetObject, $block);
                    $type = 'widget';
                }
                else if ($block instanceof StaticContent) {
                    $tempForm = $this->createForm(new StaticContentType($this->container), $block);
                    $type = 'staticcontent';
                }

                $formBlock[] = array(
                    'id'        => $block->getId(),
                    'form'      => $tempForm->createView(),
                    'type'      => $type,
                    'position'  => $block->getPosition(),
                    'form_name' => $form_name,
                    'widget_name' => $widget_name_lbl,
                );
            }

            $sidebarList[] = array(
                'id_sidebar' => $sidebar->getId(),
                'name' => $sidebar->getTitle(),
                'formBlock' => $formBlock,
            );
        }

        return $this->render('BigfootContentBundle:Dashboard:default.html.twig', array(
            'widgetList'    => $widgetList,
            'sidebarList'   => $sidebarList,
            'staticContentList'   => $staticContentList
        ));
    }

    /**
     * Save the new block order into a sidebar
     * @Route("/content/dashboard/save_block_order", name="admin_dashboard_save_block_order")
     * @Method("GET")
     * @Template()
     */
    public function saveBlockOrderAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && $request->get('tabIdBlock') && $request->get('tabPosition') && $request->get('typeBlock')) {
            $tabIdBlock     = $request->get('tabIdBlock');
            $tabPosition    = $request->get('tabPosition');
            $typeBlock      = $request->get('typeBlock');

            $em = $this->getDoctrine()->getManager();

            foreach ($tabIdBlock as $key => $value) {
                if ($typeBlock[$key] == 'widget') {
                    $entity = $em->getRepository('BigfootContentBundle:Widget')->findOneBy(array('id' => $tabIdBlock[$key]));
                }
                else if ($typeBlock[$key] == 'staticcontent') {
                    $entity = $em->getRepository('BigfootContentBundle:StaticContent')->findOneBy(array('id' => $tabIdBlock[$key]));
                }
                $entity->setPosition($tabPosition[$key]);
                $em->persist($entity);
            }

            $em->flush();

            return new Response();
        }

        return new Response();
    }


    /**
     * Create dynamically a Widget block or a Static Content block
     * @Route("/content/dashboard/create_dynamic_block", name="admin_dashboard_create_dynamic_block")
     * @Method("GET")
     * @Template()
     */
    public function createDynamicBlockAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && $request->get('type_block') && $request->get('id_sidebar')) {

            $em = $this->getDoctrine()->getManager();

            $type_block = $request->get('type_block');
            $id_sidebar = $request->get('id_sidebar');
            $position   = ($request->get('position')) ? $request->get('position') : 0;

            if ($type_block == 'widget') {
                $widget_name = $request->get('widget_name');
                $widget = $this->container->getParameter('bigfoot_content.widgets');
                $widget_name = $widget[$widget_name];
                $widgetTemp = new $widget_name;
                $entity = new Widget();

                $entity->setRoute($widgetTemp->getRoute());
                $entity->setLabel($widgetTemp->getLabel());
                $entity->setName($widgetTemp->getName());
                $entity->setParams($widgetTemp->getDefaultParameters());

                $formTypeName = $widgetTemp->getParametersType();
                $widgetObject = new $formTypeName($this->container);
                $form_name = $widgetObject->getName();
                $form   = $this->createForm($widgetObject, $entity);
                $action_path = $this->container->get('router')->generate('admin_widget_colorbox_new',array(
                    'widget_name'   => $request->get('widget_name'),
                    'mode'          => 'new',
                    'id_sidebar'    => $id_sidebar,
                    'position'      => $position
                ));

            }
            else if ($type_block == 'staticcontent') {
                $id_block = $request->get('id_block');
                $entity = $em->getRepository('BigfootContentBundle:StaticContent')->findOneBy(array('id' => $id_block));
                $form   = $this->createForm(new StaticContentType($this->container), $entity);
                $action_path = $this->container->get('router')->generate('admin_staticcontent_colorbox_edit',array(
                    'id'                    => $id_block,
                    'mode'                  => 'new',
                    'id_sidebar'            => $id_sidebar,
                    'position'              => $position
                ));
            }

            return $this->render('BigfootContentBundle:Form:dynamicform.html.twig',array(
                'form'               => $form->createView(),
                'currentSidebar'     => $id_sidebar,
                'currentPosition'    => $position,
                'action_path'        => $action_path,
                'method'             => 'POST'
            ));
        }

    }

    /**
     * Display a Page
     * @Route("/page/display/{page_slug}/", name="content_page")
     * @Method("GET")
     * @Template()
     */
    public function displayPageAction($page_slug)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('BigfootContentBundle:Page')->findOneBy(array('slug' => $page_slug));

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        return $this->render('BigfootContentBundle:Content\Page:'.$page->getTemplate(), array(
            'page' => $page,
        ));
    }

    /**
     * Display a Widget
     * @Route("/widget/display/{widget_id}/", name="content_widget")
     * @Method("GET")
     * @Template()
     */
    public function displayWidgetAction($widget_id)
    {

        $em = $this->getDoctrine()->getManager();
        $widget = $em->getRepository('BigfootContentBundle:Widget')->find($widget_id);

        if (!$widget) {
            throw $this->createNotFoundException('Unable to find Widget entity.');
        }

        $parameters = $widget->getWidgetparameter();
        $tabParameter = array();

        foreach ($parameters as $param) {
            $tabParameter[$param->getField()] = $param->getValue();
        }

        return $this->render('BigfootContentBundle:Content\Widget:'.$widget->getTemplate(), array(
            'widget' => $widget,
            'tabParameter' => $tabParameter,
        ));
    }

    /**
     * Display a Sidebar
     * @Route("/sidebar/display/{sidebar_name}/", name="content_sidebar")
     * @Method("GET")
     * @Template()
     */
    public function displaySidebarAction($sidebar_name)
    {

        $em = $this->getDoctrine()->getManager();
        $sidebar = $em->getRepository('BigfootContentBundle:Sidebar')->findOneBy(array('title' => $sidebar_name));

        if (!$sidebar) {
            return new Response();
        }

        $widgets = $sidebar->getWidget();

        $queryBuilder = $em->getRepository('BigfootContentBundle:StaticContent')
            ->createQueryBuilder('c');
        $staticcontents = $queryBuilder
            ->where('c.sidebar = :sidebar')
            ->orderBy('c.position')
            ->setParameter('sidebar', $sidebar->getId())
            ->getQuery()->getResult()
        ;

        $tabParameter   = array();

        if (sizeof($widgets) > 0) {
            foreach ($widgets as $widget) {
                $parameters = $widget->getWidgetparameter();
                $tabParameter = array();

                foreach ($parameters as $param) {
                    $tabParameter[$widget->getId()] = array($param->getField() => $param->getValue());
                }
            }
        }

        return $this->render('BigfootContentBundle:Content\Sidebar:'.$sidebar->getTemplate(), array(
            'widgets'           => $widgets,
            'tabParameter'      => $tabParameter,
            'staticcontents'    => $staticcontents,
        ));
    }

    /**
     * Display a Static Content
     * @Route("/staticcontent/display/{staticcontent_id}/", name="content_staticcontent")
     * @Method("GET")
     * @Template()
     */
    public function displayStaticContentAction($staticcontent_id)
    {

        $em = $this->getDoctrine()->getManager();
        $staticcontent = $em->getRepository('BigfootContentBundle:StaticContent')->find($staticcontent_id);

        if (!$staticcontent) {
            throw $this->createNotFoundException('Unable to find StaticContent entity.');
        }

        return $this->render('BigfootContentBundle:Content\StaticContent:'.$staticcontent->getTemplate(), array(
            'staticcontent'           => $staticcontent
        ));
    }
}