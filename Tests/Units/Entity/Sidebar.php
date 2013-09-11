<?php

namespace Bigfoot\Bundle\ContentBundle\Tests\Units\Entity;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use atoum\AtoumBundle\Test\Units;


/**
 * Class Sidebar
 * @package Bigfoot\Bundle\ContentBundle\Tests\Units\Entity
 */
class Sidebar extends Units\Test
{

    /**
     * Test Title getter/setter
     */
    public function testGetTitle()
    {
        $this
            ->if($sidebar = new \Bigfoot\Bundle\ContentBundle\Entity\Sidebar())
            ->and($sidebar->setTitle('Test sidebar'))
            ->string($sidebar->getTitle())
            ->isEqualTo('Test sidebar')
            ->isNotEqualTo('Not a title')
        ;
    }

    /**
     * Test Template getter/setter
     */
    public function testGetTemplate()
    {
        $this
            ->if($sidebar = new \Bigfoot\Bundle\ContentBundle\Entity\Sidebar())
            ->and($sidebar->setTemplate('default.html.twig'))
            ->string($sidebar->getTemplate())
            ->isEqualTo('default.html.twig')
        ;
    }

    /**
     * Test Active getter/setter
     */
    public function testGetActive()
    {
        $this
            ->if($sidebar = new \Bigfoot\Bundle\ContentBundle\Entity\Sidebar())
            ->and($sidebar->setActive(true))
            ->boolean($sidebar->getActive())
            ->isEqualTo(true)
            ->isNotEqualTo(false)
        ;
    }

    /**
     * Test StaticContent getter/setter
     */
    public function testGetStaticContent()
    {
        $staticcontent = new \Bigfoot\Bundle\ContentBundle\Entity\StaticContent();

        $staticcontent
            ->setLabel('Test label Static Content')
            ->setDescription('Test description Static Content')
            ->setPosition(99)
            ->setTemplate('default.html.twig')
        ;

        $this
            ->if($sidebar = new \Bigfoot\Bundle\ContentBundle\Entity\Sidebar())
            ->and($sidebar->addStaticcontent($staticcontent))
            ->array($sidebar->getStaticcontent()->toArray())
        ;
    }

    /**
     * Test Widget getter/setter
     */
    public function testGetWidget()
    {
        $widget = new \Bigfoot\Bundle\ContentBundle\Entity\Widget();

        $widget
            ->setLabel('Test label Widget')
            ->setName('Test name Widget')
            ->setRoute('route_test')
            ->setPosition(99)
            ->setTemplate('default.html.twig')
        ;

        $this
            ->if($sidebar = new \Bigfoot\Bundle\ContentBundle\Entity\Sidebar())
            ->and($sidebar->addWidget($widget))
            ->array($sidebar->getWidget()->toArray())
        ;
    }
}
