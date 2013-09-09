<?php
namespace Bigfoot\Bundle\ContentBundle\Widget;

use Bigfoot\Bundle\ContentBundle\Model\AbstractWidget;

class WidgetMostViewedHotel extends AbstractWidget
{
    public function getLabel()
    {
        return 'Most Viewed Hotel';
    }

    public function getName()
    {
        return 'widget_most_viewed_hotel';
    }

    public function getDefaultParameters()
    {
        return array();
    }

    public function getRoute()
    {
        return 'content_page';
    }

    public function getParametersType()
    {
        return 'Bigfoot\Bundle\ContentBundle\Form\WidgetMostViewedHotelType';
    }

}