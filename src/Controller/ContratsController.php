<?php

namespace App\Controller;

use App\Form\ContratsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContratsRepository;
use App\Entity\Contrats;
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
    public function details(Request $request, Contrats $contrat, SessionInterface $session): Response
    {
        // Définition du menu actif
        $session->set('menu', 'projets_manage');
        $session->set('subMenu', 'projets');

        $form = $this->createForm(ContratsType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contrat->updatedTimestamps();
            $contrat->updatedUserstamps($this->getUser());

            $this->em->persist($contrat);
            $this->em->flush();

            $this->addFlash('success', 'Projet ajouté avec succès.');
            return $this->redirectToRoute('projet_resume', ['projet' => $contrat->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('contrats/details.html.twig', [
            'contrat' => $contrat,
            'edit_form' => $form
        ]);
    }
}
