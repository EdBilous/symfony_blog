<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['attr' => [
                'class' => 'form-control']])
            ->add('description', null, ['attr' => [
                'class' => 'form-control']])
            ->add('image', FileType::class, ['data_class' => null, 'label' => 'Image (jpg file)', 'required' =>false])
            ->add('content', null, ['attr' => [
                'class' => 'form-control']])
            ->add('categories', null, ['attr' => [
                'class' => 'form-control']])
            ->add('users', null, ['attr' => [
                'class' => 'form-control']])
            ->add('submit', SubmitType::class, [
                'label' => 'Create', 'attr' => [
        'class' => 'submit']]);

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
