<?php
/* Widget/WidgetTest.php */

namespace Bigfoot\Bundle\ContentBundle\Widget;

use Bigfoot\Bundle\ContentBundle\Model\AbstractWidget;

class WidgetTest extends AbstractWidget
{

    /**
     * The name of your Widget
     * @return Slug
     */
    public function getName()
    {
        return 'widget_test';
    }

    /**
     * Label of your Widget
     * Displayed in the Dashboard section
     */
    public function getLabel()
    {
        return 'The Widget Test';
    }

    /**
     * Parameters of your Widget
     * These parameters have to be the parameters of the target Action Controller.
     */
    public function getDefaultParameters()
    {
        return array(
            'page_id' => 1
        );
    }

    /**
     * The target Route of your Widget
     * Route of the action controller
     */
    public function getRoute()
    {
        return 'content_page';
    }

    /**
     * Form type of your Widget
     * This is the specific form of your Widget to add your custom parameters
     * The parent have to be `bigfoot_bundle_contentbundle_widgettype`
     */
    public function getParametersType()
    {
        return 'Bigfoot\Bundle\ContentBundle\Form\WidgetTestType';
    }

}