<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Sidebar;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Block
 *
 * @ORM\Table(name="bigfoot_content_sidebar_block")
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\Sidebar\BlockRepository")
 */
class Block
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
     * @ORM\ManyToOne(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Sidebar", inversedBy="blocks")
     * @ORM\JoinColumn(name="sidebar_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $sidebar;

    /**
     * @ORM\ManyToOne(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Block", inversedBy="sidebars")
     * @ORM\JoinColumn(name="block_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $block;

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
     * @return Block
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
     * @return Block
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
     * Set sidebar
     *
     * @param Bigfoot\Bundle\ContentBundle\Entity\Sidebar $sidebar
     * @return Block
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

    /**
     * Set block
     *
     * @param Bigfoot\Bundle\ContentBundle\Entity\Block $block
     * @return Block
     */
    public function setBlock($block = null)
    {
        $this->block = $block;

        return $this;
    }

    /**
     * Get block
     *
     * @return Bigfoot\Bundle\ContentBundle\Entity\Block
     */
    public function getBlock()
    {
        return $this->block;
    }
}