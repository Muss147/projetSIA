<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\Projets;
use App\Entity\Contrats;
use App\Entity\Utilitaires;
use App\Entity\ChefChantier;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ContratsType extends AbstractType
{
    public function __construct(private UrlGeneratorInterface $urlGenerator) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('tauxGarantie')
            ->add('montant')
            ->add('description')
            ->add('typeTravaux', EntityType::class, [
                'class' => Utilitaires::class,
                'choice_label' => 'libelle',
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('u')
                        ->where('u.type = :type')
                        ->andWhere('u.deletedAt IS NULL')
                        ->setParameter('type', "Type de contrat")
                    ;
                },
            ])
            ->add('client', EntityType::class, [
                'class' => Clients::class,
                'choice_label' => 'nom',
                'choice_attr' => function ($choice, $key, $value) {
                    /** @var ChefChantier $choice */
                    $avatarPath = 'assets/media/svg/avatars/blank.svg';
                    $avatarUrl = $this->urlGenerator->generate('acceuil', [], UrlGeneratorInterface::ABSOLUTE_URL); // temporaire
                    $avatarUrl = preg_replace('#/+$#', '', $avatarUrl) . '/' . ltrim($avatarPath, '/');
                    return [
                        'data-kt-select2-user' => $avatarUrl,
                    ];
                },
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.deletedAt IS NULL')
                    ;
                },
            ])
            ->add('chefChantier', EntityType::class, [
                'class' => ChefChantier::class,
                'choice_label' => 'nomComplet',
                'choice_attr' => function ($choice, $key, $value) {
                    /** @var ChefChantier $choice */
                    $avatarPath = 'assets/media/svg/avatars/blank.svg';
                    $avatarUrl = $this->urlGenerator->generate('acceuil', [], UrlGeneratorInterface::ABSOLUTE_URL); // temporaire
                    $avatarUrl = preg_replace('#/+$#', '', $avatarUrl) . '/' . ltrim($avatarPath, '/');
                    return [
                        'data-kt-select2-user' => $avatarUrl,
                    ];
                },
            ])
        ;
        if ($options['form_type'] === 'completForm') {
            $builder->add('projet', EntityType::class, [
                'class' => Projets::class,
                'choice_label' => 'libelle',
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('p')
                        ->andWhere('p.deletedAt IS NULL')
                    ;
                },
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrats::class,
            'form_type' => 'simpleForm',
        ]);
    }
}
