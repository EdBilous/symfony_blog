<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['attr' => array(
                'class' => 'form-control')])
            ->add('description', null, ['attr' => array(
                'class' => 'form-control')])
//            ->add('slug', null, ['attr' => array(
//                'class' => 'form-control')])
            ->add('content', null, ['attr' => array(
                'class' => 'form-control')])
            ->add('categories', null, ['attr' => array(
                'class' => 'form-control')])
            ->add('users', null, ['attr' => array(
                'class' => 'form-control')])
            ->add('submit', SubmitType::class, [
                'label' => 'Create', 'attr' => array(
        'class' => 'submit')]);

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_article';
    }


}
