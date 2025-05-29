<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\BPU;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\DevisBPU;
use App\Repository\BPURepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisBPUType extends AbstractType
{
    public function __construct(
        private BPURepository $bpurepository
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $allBpus = $this->bpurepository->findAll();
        $tree = [];

        foreach ($allBpus as $bpu) {
            $niveau3 = $bpu;
            $niveau2 = $niveau3->getParent();
            $niveau1 = $niveau2 ? $niveau2->getParent() : null;
            $niveau0 = $niveau1 ? $niveau1->getParent() : null;

            if (!$niveau2 || !$niveau1 || !$niveau0) {
                continue;
            }

            $catLabel = $niveau0->getLibelle();
            $ssCatLabel = $niveau1->getLibelle();
            $rubriqueLabel = $niveau2->getLibelle();
            $bpuLabel = $niveau3->getDesignation();
            $bpuId = $niveau3->getId();

            $tree[$catLabel][$ssCatLabel][$rubriqueLabel][] = [
                'label' => $bpuLabel,
                'id' => $bpuId
            ];
        }

        $choices = [];
        $x = 0; $y = 0; $z = 0;
        foreach ($tree as $cat => $sousCats) {
            $choices[$cat] = '__disabled__'. $x;
            foreach ($sousCats as $sousCat => $rubriques) {
                $choices['— ' . $sousCat] = '__disabled__'. $x .'_'. $y;
                foreach ($rubriques as $rubrique => $bpus) {
                    $choices['—— ' . $rubrique] = '__disabled__'. $x .'_'. $y .'_'. $z;
                    foreach ($bpus as $bpu) {
                        $label = '——— ' . $bpu['label'];
                        $choices[$label] = $bpu['id'];
                    }
                    $z++;
                }
                $y++;
            }
            $x++;
        }

        $builder
            ->add('quantite', TextType::class, [
                'label' => false,
            ])
            ->add('bpu', ChoiceType::class, [
                'choices' => $choices,
                'mapped' => false,
                'choice_value' => function ($value) {
                    return $value; // ou (string) $value si tu veux forcer en string
                },
                'choice_attr' => function ($choice, $key, $value) {
                    // Les options "désactivées" auront la valeur spéciale '__disabled__'
                    if (is_string($choice) && str_contains($choice, '__disabled__')) {
                        return [
                            'disabled' => true,
                            'class' => 'fw-bold',
                        ];
                    }
                    else {
                        $bpu = $this->bpurepository->find($choice);
                        return [
                            'data-label' => trim($key),
                            'data-prix' => $bpu->getPrixUnitaireHT(),
                            'data-unite' => $bpu->getUnite(),
                            'data-hierarchie' => $bpu->getParent()?->getParent()?->getParent()?->getLibelle(). ' -> '. $bpu->getParent()?->getParent()?->getLibelle(). ' -> '. $bpu->getParent()?->getLibelle()
                        ];
                    }
                },
                'placeholder' => 'Sélectionner un BPU',
                'required' => true,
                'attr' => [
                    'class' => 'form-select form-select-solid',
                    'data-control' => 'select2'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DevisBPU::class,
        ]);
    }
}
