<?php
namespace Bigfoot\Bundle\ContentBundle\Widget;

use Bigfoot\Bundle\ContentBundle\Model\AbstractWidget;

class WidgetTest extends AbstractWidget
{
    public function getName()
    {
        return 'widget_test';
    }

    public function getLabel()
    {
        return 'The Widget Test';
    }

    public function getDefaultParameters()
    {
        return array(
            'page_id' => 1
        );
    }

    public function getRoute()
    {
        return 'content_page';
    }

    public function getParametersType()
    {
        return 'Bigfoot\Bundle\ContentBundle\Form\WidgetTestType';
    }

}