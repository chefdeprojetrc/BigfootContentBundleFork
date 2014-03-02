<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Sidebar\Template;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;

/**
 * TitleBlock
 *
 * @ORM\Entity()
 */
class TitleBlock extends Sidebar
{
    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * Construct TitleBlock
     */
    public function __construct()
    {
        $this->template = $this->getTemplate();
    }

    /**
     * Get parent template
     *
     * @return string
     */
    public function getParentTemplate()
    {
        return 'title_block';
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'TitleBlock';
    }

    /**
     * Get slug template
     *
     * @return string
     */
    public function getSlugTemplate()
    {
        return $this->template;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return TitleBlock
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}