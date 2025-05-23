<?php

namespace App\Controller;

use App\Entity\Contrats;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contrats')]
final class ContratsController extends AbstractController
{
    #[Route('/', name: 'contrats_list')]
    public function index(): Response
    {
        return $this->render('contrats/index.html.twig', [
            'controller_name' => 'ContratsController',
        ]);
    }

    #[Route('/{contrat}', name: 'contrat_details')]
    public function details(Request $request, Contrats $contrat): Response
    {
        return $this->render('contrats/details.html.twig', [
            'contrat' => $contrat,
        ]);
    }
}
