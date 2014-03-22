<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type\Page\Template;

use Bigfoot\Bundle\ContentBundle\Entity\Attribute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class TitleDesc2ImgBlock2Type extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'content',
                'admin_content',
                array(
                    'data'      => $options['data'],
                    'template'  => $options['template'],
                    'templates' => $options['templates']
                )
            )
            ->add(
                'attributes',
                'entity',
                array(
                    'class'     => 'BigfootContentBundle:Attribute',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->getAttributesForType(Attribute::TYPE_PAGE);
                    },
                    'required'  => false,
                    'multiple'  => true,
                    'attr'      => array(
                        'data-placement' => 'bottom',
                        'data-popover'   => true,
                        'data-content'   => 'Styles applied to this content element.',
                        'data-title'     => 'Style',
                        'data-trigger'   => 'hover',
                    ),
                    'label' => 'Style',
                )
            )
            ->add(
                'title',
                'text',
                array(
                    'attr' => array(
                        'data-placement' => 'bottom',
                        'data-popover'   => true,
                        'data-content'   => 'This is the title of the page as displayed to the web user.',
                        'data-title'     => 'Title',
                        'data-trigger'   => 'hover',
                        'data-placement' => 'right'
                    )
                )
            )
            ->add('description', 'bigfoot_richtext')
            ->add('description2', 'bigfoot_richtext')
            ->add('media', 'bigfoot_media')
            ->add(
                'blocks',
                'collection',
                array(
                    'prototype'    => true,
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'type'         => 'admin_page_block',
                    'options'      => array(
                        'page'       => $options['data'],
                        'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Page\Block',
                    ),
                    'attr' => array(
                        'class' => 'widget-blocks',
                    )
                )
            )
            ->add(
                'blocks2',
                'collection',
                array(
                    'prototype'    => true,
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'type'         => 'admin_page_block',
                    'options'      => array(
                        'page'       => $options['data'],
                        'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Page\Block2',
                    ),
                    'attr' => array(
                        'class' => 'widget-blocks',
                    )
                )
            )
            ->add('translation', 'translatable_entity');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Page\Template\TitleDesc2ImgBlock2',
                'template'   => '',
                'templates'  => ''
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_page_template_title_desc2_img_block2';
    }
}