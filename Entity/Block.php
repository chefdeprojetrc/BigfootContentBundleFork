<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Model\Content;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar\Block as SidebarBlock;

/**
 * Block
 *
 * @ORM\Table(name="bigfoot_content_block")
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\BlockRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 */
class Block extends Content
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
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"}, updatable=false, unique=true)
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255, nullable=true)
     */
    protected $action;

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="string", length=255)
     */
    protected $template;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block", mappedBy="block", cascade={"persist"})
     */
    private $pages;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Sidebar\Block", mappedBy="block", cascade={"persist"})
     */
    private $sidebars;

    /**
     * Construct Block
     */
    public function __construct()
    {
        $this->pages    = new ArrayCollection();
        $this->sidebars = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return Block
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
     * Set slug
     *
     * @param string $slug
     * @return Block
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set action
     *
     * @param string $action
     * @return Block
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set template
     *
     * @param string $template
     * @return Block
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Add page
     *
     * @param PageBlock $page
     * @return Block
     */
    public function addPage(PageBlock $page)
    {
        $this->pages->add($page);

        return $this;
    }

    /**
     * Remove page
     *
     * @param PageBlock $page
     */
    public function removePage(PageBlock $page)
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
     * Add sidebar
     *
     * @param SidebarBlock $sidebar
     * @return Block
     */
    public function addSidebar(SidebarBlock $sidebar)
    {
        $this->sidebars->add($sidebar);

        return $this;
    }

    /**
     * Remove sidebar
     *
     * @param SidebarBlock $sidebar
     */
    public function removeSidebar(SidebarBlock $sidebar)
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
}