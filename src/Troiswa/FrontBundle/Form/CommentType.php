<?php

namespace Troiswa\FrontBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $comment=$builder->getData();
        $productId=$comment->getProduct()->getId();

        $builder
            ->add('note','number')
            ->add('comments','textarea')
//            ->add('product')
//            ->add('author')
            ->add('parent','entity',
                [
                    'class' => 'TroiswaFrontBundle:Comment',
                    'property' => 'id',
                    'query_builder' => function(EntityRepository $er) use ($productId) {

                        return $er->findCommentsOfProduct($productId);
                    },
                ]
            )
            ->add('submit','submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\FrontBundle\Entity\Comment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_frontbundle_comment';
    }
}
