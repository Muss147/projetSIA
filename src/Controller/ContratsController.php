<?php

namespace App\Controller;

use App\Form\DevisType;
use App\Form\ContratsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContratsRepository;
use App\Entity\Contrats;
use App\Entity\Devis;
use App\Entity\DevisBPU;
use App\Repository\BPURepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contrats')]
final class ContratsController extends AbstractController
{
    public function __construct(
        private ContratsRepository $projetsRepository,
        private EntityManagerInterface $em
    ) {}

    #[Route('/', name: 'contrats_list')]
    public function index(): Response
    {
        return $this->render('contrats/index.html.twig', [
            'controller_name' => 'ContratsController',
        ]);
    }

    #[Route('/{contrat}', name: 'contrat_details')]
    public function details(Request $request, Contrats $contrat, SessionInterface $session, BPURepository $bpuRepository): Response
    {
        // Définition du menu actif
        $session->set('menu', 'projets_manage');
        $session->set('subMenu', 'projets');

        // Formulaire de contrat
        $contrat_form = $this->createForm(ContratsType::class, $contrat);
        $contrat_form->handleRequest($request);
        if ($contrat_form->isSubmitted() && $contrat_form->isValid()) {

            $contrat->updatedTimestamps();
            $contrat->updatedUserstamps($this->getUser());

            $this->em->persist($contrat);
            $this->em->flush();

            $this->addFlash('success', 'Projet ajouté avec succès.');
            return $this->redirectToRoute('projet_resume', ['projet' => $contrat->getId()], Response::HTTP_SEE_OTHER);
        }

        // Formulaire de Devis
        $devis = $contrat->getDevis() ?? new Devis();

        $devis->setContrat($contrat);
        $devis_form = $this->createForm(DevisType::class, $devis);

        foreach ($devis->getDevisBPUs() as $key => $value) {
            $devis_form->get('devisBPUs')[$key]->get('bpu')->setData($value->getBpu()?->getId());
        }
        // dd($devis_form);

        $devis_form->handleRequest($request);

        if ($devis_form->isSubmitted() && $devis_form->isValid()) {
            // $bpuId = $form->get('bpu')->getData();
            // $bpu = $bpurepository->find($bpuId);
            // $entity->setBpu($bpu);

            $devis->updatedTimestamps();
            $devis->updatedUserstamps($this->getUser());

            $this->em->persist($devis);
            $this->em->flush();

            $this->addFlash('success', 'Projet ajouté avec succès.');
            return $this->redirectToRoute('projet_resume', ['projet' => $contrat->getId()], Response::HTTP_SEE_OTHER);
        }
        // Exemple (structure JSON à passer à Twig)
        // $bpus = $bpuRepository->findAll(); // ou une méthode pour récupérer la hiérarchie
        // $selectOptions = [];
        // foreach ($bpus as $bpu) {
        //     $cat = $bpu->getParent()?->getParent()?->getParent()?->getLibelle() ?? null;
        //     $subcat = $bpu->getParent()?->getParent()?->getLibelle() ?? null;
        //     $rubrique = $bpu->getParent()?->getLibelle() ?? null;

        //     $selectOptions[$cat][$subcat][$rubrique][] = [
        //         'id' => $bpu->getId(),
        //         'designation' => $bpu->getDesignation(),
        //         'prix' => $bpu->getPrixUnitaire()
        //     ];
        // }
        return $this->render('contrats/details.html.twig', [
            'contrat' => $contrat,
            'contrat_form' => $contrat_form,
            'devis_form' => $devis_form,
            // 'selectOptions' => $selectOptions,
        ]);
    }
}
