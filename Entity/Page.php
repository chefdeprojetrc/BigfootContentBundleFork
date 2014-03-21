<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Model\Content;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block as PageBlock;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block2 as PageBlock2;
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
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block", mappedBy="page", cascade={"persist", "remove"})
     */
    private $blocks;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block2", mappedBy="page", cascade={"persist", "remove"})
     */
    private $blocks2;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar", mappedBy="page", cascade={"persist", "remove"})
     */
    private $sidebars;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyTomany(targetEntity="Attribute")
     */
    private $attributes;

    /**
     * Construct Page
     */
    public function __construct()
    {
        $this->sidebars     = new ArrayCollection();
        $this->blocks       = new ArrayCollection();
        $this->blocks2      = new ArrayCollection();
        $this->attributes   = new ArrayCollection();
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

    /**
     * Add block2
     *
     * @param PageBlock2 $block2
     * @return Page
     */
    public function addBlock2(PageBlock2 $block2)
    {
        $this->blocks2[] = $block2;

        return $this;
    }

    /**
     * Remove block2
     *
     * @param PageBlock2 $block2
     */
    public function removeBlock2(PageBlock2 $block2)
    {
        $this->blocks2->removeElement($block2);

        return $this;
    }

    /**
     * Get blocks2
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlocks2()
    {
        return $this->blocks2;
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
