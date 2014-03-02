<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Block\Template;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Entity\Block;

/**
 * TitleDescImg
 *
 * @ORM\Entity()
 */
class TitleDescImg extends Block
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
     * Get parent template
     *
     * @return string
     */
    public function getParentTemplate()
    {
        return 'title_desc_img';
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'TitleDescImg';
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
     * @return TitleDescImg
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
     * @return TitleDescImg
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