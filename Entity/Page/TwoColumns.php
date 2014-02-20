<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Page;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Entity\Page;

/**
 * TwoColumns
 *
 * @ORM\Entity()
 */
class TwoColumns extends Page
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
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="title_2", type="string", length=255, nullable=true)
     */
    private $title2;

    /**
     * @var text
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="description_2", type="text", nullable=true)
     */
    private $description2;

    /**
     * Construct TwoColumns
     */
    public function __construct()
    {
        $this->template = $this->getTemplate();
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'TwoColumns';
    }

    /**
     * Get slug template
     *
     * @return string
     */
    public function getSlugTemplate()
    {
        return 'two_columns';
    }

    /**
     * Set title
     *
     * @param string $title
     * @return TwoColumns
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
     * @return TwoColumns
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

    /**
     * Set title2
     *
     * @param string $title2
     * @return TwoColumns
     */
    public function setTitle2($title2)
    {
        $this->title2 = $title2;

        return $this;
    }

    /**
     * Get title2
     *
     * @return string
     */
    public function getTitle2()
    {
        return $this->title2;
    }

    /**
     * Set description2
     *
     * @param string $description2
     * @return TwoColumns
     */
    public function setDescription2($description2)
    {
        $this->description2 = $description2;

        return $this;
    }

    /**
     * Get description2
     *
     * @return string
     */
    public function getDescription2()
    {
        return $this->description2;
    }
}