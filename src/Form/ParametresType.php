<?php

namespace App\Form;

use App\Entity\Parametres;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParametresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('slug')
            ->add('description')
            ->add('type')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('parent', EntityType::class, [
                'class' => Parametres::class,
                'choice_label' => 'id',
            ])
            ->add('createdUser', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'id',
            ])
            ->add('updatedUser', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'id',
            ])
            ->add('deletedUser', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parametres::class,
        ]);
    }
}
