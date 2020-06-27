<?php

namespace App\Form;

use App\Entity\Concert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConcertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('date_string')
            ->add('category')
            ->add('fee')
            ->add('feeCurrency')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Concert::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }
}
