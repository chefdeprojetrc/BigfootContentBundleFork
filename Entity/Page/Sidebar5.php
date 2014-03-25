<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Page;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Sidebar5
 *
 * @ORM\Table(name="bigfoot_content_page_sidebar_5")
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar5Repository")
 */
class Sidebar5
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
     * @ORM\ManyToOne(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page", inversedBy="sidebars5")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $page;

    /**
     * @ORM\ManyToOne(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Sidebar", inversedBy="pageSidebars5")
     * @ORM\JoinColumn(name="sidebar_id", referencedColumnName="id", onDelete="SET NULL")
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
     * @return Sidebar5
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
     * @return Sidebar5
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
     * @return Sidebar5
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
     * @return Sidebar5
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