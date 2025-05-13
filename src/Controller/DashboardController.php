<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function dashboard(SessionInterface $session): Response
    {
        $session->set('menu', 'dashboard');
        $session->set('subMenu', '');
        return $this->render('dashboard.html.twig');
    }
}
