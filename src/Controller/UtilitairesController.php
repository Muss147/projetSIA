<?php

namespace App\Controller;

use App\Entity\Utilitaires;
use App\Form\UtilitairesType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilitairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/utilitaires')]
final class UtilitairesController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    #[Route('/', name: 'utilitaires_list')]
    public function index(SessionInterface $session): Response
    {
        // Définition du menu actif
        $session->set('menu', 'utilitaires');
        $session->set('subMenu', '');
        return $this->render('utilitaires/carrefour.html.twig');
    }

    #[Route('/{type}', name: 'utilitaires_type')]
    public function types(Request $request, $type, UtilitairesRepository $utilitairesRepository, SessionInterface $session): Response
    {
        // Définition du menu actif
        $session->set('menu', 'utilitaires');
        $session->set('subMenu', '');

        $utilitaire = new Utilitaires();
        $utilitaire->setType($type);
        // $utilitaire->setParent($dataParent);

        $form = $this->createForm(UtilitairesType::class, $utilitaire);
        $form->handleRequest($request);
        
        // dd($parent);
        if ($form->isSubmitted() && $form->isValid()) {
            $utilitaire->updatedTimestamps();
            $utilitaire->updatedUserstamps($this->getUser());

            $this->em->persist($utilitaire);
            $this->em->flush();
    
            $this->addFlash('success', $type .' ajouté(e) avec succès.');
            return $this->redirectToRoute('param_type', ['type' => $type, 'parent' => $parent ?? null]);
        }
        $utilitaires = $utilitairesRepository->findByType($type);
        return $this->render('utilitaires/liste.html.twig', [
            'type' => $type,
            'new_form' => $form,
            'utilitaires' => $utilitaires
        ]);
    }

    #[Route('/delete/{utilitaire}', name: 'utilitaire_delete', methods: ['POST'])]
    public function deleteCategorie(Request $request, Utilitaires $utilitaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilitaire->getId(), $request->getPayload()->getString('_token'))) {
            $utilitaire->remove($this->getUser());
            $this->em->flush();
        }
        $this->addFlash('success', 'Suppression effectuée avec succès.');
        return $this->redirectToRoute('utilitaires_type', ['type' => $utilitaire->getType(), 'parent' => $utilitaire->getParent() ?? null]);
    }

    #[Route('/delete-utilitaires-selected', name: 'utilitaire_selected_delete', methods: ['POST'])]
    public function deleteUsersSelected(Request $request, UtilitairesRepository $utilitairesRepository): Response
    {
        // Récupérer les données JSON de la requête
        $data = json_decode($request->getContent(), true);

        if ($request->isXmlHttpRequest()) {
            foreach ($data['usersDeleted'] as $id) {
                if ($utilitaire = $utilitairesRepository->find($id)) $utilitaire->remove($this->getUser());
                $this->em->flush();
            }
        }
        return new JsonResponse(true, 200);
    }
}
