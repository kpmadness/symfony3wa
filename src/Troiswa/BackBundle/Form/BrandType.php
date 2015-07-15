<?php

namespace Troiswa\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BrandType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title","text")
            ->add("description","text")
//            ->add('dateCreated', 'datetime',
//                array(
//                    'widget' => 'single_text',
//                    'format' => 'yyyy/MM/dd HH:mm'
//                )
//            )
//            ->add('dateUpdated', 'datetime',
//                array(
//                    'widget' => 'single_text',
//                    'format' => 'yyyy/MM/dd HH:mm'
//                )
//            )
            ->add('products', 'entity',
                [
                    'class' => "TroiswaBackBundle:Product",
                    'property' => 'title',
                    'multiple' => true,
                    'by_reference' => false
                ]
            )
            ->add('submit', 'submit');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\BackBundle\Entity\Brand'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_backbundle_brand';
    }
}
