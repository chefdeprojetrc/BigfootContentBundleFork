<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type\Block\Simple;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class Simple2Type extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                'text',
                array(
                    'attr' => array(
                        'data-placement' => 'bottom',
                        'data-popover'   => true,
                        'data-content'   => 'This is the name of the block in the back office. It will not be displayed to the web user.',
                        'data-title'     => 'Name',
                        'data-trigger'   => 'hover',
                        'data-placement' => 'right'
                    )
                )
            )
            ->add(
                'slug',
                'text',
                array(
                    'attr' => array(
                        'data-placement' => 'bottom',
                        'data-popover'   => true,
                        'data-content'   => 'This value is used to generate urls. Should contain only lower case letters and the \'-\' sign.',
                        'data-title'     => 'Slug',
                        'data-trigger'   => 'hover',
                        'data-placement' => 'right'
                    ),
                )
            )
            ->add(
                'title',
                'text',
                array(
                    'attr' => array(
                        'data-placement' => 'bottom',
                        'data-popover'   => true,
                        'data-content'   => 'This is the title of the block as displayed to the web user.',
                        'data-title'     => 'Title',
                        'data-trigger'   => 'hover',
                        'data-placement' => 'right'
                    )
                )
            )
            ->add('description', 'bigfoot_richtext')
            ->add('action', 'text', array('required' => false))
            ->add('active', 'checkbox', array('required' => false))
            ->add('translation', 'translatable_entity');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Block\Simple\Simple2'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_block_simple_simple_2';
    }
}
