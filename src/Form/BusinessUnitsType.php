<?php

namespace App\Form;

use App\Entity\BusinessUnits;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BusinessUnitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('description')
            ->add('users', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'nomComplet',
                'expanded' => true,
                'multiple' => true,
                'choice_attr' => function (Users $user) {
                    return [
                        'data-email' => $user->getEmail(),
                        'data-avatar' => $user->getAvatar() ?? null,
                    ];
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BusinessUnits::class,
        ]);
    }
}
