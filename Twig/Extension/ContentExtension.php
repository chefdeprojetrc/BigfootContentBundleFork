<?php

namespace Bigfoot\Bundle\ContentBundle\Twig\Extension;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManager;
use Twig_Extension;
use Twig_Function_Method;
use Twig_Environment;
use BeSimple\I18nRoutingBundle\Routing\Router;

use Bigfoot\Bundle\ContentBundle\Entity\Page;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar as PageSidebar;
use Bigfoot\Bundle\ContentBundle\Entity\Block;

/**
 * ContentExtension
 */
class ContentExtension extends Twig_Extension
{
    private $twig;
    private $router;
    private $entityManager;

    /**
     * Construct ContentExtension
     */
    public function __construct(Twig_Environment $twig, Router $router, EntityManager $entityManager)
    {
        $this->twig          = $twig;
        $this->router        = $router;
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'display_page'    => new Twig_Function_Method($this, 'displayPage', array('is_safe' => array('html'))),
            'display_sidebar' => new Twig_Function_Method($this, 'displaySidebar', array('is_safe' => array('html'))),
            'display_block'   => new Twig_Function_Method($this, 'displayBlock', array('is_safe' => array('html'))),
        );
    }

    public function displayPage($page, array $parameters = null, $tpl = null)
    {
        $template = $tpl ? $tpl : $page->getParentTemplate().'/'.$page->getSlugTemplate();

        // var_dump($tpl);die();

        return $this->twig->render(
            'BigfootContentBundle:templates:page/'.$template.'.html.twig',
            array(
                'page'       => $page,
                'parameters' => $parameters,
            )
        );
    }

    public function displaySidebar($sidebar, array $parameters = null, $page = null, $tpl = null)
    {
        if (!$sidebar instanceof Sidebar) {
            $sidebar = $this->entityManager->getRepository('BigfootContentBundle:Sidebar')->findOneBySlug($sidebar);
        }

        if (!$sidebar) {
            throw new NotFoundHttpException('Unable to find sidebar.');
        }

        $pageSidebar = $this->entityManager->getRepository('BigfootContentBundle:Page\Sidebar')->findOneByPageSidebar($page, $sidebar);

        if ($pageSidebar) {
            $template = $pageSidebar->getTemplate();
        } elseif ($tpl) {
            $template = $tpl;
        } else {
            $template = $sidebar->getParentTemplate().'/'.$sidebar->getSlugTemplate();
        }

        return $this->twig->render(
            'BigfootContentBundle:templates:sidebar/'.$template.'.html.twig',
            array(
                'sidebar'    => $sidebar,
                'parameters' => $parameters,
            )
        );
    }

    public function displayBlock($block, array $parameters = null, $entity = null, $tpl = null)
    {
        if (!$block instanceof Block) {
            $block = $this->entityManager->getRepository('BigfootContentBundle:Block')->findOneBySlug($block);
        }

        if (!$block) {
            return '';
        }

        $action      = $block->getAction();
        $nParameters = $this->handleParameters($action, $parameters);

        if ($entity instanceof Page) {
            $entityBlock = $this->entityManager->getRepository('BigfootContentBundle:Page\Block')->findOneByPageBlock($entity, $block);
        } elseif ($entity instanceof Sidebar) {
            $entityBlock = $this->entityManager->getRepository('BigfootContentBundle:Sidebar\Block')->findOneBySidebarBlock($entity, $block);
        }

        if (isset($entityBlock)) {
            $template = $entityBlock->getTemplate();
        } elseif ($tpl) {
            $template = $tpl;
        } else {
            $template = $block->getParentTemplate().'/'.$block->getSlugTemplate();
        }

        return $this->twig->render(
            'BigfootContentBundle:templates:block/'.$template.'.html.twig',
            array(
                'block'      => $block,
                'parameters' => $parameters,
            )
        );
    }

    public function handleParameters($action, $parameters)
    {
        if ($action) {
            $variables   = $this->router->getRouteCollection()->get($action)->compile()->getVariables();
            $nParameters = array();

            foreach ($variables as $variable) {
                $nParameters[$variable] = $parameters[$variable];
            }

            return $nParameters;
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_content';
    }
}
