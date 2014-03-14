<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Model\Content;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar as PageSidebar;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar\Block as SidebarBlock;

/**
 * Sidebar
 *
 * @ORM\Table(name="bigfoot_content_sidebar")
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\SidebarRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 */
class Sidebar extends Content
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar", mappedBy="sidebar", cascade={"persist", "remove"})
     */
    private $pages;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Sidebar\Block", mappedBy="sidebar", cascade={"persist", "remove"})
     */
    private $blocks;

    /**
     * Construct Sidebar
     */
    public function __construct()
    {
        $this->pages  = new ArrayCollection();
        $this->blocks = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName().' - '.$this->getParentTemplate();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add page
     *
     * @param PageSidebar $page
     * @return Sidebar
     */
    public function addPage(PageSidebar $page)
    {
        $this->pages[] = $page;

        return $this;
    }

    /**
     * Remove page
     *
     * @param PageSidebar $page
     */
    public function removePage(PageSidebar $page)
    {
        $this->pages->removeElement($page);

        return $this;
    }

    /**
     * Get pages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Add block
     *
     * @param SidebarBlock $block
     * @return Sidebar
     */
    public function addBlock(SidebarBlock $block)
    {
        $this->blocks[] = $block;

        return $this;
    }

    /**
     * Remove block
     *
     * @param SidebarBlock $block
     */
    public function removeBlock(SidebarBlock $block)
    {
        $this->blocks->removeElement($block);

        return $this;
    }

    /**
     * Get blocks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * @return ArrayCollection
     */
    public function getOrderedBlocks()
    {
        $blocks = array();

        foreach ($this->blocks as $block) {
            $blocks[$block->getPosition()] = $block;
        }

        ksort($blocks);

        return $blocks;
    }
}