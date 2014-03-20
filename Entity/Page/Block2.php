<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Page;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Block2
 *
 * @ORM\Table(name="bigfoot_content_page_block_2")
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\Page\Block2Repository")
 */
class Block2
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
     * @ORM\ManyToOne(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page", inversedBy="blocks2")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $page;

    /**
     * @ORM\ManyToOne(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Block", inversedBy="pageBlocks2")
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
     * Set page
     *
     * @param Bigfoot\Bundle\ContentBundle\Entity\Page $page
     * @return Block
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