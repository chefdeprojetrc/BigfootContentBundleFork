<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Model\Content;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block as PageBlock;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block2 as PageBlock2;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block3 as PageBlock3;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block4 as PageBlock4;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block5 as PageBlock5;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar as PageSidebar;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar2 as PageSidebar2;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar3 as PageSidebar3;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar4 as PageSidebar4;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar5 as PageSidebar5;

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
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block3", mappedBy="page", cascade={"persist", "remove"})
     */
    private $blocks3;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block4", mappedBy="page", cascade={"persist", "remove"})
     */
    private $blocks4;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block5", mappedBy="page", cascade={"persist", "remove"})
     */
    private $blocks5;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar", mappedBy="page", cascade={"persist", "remove"})
     */
    private $sidebars;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar2", mappedBy="page", cascade={"persist", "remove"})
     */
    private $sidebars2;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar3", mappedBy="page", cascade={"persist", "remove"})
     */
    private $sidebars3;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar4", mappedBy="page", cascade={"persist", "remove"})
     */
    private $sidebars4;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar5", mappedBy="page", cascade={"persist", "remove"})
     */
    private $sidebars5;

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
        $this->blocks     = new ArrayCollection();
        $this->blocks2    = new ArrayCollection();
        $this->blocks3    = new ArrayCollection();
        $this->blocks4    = new ArrayCollection();
        $this->blocks5    = new ArrayCollection();
        $this->sidebars   = new ArrayCollection();
        $this->sidebars2  = new ArrayCollection();
        $this->sidebars3  = new ArrayCollection();
        $this->sidebars4  = new ArrayCollection();
        $this->sidebars5  = new ArrayCollection();
        $this->attributes = new ArrayCollection();
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
     * Add block3
     *
     * @param PageBlock3 $block3
     * @return Page
     */
    public function addBlock3(PageBlock3 $block3)
    {
        $this->blocks3[] = $block3;

        return $this;
    }

    /**
     * Remove block3
     *
     * @param PageBlock3 $block3
     */
    public function removeBlock3(PageBlock3 $block3)
    {
        $this->blocks3->removeElement($block3);

        return $this;
    }

    /**
     * Get blocks3
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlocks3()
    {
        return $this->blocks3;
    }

    /**
     * Add block4
     *
     * @param PageBlock4 $block4
     * @return Page
     */
    public function addBlock4(PageBlock4 $block4)
    {
        $this->blocks4[] = $block4;

        return $this;
    }

    /**
     * Remove block4
     *
     * @param PageBlock4 $block4
     */
    public function removeBlock4(PageBlock4 $block4)
    {
        $this->blocks4->removeElement($block4);

        return $this;
    }

    /**
     * Get blocks4
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlocks4()
    {
        return $this->blocks4;
    }

    /**
     * Add block5
     *
     * @param PageBlock5 $block5
     * @return Page
     */
    public function addBlock5(PageBlock5 $block5)
    {
        $this->blocks5[] = $block5;

        return $this;
    }

    /**
     * Remove block5
     *
     * @param PageBlock5 $block5
     */
    public function removeBlock5(PageBlock5 $block5)
    {
        $this->blocks5->removeElement($block5);

        return $this;
    }

    /**
     * Get blocks5
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlocks5()
    {
        return $this->blocks5;
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
     * Add sidebars2
     *
     * @param PageSidebar2 $sidebars2
     * @return Page
     */
    public function addSidebar2(PageSidebar2 $sidebars2)
    {
        $this->sidebars2[] = $sidebars2;

        return $this;
    }

    /**
     * Remove sidebars2
     *
     * @param PageSidebar2 $sidebars2
     */
    public function removeSidebar2(PageSidebar2 $sidebars2)
    {
        $this->sidebars2->removeElement($sidebars2);
    }

    /**
     * Get sidebars2
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSidebars2()
    {
        return $this->sidebars2;
    }

    /**
     * Add sidebars3
     *
     * @param PageSidebar3 $sidebars3
     * @return Page
     */
    public function addSidebar3(PageSidebar3 $sidebars3)
    {
        $this->sidebars3[] = $sidebars3;

        return $this;
    }

    /**
     * Remove sidebars3
     *
     * @param PageSidebar3 $sidebars3
     */
    public function removeSidebar3(PageSidebar3 $sidebars3)
    {
        $this->sidebars3->removeElement($sidebars3);
    }

    /**
     * Get sidebars3
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSidebars3()
    {
        return $this->sidebars3;
    }

    /**
     * Add sidebars4
     *
     * @param PageSidebar4 $sidebars4
     * @return Page
     */
    public function addSidebar4(PageSidebar4 $sidebars4)
    {
        $this->sidebars4[] = $sidebars4;

        return $this;
    }

    /**
     * Remove sidebars4
     *
     * @param PageSidebar4 $sidebars4
     */
    public function removeSidebar4(PageSidebar4 $sidebars4)
    {
        $this->sidebars4->removeElement($sidebars4);
    }

    /**
     * Get sidebars4
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSidebars4()
    {
        return $this->sidebars4;
    }

    /**
     * Add sidebars5
     *
     * @param PageSidebar5 $sidebars5
     * @return Page
     */
    public function addSidebar5(PageSidebar5 $sidebars5)
    {
        $this->sidebars5[] = $sidebars5;

        return $this;
    }

    /**
     * Remove sidebars5
     *
     * @param PageSidebar5 $sidebars5
     */
    public function removeSidebar5(PageSidebar5 $sidebars5)
    {
        $this->sidebars5->removeElement($sidebars5);
    }

    /**
     * Get sidebars5
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSidebars5()
    {
        return $this->sidebars5;
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

        foreach ($this->attributes as $attribute) {
            if (!isset($toReturn[$attribute->getName()])) {
                $toReturn[$attribute->getName()] = array();
            }

            $toReturn[$attribute->getName()][] = $attribute->getValue();
        }

        return $toReturn;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $sidebars5
     */
    public function setSidebars5($sidebars5)
    {
        $this->sidebars5 = $sidebars5;
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $blocks
     */
    public function setBlocks($blocks)
    {
        $this->blocks = $blocks;
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $blocks2
     */
    public function setBlocks2($blocks2)
    {
        $this->blocks2 = $blocks2;
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $blocks3
     */
    public function setBlocks3($blocks3)
    {
        $this->blocks3 = $blocks3;
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $blocks4
     */
    public function setBlocks4($blocks4)
    {
        $this->blocks4 = $blocks4;
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $blocks5
     */
    public function setBlocks5($blocks5)
    {
        $this->blocks5 = $blocks5;
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $sidebars
     */
    public function setSidebars($sidebars)
    {
        $this->sidebars = $sidebars;
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $sidebars2
     */
    public function setSidebars2($sidebars2)
    {
        $this->sidebars2 = $sidebars2;
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $sidebars3
     */
    public function setSidebars3($sidebars3)
    {
        $this->sidebars3 = $sidebars3;
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $sidebars4
     */
    public function setSidebars4($sidebars4)
    {
        $this->sidebars4 = $sidebars4;
        return $this;
    }


}