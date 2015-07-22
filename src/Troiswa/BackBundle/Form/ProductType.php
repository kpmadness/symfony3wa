<?php

namespace Troiswa\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
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
            ->add('active', 'choice',
                array(  'choices'  =>
                    array(
                        1 => 'oui',
                        0 => 'non'
                    ),
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'constraints'=>
                        array(
                            new Assert\NotBlank()
                        )
                )
            )
            ->add("price","text")
            ->add("quantity","integer")
            ->add('categ','entity',
                [
                    'class' => 'TroiswaBackBundle:Category',
                    'property' => 'title'
                ]
            )
            ->add('brand','entity',
                [
                    'class' => 'TroiswaBackBundle:Brand',
                    'property' => 'labelFormType'
                ]
            )
            ->add('cover', new ProductCoverType())
            ->add('tag','entity',
                [
                    'class' => 'TroiswaBackBundle:Tag',
                    'property' => 'tag'
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
            'data_class' => 'Troiswa\BackBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_backbundle_product';
    }
}
