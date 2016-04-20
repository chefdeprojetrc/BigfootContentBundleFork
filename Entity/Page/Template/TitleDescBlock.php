<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Page\Template;

use Bigfoot\Bundle\ContentBundle\Form\Type\Page\Template\TitleDescBlockType;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Entity\Page;

/**
 * TitleDescBlock
 *
 * @ORM\Entity
 */
class TitleDescBlock extends Page
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
        return 'title_desc_block';
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'TitleDescBlock';
    }

    /**
     * Set description
     *
     * @param string $description
     * @return TitleDescBlock
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
        return TitleDescBlockType::class;
    }
}