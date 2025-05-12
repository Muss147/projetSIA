<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LoginListener
{
    private EntityManagerInterface $entityManager;
    private $tokenStorage;
    private $router;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, RouterInterface $router)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $request = $event->getRequest();

        if (!$user->isActivated()) {
            // Déconnecter l'utilisateur
            $this->tokenStorage->setToken(null);
            
            // Invalider la session de l'utilisateur
            $request->getSession()->invalidate();
            
            // Redirection via une réponse à gérer dans le contrôleur
            $response = new RedirectResponse($this->router->generate('app_desactivated'));
            // Retourner la réponse
            $request->getSession()->set('_security.main.target_path', $this->router->generate('app_desactivated'));
        }
        elseif ($user instanceof \App\Entity\Users) {
            $user->setLastLogin(new \DateTime());
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
    }
}
