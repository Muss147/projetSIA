<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Parametres;
use App\Form\CategoriesType;
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
    #[Route('/categories', name: 'liste_categories')]
    public function categories(Request $request, EntityManagerInterface $entityManager, SessionInterface $session, SluggerInterface $slugger): Response
    {
        $session->set('menu', 'parametres');
        $session->set('subMenu', 'categories');
        $categories = $entityManager->getRepository(Categories::class)->findAll();

        $categorie = new Categories();
        $formCategorie = $this->createForm(CategoriesType::class, $categorie);
        $formCategorie->handleRequest($request);

        if ($formCategorie->isSubmitted() && $formCategorie->isValid()) {
            $libelle = $formCategorie->get('libelle')->getData();
            $categorie->setSlug($slugger->slug(strtolower($libelle)))->updatedTimestamps();
            $categorie->updatedUserstamps($this->getUser());

            $entityManager->persist($categorie);
            $entityManager->flush();

            $this->addFlash('success', 'Ajout effectuée avec succès.');
            return $this->redirectToRoute('liste_categories');
        }
        return $this->render('parametres/categories.html.twig', [
            'categories' => $categories,
            'new_categ' => $formCategorie
        ]);
    }

    #[Route('/categories/edit', name: 'edit_categorie')]
    public function editCategories(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        if ($request->isMethod('POST')) {
            $categorie = $entityManager->getRepository(Categories::class)->find($request->get('categ_id'));
            $libelle = $request->get('categ_libelle');
            $couleur = $request->get('categ_couleur');
            $description = $request->get('categ_description');

            $categorie->setLibelle($libelle)
                ->setSlug($slugger->slug(strtolower($libelle)))
                ->setCouleur($couleur)
                ->setDescription($description)
                ->updatedTimestamps();
            $categorie->updatedUserstamps($this->getUser());

            $entityManager->persist($categorie);
            $entityManager->flush();
            $this->addFlash('success', 'Modification de <b>'. $libelle .'</b> effectuée avec succès.');
        }
        return $this->redirectToRoute('liste_categories');
    }

    #[Route('/parametres', name: 'liste_parametres')]
    public function parametres(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $session->set('menu', 'parametres');
        $session->set('subMenu', '');
        $parametres = $entityManager->getRepository(Parametres::class)->findAll();
        return $this->render('parametres/index.html.twig', [
            'parametres' => $parametres,
        ]);
    }

    #[Route('/categories/{categorie}/delete', name: 'categorie_delete', methods: ['POST'])]
    public function deleteCategorie(Request $request, Categories $categorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->getPayload()->getString('_token'))) {
            $categorie->remove($this->getUser());
            $entityManager->flush();
        }
        $this->addFlash('success', 'Suppression effectuée avec succès.');
        return $this->redirectToRoute('liste_categories');
    }

}
