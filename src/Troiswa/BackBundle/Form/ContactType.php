<?php

namespace Troiswa\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    $builder
        ->add("firstname","text",
            array('constraints'=>
                array(
                    new Assert\Length(
                        array(
                            'min'        => 2,
                            'max'        => 25,
                            'minMessage' => 'Votre prénom doit faire au moins {{ limit }} caractères',
                            'maxMessage' => 'Votre prénom ne peut pas être plus long que {{ limit }} caractères',
                        )
                    ),
                    new Assert\NotBlank()
                )
            )
        )
        ->add("lastname","text",
            array('constraints'=>
                array(
                    new Assert\Length(
                        array(
                            'min'        => 5,
                            'max'        => 50,
                            'minMessage' => 'Votre nom doit faire au moins {{ limit }} caractères',
                            'maxMessage' => 'Votre nom ne peut pas être plus long que {{ limit }} caractères',
                        )
                    ),
                    new Assert\NotBlank()
                )
            )
        )
        ->add('objet', 'choice',
            array(  'choices'  =>
                array(
                    1 => 'Informations',
                    2 => 'Contestation'
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
        ->add("email","text",
            array('constraints'=>
                array(
                    new Assert\NotBlank()
                )
            )
        )
        ->add("message","textarea",
            array('constraints'=>
                array(
                    new Assert\Length(
                        array(
                            'min'        => 10,
                            'max'        => 500,
                            'minMessage' => 'Votre message doit contenir au moins {{ limit }} caractères',
                            'maxMessage' => 'Votre message ne peut dépasser { limit }} caractères',
                        )
                    ),
                    new Assert\NotBlank()
                )
            )
        )
        ->add('submit', 'submit');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
    $resolver->setDefaults([]);
    }

    public function getName()
    {
    return 'form_contact';
    }
}


