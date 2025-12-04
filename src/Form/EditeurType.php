<?php

namespace App\Form;

use App\Entity\Editeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class EditeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
    ->add('nom', TextType::class, [
        'attr' => ['class' => 'form-control']
    ])
    ->add('pays', TextType::class, [
        'attr' => ['class' => 'form-control']
    ])
    ->add('adresse', TextType::class, [
        'attr' => ['class' => 'form-control']
    ])
    ->add('telephone', TelType::class, [  // TelType pour un numéro de téléphone
        'attr' => ['class' => 'form-control']
    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Editeur::class,
        ]);
    }
}
