<?php

namespace Bigfoot\Bundle\ContentBundle\Twig;

use Bigfoot\Bundle\ContentBundle\Services\DisplayContent;

class ContentRendererExtension extends \Twig_Extension
{
    protected $contentRenderer;

    public function __construct(DisplayContent $contentRenderer)
    {
        $this->contentRenderer = $contentRenderer;
    }

    public function getFunctions()
    {
        return array(
            'displayContent' => new \Twig_Function_Method($this, 'displayContent', array('is_safe' => array('html'))),
        );
    }

    public function displayContent($type, $identifier)
    {
        return $this->contentRenderer->displayContentAction($type, $identifier);
    }

    public function getName()
    {
        return 'content_renderer';
    }
}