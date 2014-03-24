<?php

namespace Bigfoot\Bundle\ContentBundle\Subscriber;

use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;

use Bigfoot\Bundle\CoreBundle\Event\MenuEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Menu Subscriber
 */
class MenuSubscriber implements EventSubscriberInterface
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
        $menu = $event->getSubject();
        $root = $menu->getRoot();

        $contentMenu = $root->addChild(
            'content',
            array(
                'label'          => 'Content',
                'url'            => '#',
                'linkAttributes' => array(
                    'class' => 'dropdown-toggle',
                    'icon'  => 'list-alt',
                ),
                'extras' => array(
                    'routes' => array(
                        'admin_content_template_choose',
                    )
                )
            )
        );

        $contentMenu->setChildrenAttributes(
            array(
                'class' => 'submenu',
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
