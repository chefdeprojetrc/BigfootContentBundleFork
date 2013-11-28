<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Template
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\TemplateRepository")
 */
class Template
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=255)
     */
    private $route;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Sidebar", mappedBy="template", cascade={"persist"})
     */
    protected $sidebars;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Block", mappedBy="template", cascade={"persist"})
     */
    protected $blocks;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Page", mappedBy="template", cascade={"persist"})
     */
    protected $pages;

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sidebars = new ArrayCollection();
        $this->blocks = new ArrayCollection();
        $this->pages = new ArrayCollection();
    }

    /**
     * Add sidebars
     *
     * @param Sidebar $sidebars
     * @return Template
     */
    public function addSidebar(Sidebar $sidebars)
    {
        $this->sidebars[] = $sidebars;

        return $this;
    }

    /**
     * Remove sidebars
     *
     * @param Sidebar $sidebars
     */
    public function removeSidebar(Sidebar $sidebars)
    {
        $this->sidebars->removeElement($sidebars);
    }

    /**
     * Get sidebars
     *
     * @return ArrayCollection
     */
    public function getSidebars()
    {
        return $this->sidebars;
    }

    /**
     * Add blocks
     *
     * @param Block $blocks
     * @return Template
     */
    public function addBlock(Block $blocks)
    {
        $this->blocks[] = $blocks;

        return $this;
    }

    /**
     * Remove blocks
     *
     * @param Block $blocks
     */
    public function removeBlock(Block $blocks)
    {
        $this->blocks->removeElement($blocks);
    }

    /**
     * Get blocks
     *
     * @return ArrayCollection
     */
    public function getBlocks()
    {
        return $this->blocks;
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
     * Set type
     *
     * @param string $type
     * @return Template
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Template
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set route
     *
     * @param string $route
     * @return Template
     */
    public function setRoute($route)
    {
        $this->route = $route;
    
        return $this;
    }

    /**
     * Get route
     *
     * @return string 
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Add Page
     *
     * @param Page $page
     * @return Template
     */
    public function addPage(Page $page)
    {
        $this->pages[] = $page;

        return $this;
    }

    /**
     * Remove page
     *
     * @param Page $page
     */
    public function removePage(Page $page)
    {
        $this->pages->removeElement($page);
    }

    /**
     * Get pages
     *
     * @return ArrayCollection
     */
    public function getPages()
    {
        return $this->pages;
    }
}
