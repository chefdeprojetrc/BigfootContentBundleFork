<?php

namespace Bigfoot\Bundle\ContentBundle\Listener;

use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;

use Bigfoot\Bundle\CoreBundle\Event\MenuEvent;

/**
 * Menu Listener
 */
class MenuListener implements EventSubscriberInterface
{
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
                        'admin_page_new'
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
