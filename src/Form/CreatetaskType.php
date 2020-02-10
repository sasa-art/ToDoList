<?php

namespace App\Form;

use App\Entity\Tache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CreatetaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, ['label' => 'Titre'])
        ->add('description', TextType::class, ['label' => 'Description'])
        ->add('status', ChoiceType::class, [
            'label' => 'Statut',
            'choices' => [
                'A faire' => 'A faire',
                'En cours' => 'En cours',
                'Terminée' => 'Terminée',
            ], ])
        ->add('Enregistrer', submitType::class)
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
