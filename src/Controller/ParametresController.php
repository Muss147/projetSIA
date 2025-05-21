<?php

namespace App\Controller;

use App\Entity\Parametres;
use App\Form\ParametresType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/parametres')]
final class ParametresController extends AbstractController
{
    public function __construct(
        private SluggerInterface $slugger,
        private EntityManagerInterface $em
    ) {}

    #[Route('/{type}', name: 'param_type')]
    public function param_type(Request $request, SessionInterface $session): Response
    {
        $session->set('menu', 'parametres');
        $parametres = $this->em->getRepository(Parametres::class)->findAll();

        $parametre = new Parametres();
        $form = $this->createForm(ParametresType::class, $parametre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $libelle = $form->get('libelle')->getData();
            $parametre->setSlug($this->slugger->slug(strtolower($libelle)))->updatedTimestamps();
            $parametre->updatedUserstamps($this->getUser());

            $this->em->persist($parametre);
            $this->em->flush();

            $this->addFlash('success', 'Ajout effectuée avec succès.');
            return $this->redirectToRoute('param_type');
        }
        return $this->render('parametres/liste.html.twig', [
            'parametres' => $parametres,
            'new_categ' => $form
        ]);
    }

    // #[Route('/categories/edit', name: 'edit_categorie')]
    // public function editCategories(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    // {
    //     if ($request->isMethod('POST')) {
    //         $categorie = $entityManager->getRepository(Categories::class)->find($request->get('categ_id'));
    //         $libelle = $request->get('categ_libelle');
    //         $couleur = $request->get('categ_couleur');
    //         $description = $request->get('categ_description');

    //         $categorie->setLibelle($libelle)
    //             ->setSlug($slugger->slug(strtolower($libelle)))
    //             ->setCouleur($couleur)
    //             ->setDescription($description)
    //             ->updatedTimestamps();
    //         $categorie->updatedUserstamps($this->getUser());

    //         $entityManager->persist($categorie);
    //         $entityManager->flush();
    //         $this->addFlash('success', 'Modification de <b>'. $libelle .'</b> effectuée avec succès.');
    //     }
    //     return $this->redirectToRoute('liste_categories');
    // }

    // #[Route('/parametres', name: 'liste_parametres')]
    // public function parametres(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    // {
    //     $session->set('menu', 'parametres');
    //     $session->set('subMenu', '');
    //     $parametres = $entityManager->getRepository(Parametres::class)->findAll();
    //     return $this->render('parametres/index.html.twig', [
    //         'parametres' => $parametres,
    //     ]);
    // }

    // #[Route('/categories/{categorie}/delete', name: 'categorie_delete', methods: ['POST'])]
    // public function deleteCategorie(Request $request, Categories $categorie, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->getPayload()->getString('_token'))) {
    //         $categorie->remove($this->getUser());
    //         $entityManager->flush();
    //     }
    //     $this->addFlash('success', 'Suppression effectuée avec succès.');
    //     return $this->redirectToRoute('liste_categories');
    // }

}
