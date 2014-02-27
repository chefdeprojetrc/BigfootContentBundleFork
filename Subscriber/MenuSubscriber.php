<?php

namespace Bigfoot\Bundle\ContentBundle\Subscriber;

use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;

use Bigfoot\Bundle\CoreBundle\Event\MenuEvent;

/**
 * Menu Subscriber
 */
class MenuSubscriber implements EventSubscriberInterface
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
            'page',
            array(
                'label'  => 'Page',
                'route'  => 'admin_page',
                'extras' => array(
                    'routes' => array(
                        'admin_page_new',
                        'admin_page_edit',
                    )
                ),
                'linkAttributes' => array(
                    'icon' => 'list-alt',
                )
            )
        );

        $contentMenu->addChild(
            'sidebar',
            array(
                'label'  => 'Sidebar',
                'route'  => 'admin_sidebar',
                'extras' => array(
                    'routes' => array(
                        'admin_sidebar_new',
                        'admin_sidebar_edit',
                    )
                ),
                'linkAttributes' => array(
                    'icon' => 'list-alt',
                )
            )
        );

        $contentMenu->addChild(
            'block',
            array(
                'label'  => 'Block',
                'route'  => 'admin_block',
                'extras' => array(
                    'routes' => array(
                        'admin_block_new',
                        'admin_block_edit',
                    )
                ),
                'linkAttributes' => array(
                    'icon' => 'list-alt',
                )
            )
        );
    }
}
