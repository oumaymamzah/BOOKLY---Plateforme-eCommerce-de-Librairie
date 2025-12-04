<?php

namespace App\Form;

use App\Entity\Ouvrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class OuvrierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
    ->add('nom', TextType::class, [
        'attr' => ['class' => 'form-control']
    ])
    ->add('prenom', TextType::class, [
        'attr' => ['class' => 'form-control']
    ])
    ->add('daten', DateType::class, [
        'widget' => 'single_text', 
        'attr' => ['class' => 'form-control']
    ])
    ->add('salaire', NumberType::class, [
        'attr' => ['class' => 'form-control'],
        'scale' => 2 
    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ouvrier::class,
        ]);
    }
}
