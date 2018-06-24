<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 22.06.18
 * Time: 20:33
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inquiry', TextType::class, [
                'label' => false, 'attr' => array(
                    'class' => 'form-control')])
            ->add('submit', SubmitType::class, [
                'label' => 'search', 'attr' => array(
                    'class' => 'btn btn-default btn-sm')]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null
        ));
    }

}