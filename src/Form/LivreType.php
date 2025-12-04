<?php

namespace App\Form;

use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
    ->add('titre', TextType::class, [
        'attr' => ['class' => 'form-control']
    ])
    ->add('qte', IntegerType::class, [
        'attr' => ['class' => 'form-control']
    ])
    ->add('prixUnitaire', NumberType::class, [
        'attr' => ['class' => 'form-control']
    ])
    ->add('isbn', TextType::class, [
        'attr' => ['class' => 'form-control']
    ])
    ->add('datepub', DateType::class, [
        'widget' => 'single_text',
        'attr' => ['class' => 'form-control']
    ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
