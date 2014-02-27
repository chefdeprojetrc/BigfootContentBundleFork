<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Page;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Sidebar
 *
 * @ORM\Table(name="bigfoot_content_page_sidebar")
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\Page\SidebarRepository")
 */
class Sidebar
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
     * @ORM\ManyToOne(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page", inversedBy="sidebars")
     */
    private $page;

    /**
     * @ORM\ManyToOne(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Sidebar", inversedBy="pages")
     */
    private $sidebar;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="smallint", nullable=true)
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="string", length=255)
     */
    private $template;

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
     * Set position
     *
     * @param integer $position
     * @return sidebar
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set template
     *
     * @param string $template
     * @return sidebar
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set page
     *
     * @param Bigfoot\Bundle\ContentBundle\Entity\Page $page
     * @return sidebar
     */
    public function setPage($page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return Bigfoot\Bundle\ContentBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set sidebar
     *
     * @param Bigfoot\Bundle\ContentBundle\Entity\Sidebar $sidebar
     * @return sidebar
     */
    public function setSidebar($sidebar = null)
    {
        $this->sidebar = $sidebar;

        return $this;
    }

    /**
     * Get sidebar
     *
     * @return Bigfoot\Bundle\ContentBundle\Entity\Sidebar
     */
    public function getSidebar()
    {
        return $this->sidebar;
    }
}