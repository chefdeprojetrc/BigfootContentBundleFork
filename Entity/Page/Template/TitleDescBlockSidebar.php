<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Page\Template;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Entity\Page;

/**
 * TitleDescBlockSidebar
 *
 * @ORM\Entity
 */
class TitleDescBlockSidebar extends Page
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
        return 'title_desc_block_sidebar';
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'TitleDescBlockSidebar';
    }

    /**
     * Set title
     *
     * @param string $title
     * @return TitleDescBlockSidebar
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
     * @return TitleDescBlockSidebar
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