<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('regimeImposition')
            ->add('registreCommerce')
            ->add('adresse')
            ->add('boitePostale')
            ->add('telephone')
            ->add('email')
            ->add('siteWeb')
            ->add('commune')
            ->add('ville')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Clients::class,
        ]);
    }
}
