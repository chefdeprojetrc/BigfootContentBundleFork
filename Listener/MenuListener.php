<?php

namespace Bigfoot\Bundle\ContentBundle\Listener;

use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;

use Bigfoot\Bundle\CoreBundle\Event\MenuEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Menu Listener
 */
class MenuListener implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    private $security;

    /**
     * @param SecurityContextInterface $security
     */
    public function __construct(SecurityContextInterface $security)
    {
        $this->security = $security;
    }

    /**
     * Get subscribed events
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            MenuEvent::GENERATE_MAIN => 'onGenerateMain',
        );
    }

    /**
     * @param GenericEvent $event
     */
    public function onGenerateMain(GenericEvent $event)
    {
        $menu        = $event->getSubject();
        $contentMenu = $menu->getChild('content');

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $contentMenu->addChild(
                'template',
                array(
                    'label'  => 'Template',
                    'route'  => 'admin_contentbundle_template',
                    'extras' => array(
                        'routes' => array(
                            'admin_contentbundle_template_new',
                            'admin_contentbundle_template_edit'
                        )
                    ),
                    'linkAttributes' => array(
                        'icon'  => 'list-alt',
                    )
                )
            );

            $contentMenu->addChild(
                'page',
                array(
                    'label'  => 'Page',
                    'route'  => 'admin_page',
                    'extras' => array(
                        'routes' => array(
                            'admin_page_new',
                            'admin_page_edit'
                        )
                    ),
                    'linkAttributes' => array(
                        'icon'  => 'list-alt',
                    )
                )
            );

            $structureMenu = $menu->getChild('structure');

            $structureMenu->addChild(
                'widget',
                array(
                    'label'          => 'Widget',
                    'route'          => 'admin_dashboard',
                    'linkAttributes' => array(
                        'icon'  => 'list-alt',
                    )
                )
            );
        }
    }
}
