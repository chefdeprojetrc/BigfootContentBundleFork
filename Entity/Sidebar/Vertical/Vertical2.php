<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Sidebar\Vertical;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;

/**
 * Vertical2
 *
 * @ORM\Entity()
 */
class Vertical2 extends Sidebar
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
     * Construct Vertical2
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
        return 'vertical';
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'Vertical2';
    }

    /**
     * Get slug template
     *
     * @return string
     */
    public function getSlugTemplate()
    {
        return 'vertical_2';
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Vertical2
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
     * @return Vertical2
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