<?php

namespace App\Controller;

use App\Repository\BusinessUnitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/', name: 'acceuil')]
    public function acceuil(BusinessUnitsRepository $businessUnitsRepository): Response
    {
        $businessUnits = $businessUnitsRepository->findAll();
        // if (count($businessUnits) == 0) return $this->redirectToRoute('dashboard');

        return $this->render('acceuil.html.twig', [
            'businessUnits' => $businessUnits
        ]);
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(SessionInterface $session): Response
    {
        $session->set('menu', 'dashboard');
        $session->set('subMenu', '');
        return $this->render('dashboard.html.twig');
    }
}
