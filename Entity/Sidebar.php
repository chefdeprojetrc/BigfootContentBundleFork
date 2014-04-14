<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Model\Content;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar as PageSidebar;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar2 as PageSidebar2;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar3 as PageSidebar3;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar4 as PageSidebar4;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar5 as PageSidebar5;
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
    private $pageSidebars;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar2", mappedBy="sidebar", cascade={"persist", "remove"})
     */
    private $pageSidebars2;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar3", mappedBy="sidebar", cascade={"persist", "remove"})
     */
    private $pageSidebars3;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar4", mappedBy="sidebar", cascade={"persist", "remove"})
     */
    private $pageSidebars4;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar5", mappedBy="sidebar", cascade={"persist", "remove"})
     */
    private $pageSidebars5;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Sidebar\Block", mappedBy="sidebar", cascade={"persist", "remove"})
     */
    private $blocks;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyTomany(targetEntity="Attribute")
     * @ORM\JoinTable(name="bigfoot_sidebar_attribute")
     */
    private $attributes;

    /**
     * Construct Sidebar
     */
    public function __construct()
    {
        $this->blocks        = new ArrayCollection();
        $this->pageSidebars  = new ArrayCollection();
        $this->pageSidebars2 = new ArrayCollection();
        $this->pageSidebars3 = new ArrayCollection();
        $this->pageSidebars4 = new ArrayCollection();
        $this->pageSidebars5 = new ArrayCollection();
        $this->attributes    = new ArrayCollection();
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

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Add pageSidebars
     *
     * @param PageSidebar $pageSidebars
     * @return Sidebar
     */
    public function addPageSidebar(PageSidebar $pageSidebars)
    {
        $this->pageSidebars[] = $pageSidebars;

        return $this;
    }

    /**
     * Remove pageSidebars
     *
     * @param PageSidebar $pageSidebars
     */
    public function removePageSidebar(PageSidebar $pageSidebars)
    {
        $this->pageSidebars->removeElement($pageSidebars);
    }

    /**
     * Get pageSidebars
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageSidebars()
    {
        return $this->pageSidebars;
    }

    /**
     * Add pageSidebars2
     *
     * @param PageSidebar2 $pageSidebars2
     * @return Sidebar
     */
    public function addPageSidebar2(PageSidebar2 $pageSidebars2)
    {
        $this->pageSidebars2[] = $pageSidebars2;

        return $this;
    }

    /**
     * Remove pageSidebars2
     *
     * @param PageSidebar2 $pageSidebars2
     */
    public function removePageSidebar2(PageSidebar2 $pageSidebars2)
    {
        $this->pageSidebars2->removeElement($pageSidebars2);
    }

    /**
     * Get pageSidebars2
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageSidebars2()
    {
        return $this->pageSidebars2;
    }

    /**
     * Add pageSidebars3
     *
     * @param PageSidebar3 $pageSidebars3
     * @return Sidebar
     */
    public function addPageSidebar3(PageSidebar3 $pageSidebars3)
    {
        $this->pageSidebars3[] = $pageSidebars3;

        return $this;
    }

    /**
     * Remove pageSidebars3
     *
     * @param PageSidebar3 $pageSidebars3
     */
    public function removePageSidebar3(PageSidebar3 $pageSidebars3)
    {
        $this->pageSidebars3->removeElement($pageSidebars3);
    }

    /**
     * Get pageSidebars3
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageSidebars3()
    {
        return $this->pageSidebars3;
    }

    /**
     * Add pageSidebars4
     *
     * @param PageSidebar4 $pageSidebars4
     * @return Sidebar
     */
    public function addPageSidebar4(PageSidebar4 $pageSidebars4)
    {
        $this->pageSidebars4[] = $pageSidebars4;

        return $this;
    }

    /**
     * Remove pageSidebars4
     *
     * @param PageSidebar4 $pageSidebars4
     */
    public function removePageSidebar4(PageSidebar4 $pageSidebars4)
    {
        $this->pageSidebars4->removeElement($pageSidebars4);
    }

    /**
     * Get pageSidebars4
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageSidebars4()
    {
        return $this->pageSidebars4;
    }

    /**
     * Add pageSidebars5
     *
     * @param PageSidebar5 $pageSidebars5
     * @return Sidebar
     */
    public function addPageSidebar5(PageSidebar5 $pageSidebars5)
    {
        $this->pageSidebars5[] = $pageSidebars5;

        return $this;
    }

    /**
     * Remove pageSidebars5
     *
     * @param PageSidebar5 $pageSidebars5
     */
    public function removePageSidebar5(PageSidebar5 $pageSidebars5)
    {
        $this->pageSidebars5->removeElement($pageSidebars5);
    }

    /**
     * Get pageSidebars5
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageSidebars5()
    {
        return $this->pageSidebars5;
    }

        /**
     * @param Attribute $attribute
     */
    public function addAttribute($attribute)
    {
        $this->attributes->add($attribute);

        return $this;
    }

    /**
     * @param Attribute $attribute
     */
    public function removeAttribute($attribute)
    {
        $this->attributes->removeElement($attribute);

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param $type
     * @return array
     */
    public function getArrayAttributes() {
        $toReturn = array();

        /** @var Attribute $attribute */
        foreach ($this->attributes as $attribute) {
            if (!isset($toReturn[$attribute->getName()])) {
                $toReturn[$attribute->getName()] = array();
            }
            $toReturn[$attribute->getName()][] = $attribute->getValue();
        }

        return $toReturn;
    }
}