<?php

namespace App\Form;

use App\Entity\BPU;
use App\Entity\Parametres;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BPUType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('unite')
            ->add('materiaux')
            ->add('mainDoeuvre')
            ->add('materiel')
            ->add('debourseSec')
            ->add('fraisDeChantier')
            ->add('fraisGeneraux')
            ->add('margeNette')
            ->add('prixUnitaireHT')
            ->add('prixUnitaire')
            ->add('designation')
            // ->add('slug')
            // ->add('parametre', EntityType::class, [
            //     'class' => Parametres::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BPU::class,
        ]);
    }
}
