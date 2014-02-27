<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Block\Simple;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Entity\Block;

/**
 * Simple3
 *
 * @ORM\Entity()
 */
class Simple3 extends Block
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
     * Construct Simple3
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
        return 'simple';
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'Simple3';
    }

    /**
     * Get slug template
     *
     * @return string
     */
    public function getSlugTemplate()
    {
        return 'simple_3';
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Simple3
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
     * @return Simple3
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