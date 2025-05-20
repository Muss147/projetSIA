<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ActivityLog;
use App\Repository\ActivityLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/changes-logs')]
final class ChangesLogsController extends AbstractController
{
    #[Route('/', name: 'changes_logs')]
    public function index(Request $request, ActivityLogRepository $activityLogRepository, SessionInterface $session): Response
    {
        // Définition du menu actif
        $session->set('menu', 'logs');
        $session->set('subMenu', '');

        return $this->render('security/changes_logs.html.twig', [
            'logs' => $activityLogRepository->findAll(),
        ]);
    }

    #[Route('/{id}/delete', name: 'delete_log', methods: ['POST'])]
    public function delete(Request $request, ActivityLog $log, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$log->getId(), $request->getPayload()->getString('_token'))) {
            // $log->remove($this->getUser());
            $entityManager->flush();
        }

        return $this->redirectToRoute('permissions', [], Response::HTTP_SEE_OTHER);
    }

}
