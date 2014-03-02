<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Sidebar\TitleDescImgBlock;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;

/**
 * TitleDescImgBlock
 *
 * @ORM\Entity()
 */
class TitleDescImgBlock extends Sidebar
{
    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var text
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * Construct TitleDescImgBlock
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
        return 'title_desc_img_block';
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'TitleDescImgBlock';
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
     * @return TitleDescImgBlock
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

    /**
     * Set description
     *
     * @param string $description
     * @return TitleDescImgBlock
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}