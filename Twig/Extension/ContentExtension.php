<?php

namespace Bigfoot\Bundle\ContentBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;
use Twig_Extension;
use Twig_Function_Method;
use Twig_Environment;
use BeSimple\I18nRoutingBundle\Routing\Router;

use Bigfoot\Bundle\ContentBundle\Entity\Page;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;
use Bigfoot\Bundle\ContentBundle\Entity\Block;

/**
 * ContentExtension
 */
class ContentExtension extends Twig_Extension
{
    private $twig;
    private $router;
    private $entityManager;
    private $theme;

    /**
     * Construct ContentExtension
     */
    public function __construct(Twig_Environment $twig, Router $router, EntityManager $entityManager, $theme)
    {
        $this->twig          = $twig;
        $this->router        = $router;
        $this->entityManager = $entityManager;
        $this->theme         = $theme;
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

    public function displayPage($page, array $parameters = null)
    {
        return $this->twig->render(
            $this->theme['name'].':template/page:'.$page->getSlugTemplate().'.html.twig',
            array(
                'page'       => $page,
                'parameters' => $parameters,
            )
        );
    }

    public function displaySidebar($slug, array $parameters = null)
    {
        $sidebar = $this->entityManager->getRepository('BigfootContentBundle:Sidebar')->findOneBySlug($slug);

        if (!$sidebar) {
            throw new NotFoundHttpException('Unable to find sidebar.');
        }

        return $this->twig->render(
            $this->theme['name'].':template/sidebar:'.$sidebar->getSlugTemplate().'.html.twig',
            array(
                'sidebar' => $sidebar,
            )
        );
    }

    public function displayBlock($slug, array $parameters = null)
    {
        $block  = $this->entityManager->getRepository('BigfootContentBundle:Block')->findOneBySlug($slug);
        $action = $block->getAction();

        if ($action) {
            $variables   = $this->router->getRouteCollection()->get($action)->compile()->getVariables();
            $nParameters = array();

            foreach ($variables as $variable) {
                $nParameters[$variable] = $parameters[$variable];
            }
        }

        if (!$block) {
            throw new NotFoundHttpException('Unable to find block.');
        }

        return $this->twig->render(
            $this->theme['name'].':template/block:'.$block->getSlugTemplate().'.html.twig',
            array(
                'block'      => $block,
                'parameters' => $parameters,
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_content';
    }
}
