<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TemplateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $templates = $options['data'];

        $builder
            ->add(
                'template',
                'choice',
                array(
                    'choices' => $this->toStringTemplates($templates)
                )
            );
    }

    public function toStringTemplates($templates)
    {
        $typeTemplates = array();

        foreach ($templates as $key => $template) {
            $typeTemplates[$key] = substr($template, strrpos($template, '\\') + 1);
        }

        return $typeTemplates;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_template';
    }
}
