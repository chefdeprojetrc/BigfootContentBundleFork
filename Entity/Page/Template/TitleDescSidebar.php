<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Page\Template;

use Bigfoot\Bundle\ContentBundle\Form\Type\Page\Template\TitleDescSidebarType;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Entity\Page;

/**
 * TitleDescSidebar
 *
 * @ORM\Entity()
 */
class TitleDescSidebar extends Page
{
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
        return 'title_desc_sidebar';
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'TitleDescSidebar';
    }

    /**
     * Set description
     *
     * @param string $description
     * @return TitleDescSidebar
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
     * {@inheritDoc}
     */
    public function getTypeClass()
    {
        return TitleDescSidebarType::class;
    }

    public static function getTemplateName()
    {
        return 'Titre + Description Sidebar';
    }
}