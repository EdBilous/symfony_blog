<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstName',null,['attr' => array(
        'class' => 'form-control')])
        ->add('lastName',null,['attr' => array(
            'class' => 'form-control')])
        ->add('login',null,['attr' => array(
            'class' => 'form-control')])
        ->add('email',null, ['attr' => array(
            'class' => 'form-control')])
        ->add('password', null, ['attr' => array(
            'class' => 'form-control')])
            ->add('submit', SubmitType::class, [
                'label' => 'Registration', 'attr' => array(
                    'class' => 'btn btn-lg btn-success btn-block')]);
    ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
