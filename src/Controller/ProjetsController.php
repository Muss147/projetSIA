<?php

namespace App\Controller;

use App\Entity\Projets;
use App\Entity\Contrats;
use App\Form\ProjetsForm;
use App\Form\ProjetsType;
use App\Form\ContratsType;
use App\Repository\ProjetsRepository;
use App\Repository\ContratsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BusinessUnitsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/projets')]
final class ProjetsController extends AbstractController
{
    public function __construct(
        private ProjetsRepository $projetsRepository,
        private EntityManagerInterface $em
    ) {}

    #[Route('/', name: 'projets_list')]
    public function index(Request $request, SessionInterface $session, BusinessUnitsRepository $businessUnitsRepository): Response
    {
        // Définition du menu actif
        $session->set('menu', 'projets_manage');
        $session->set('subMenu', 'projets');
        $projets = $this->projetsRepository->findAll();

        $projet = new Projets();
        $projet->setBusinessUnit($businessUnitsRepository->find(1)); // À reconfigurer
        $form = $this->createForm(ProjetsType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $projet->updatedTimestamps();
            $projet->updatedUserstamps($this->getUser());

            $this->em->persist($projet);
            $this->em->flush();

            $this->addFlash('success', 'Projet ajouté avec succès.');
            return $this->redirectToRoute('projet_resume', ['projet' => $projet->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('projets/liste.html.twig', [
            'projets' => $projets,
            'new_form' => $form
        ]);
    }

    #[Route('/{projet}/details', name: 'projet_resume')]
    public function details(Request $request, Projets $projet, SessionInterface $session): Response
    {
        // Définition du menu actif
        $session->set('menu', 'projets_manage');
        $session->set('subMenu', 'projets');
        $session->set('navMenu', 'details');
        
        $form = $this->createForm(ProjetsType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $projet->updatedTimestamps();
            $projet->updatedUserstamps($this->getUser());

            $this->em->persist($projet);
            $this->em->flush();

            $this->addFlash('success', 'Modification effectuée avec succès.');
            return $this->redirectToRoute('projet_resume', ['projet' => $projet->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('projets/details_resume.html.twig', [
            'projet' => $projet,
            'edit_form' => $form
        ]);
    }

    #[Route('/{projet}/contrats', name: 'projet_contrats')]
    public function contrats(Request $request, Projets $projet, SessionInterface $session): Response
    {
        // Définition du menu actif
        $session->set('menu', 'projets_manage');
        $session->set('subMenu', 'projets');
        $session->set('navMenu', 'contrats');
        
        $contrat = new Contrats();
        $contrat->setProjet($projet)->setClient($projet->getClient());
        $form = $this->createForm(ContratsType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contrat->updatedTimestamps();
            $contrat->updatedUserstamps($this->getUser());

            $this->em->persist($contrat);
            $this->em->flush();

            $this->addFlash('success', 'Projet ajouté avec succès.');
            return $this->redirectToRoute('projet_contrats', ['projet' => $projet->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('projets/details_contrats.html.twig', [
            'projet' => $projet,
            'new_form' => $form
        ]);
    }

    #[Route('/{projet}/stock', name: 'projet_stock')]
    public function stock(Request $request, Projets $projet, SessionInterface $session): Response
    {
        // Définition du menu actif
        $session->set('menu', 'projets_manage');
        $session->set('subMenu', 'projets');
        $session->set('navMenu', 'stock');
        
        return $this->render('projets/details_stock.html.twig', [
            'projet' => $projet,
        ]);
    }

    #[Route('/{projet}/transfert', name: 'projet_transfert')]
    public function transfert(Request $request, Projets $projet, SessionInterface $session): Response
    {
        // Définition du menu actif
        $session->set('menu', 'projets_manage');
        $session->set('subMenu', 'projets');
        $session->set('navMenu', 'transfert');
        
        return $this->render('projets/details_transfert.html.twig', [
            'projet' => $projet,
        ]);
    }

    #[Route('/{projet}/documents', name: 'projet_documents')]
    public function documents(Request $request, Projets $projet, SessionInterface $session): Response
    {
        // Définition du menu actif
        $session->set('menu', 'projets_manage');
        $session->set('subMenu', 'projets');
        $session->set('navMenu', 'documents');
        
        return $this->render('projets/details_documents.html.twig', [
            'projet' => $projet,
        ]);
    }
}
