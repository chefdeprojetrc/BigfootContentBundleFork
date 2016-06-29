<?php
/**
 * Created by PhpStorm.
 * User: guillaume
 * Date: 29/06/16
 * Time: 15:10
 */

namespace Bigfoot\Bundle\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

/**
 * Class SidebarsType
 * @package Bigfoot\Bundle\ContentBundle\Form\Type
 */
class SidebarsType extends AbstractType
{
    /**
     * @return mixed
     */
    public function getParent()
    {
        return CollectionType::class;
    }
}
