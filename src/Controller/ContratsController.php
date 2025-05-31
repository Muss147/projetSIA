<?php

namespace App\Controller;

use App\Repository\UtilitairesRepository;
use App\Repository\ChefChantierRepository;
use App\Repository\ClientsRepository;
use App\Form\DevisType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContratsRepository;
use App\Entity\Contrats;
use App\Entity\Devis;
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

    #[Route('/details/{contrat}', name: 'contrat_details')]
    public function details(Request $request, Contrats $contrat, SessionInterface $session, BPURepository $bpuRepository): Response
    {
        // Définition du menu actif
        $session->set('menu', 'projets_manage');
        $session->set('subMenu', 'projets');

        // Formulaire de Devis
        $devis = $contrat->getDevis() ?? new Devis();
        $devis->setContrat($contrat);
        $devis_form = $this->createForm(DevisType::class, $devis);

        foreach ($devis->getDevisBPUs() as $key => $value) {
            $devis_form->get('devisBPUs')[$key]->get('bpu')->setData($value->getBpu()?->getId());
        }

        $devis_form->handleRequest($request);

        if ($devis_form->isSubmitted() && $devis_form->isValid()) {
            $requestDevis = $request->get('devis');
            foreach ($requestDevis['devisBPUs'] as $key => $value) {
                $bpu = $bpuRepository->find($value['bpu']);
                $devis->getDevisBPUs()[$key]->setBpu($bpu);
            }

            $devis->updatedTimestamps();
            $devis->updatedUserstamps($this->getUser());

            $this->em->persist($devis);
            $this->em->flush();

            $this->addFlash('success', 'Devis enregistré avec succès.');
            return $this->redirectToRoute('contrat_details', ['contrat' => $contrat->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('contrats/details.html.twig', [
            'contrat' => $contrat,
            'devis_form' => $devis_form,
        ]);
    }

    #[Route('/projet-{projet}/edit', name: 'contrat_edit_wProjet')]
    #[Route('/edit', name: 'contrat_edit')]
    public function edit(Request $request, ContratsRepository $contratsRepository, ClientsRepository $clientsRepository, ChefChantierRepository $chefChantierRepository, UtilitairesRepository $utilitairesRepository): Response
    {
        $projet = $request->get('projet');
        // dd($request);
        if ($request->getMethod('POST') && $contrat = $contratsRepository->find($request->get('contrat_id'))) {
            $nom = $request->get('contrat_nom') ?? null;
            $type = $utilitairesRepository->find($request->get('contrat_typeContrat'));
            $client = $clientsRepository->find($request->get('contrat_client'));
            $chef = $chefChantierRepository->find($request->get('contrat_chefChantier'));
            $debut = new \DateTime($request->get('contrat_dateDebut')) ?? null;
            $fin = new \DateTime($request->get('contrat_dateFin')) ?? null;
            $montant = $request->get('contrat_montant') ?? null;
            $taux = $request->get('contrat_tauxGarantie') ?? null;
            $description = $request->get('contrat_description') ?? null;

            $contrat->setNom($nom)
                ->setTypeTravaux($type)
                ->setClient($client)
                ->setChefChantier($chef)
                ->setDateDebut($debut)
                ->setDateFin($fin)
                ->setMontant($montant)
                ->setTauxGarantie($taux)
                ->setDescription($description)
            ;
            $contrat->updatedTimestamps();
            $contrat->updatedUserstamps($this->getUser());

            $this->em->persist($contrat);
            $this->em->flush();

            $this->addFlash('success', 'Modification effectuée avec succès.');
            // return $this->redirect($request->headers->get('referer'));
        }
        
        if ($projet) return $this->redirectToRoute('projet_contrats', ['projet' => $projet], Response::HTTP_SEE_OTHER);
        else return $this->redirectToRoute('contrats_list');
    }

    #[Route('/{contrat}/delete', name: 'contrat_delete', methods: ['POST'])]
    public function delete(Request $request, Contrats $contrat, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contrat->getId(), $request->getPayload()->getString('_token'))) {
            $contrat->remove($this->getUser());
            $em->flush();
        }
        return $this->redirectToRoute('contrats_list', [], Response::HTTP_SEE_OTHER);
    }
}
