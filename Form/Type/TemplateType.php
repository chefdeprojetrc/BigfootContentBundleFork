<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class TemplateType extends AbstractType
{
    private $templates;
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
                    'required'    => true,
                    'expanded'    => true,
                    'multiple'    => false,
                    'choices'     => $this->toStringTemplates($templates),
                    'constraints' => array(
                        new Assert\NotNull(),
                    )
                )
            );
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['contentType'] = $options['contentType'];
        $view->vars['templates']   = $this->templates;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'contentType' => '',
            )
        );
    }

    public function toStringTemplates($templates)
    {
        $nTemplates = array();

        foreach ($templates as $key => $template) {
            foreach ($template['sub_templates'] as $subTemplates => $label) {
                $nTemplates[$key][$subTemplates] = $label;
            }
        }

        asort($nTemplates);

        $this->templates = $nTemplates;

        return $nTemplates;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_template';
    }
}
