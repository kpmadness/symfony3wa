<?php

namespace Troiswa\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class UserEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     *
     */
    public function buildForm(FormBuilderInterface $builder , array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('pseudo')
            ->add('roles','entity',
                [
                    'class' => 'TroiswaBackBundle:Role',
                    'property' => 'name',
                    'multiple' => true
                ]
            )
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\BackBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_backbundle_user';
    }

}
