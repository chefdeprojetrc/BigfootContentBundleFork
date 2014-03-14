<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Model\Content;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block as PageBlock;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar as PageSidebar;

/**
 * Page
 *
 * @ORM\Table(name="bigfoot_content_page")
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\PageRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 */
class Page extends Content
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
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar", mappedBy="page", cascade={"persist", "remove"})
     */
    private $sidebars;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block", mappedBy="page", cascade={"persist", "remove"})
     */
    private $blocks;

    /**
     * Construct Page
     */
    public function __construct()
    {
        $this->sidebars = new ArrayCollection();
        $this->blocks   = new ArrayCollection();
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
     * Add sidebar
     *
     * @param PageSidebar $sidebar
     * @return Page
     */
    public function addSidebar(PageSidebar $sidebar)
    {
        $this->sidebars[] = $sidebar;

        return $this;
    }

    /**
     * Remove sidebar
     *
     * @param PageSidebar $sidebar
     */
    public function removeSidebar(PageSidebar $sidebar)
    {
        $this->sidebars->removeElement($sidebar);

        return $this;
    }

    /**
     * Get sidebars
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSidebars()
    {
        return $this->sidebars;
    }

    /**
     * Add block
     *
     * @param PageBlock $block
     * @return Page
     */
    public function addBlock(PageBlock $block)
    {
        $this->blocks[] = $block;

        return $this;
    }

    /**
     * Remove block
     *
     * @param PageBlock $block
     */
    public function removeBlock(PageBlock $block)
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
}