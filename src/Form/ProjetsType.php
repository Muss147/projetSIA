<?php

namespace App\Form;

use App\Entity\BusinessUnits;
use App\Entity\Clients;
use App\Entity\Projets;
use App\Entity\Users;
use App\Entity\Utilitaires;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProjetsType extends AbstractType
{

    public function __construct(private UrlGeneratorInterface $urlGenerator) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('conducteurTravaux')
            ->add('tva')
            ->add('client', EntityType::class, [
                'class' => Clients::class,
                'choice_label' => 'nom',
                'choice_attr' => function ($choice, $key, $value) {
                    /** @var Clients $choice */
                    $avatarPath = 'assets/media/svg/avatars/blank.svg';
                    $avatarUrl = $this->urlGenerator->generate('acceuil', [], UrlGeneratorInterface::ABSOLUTE_URL); // temporaire
                    $avatarUrl = preg_replace('#/+$#', '', $avatarUrl) . '/' . ltrim($avatarPath, '/');
                    return [
                        'data-kt-select2-user' => $avatarUrl,
                    ];
                },
            ])
            ->add('secteurActivite', EntityType::class, [
                'class' => Utilitaires::class,
                'choice_label' => 'libelle',
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('u')
                        ->where('u.type = :type')
                        ->andWhere('u.deletedAt IS NULL')
                        ->setParameter('type', "Secteurs d'activité")
                    ;
                },
            ])
            // ->add('businessUnit', EntityType::class, [
            //     'class' => BusinessUnits::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projets::class,
        ]);
    }
}
