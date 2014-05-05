<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type;

use Bigfoot\Bundle\ContentBundle\Entity\Attribute;
use Bigfoot\Bundle\ContentBundle\Entity\Block;
use Bigfoot\Bundle\ContentBundle\Entity\Page;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;
use Bigfoot\Bundle\ContentBundle\Model\Content;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ContentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'template',
                'choice',
                array(
                    'required' => true,
                    'expanded' => true,
                    'multiple' => false,
                    'data'     => $options['template'],
                    'choices'  => $options['data']->toStringTemplates($options['templates'])
                )
            )
            ->add(
                'name',
                'text',
                array(
                    'attr' => array(
                        'data-placement' => 'bottom',
                        'data-popover'   => true,
                        'data-content'   => 'This is the name of the content in the back office. It will not be displayed to the web user.',
                        'data-title'     => 'Name',
                        'data-trigger'   => 'hover',
                    )
                )
            )
            ->add('active', 'checkbox', array('required' => false))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'inherit_data'  => true,
                'template'      => '',
                'templates'     => '',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_content';
    }
}
