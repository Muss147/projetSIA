<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\Enfants;
use App\Form\ClientsType;
use App\Form\EnfantsType;
use App\Entity\Categories;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/clients')]
final class ClientsController extends AbstractController
{
    #[Route('/', name: 'liste_clients')]
    public function index(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        $session->set('menu', 'clients');
        $session->set('subMenu', '');
        $clients = $entityManager->getRepository(Clients::class)->findAll();
        $categories = $entityManager->getRepository(Categories::class)->findAll();

        $client = new Clients();
        $formClient = $this->createForm(ClientsType::class, $client, ['form_type' => 'add']);
        $formClient->handleRequest($request);

        if ($formClient->isSubmitted() && $formClient->isValid()) {

            // Lier chaque enfant au parent (client courant)
            foreach ($client->getEnfants() as $enfant) {
                $enfant->setParent($client);
                $entityManager->persist($enfant); // si orphanRemoval et cascade persist ne sont pas utilisés
            }

            $client->updatedTimestamps();
            $client->updatedUserstamps($this->getUser());

            $entityManager->persist($client);
            $entityManager->flush();

            $this->addFlash('success', 'Client ajouté avec succès.');
            return $this->redirectToRoute('liste_clients', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/clients/liste.html.twig', [
            'form_client' => $formClient,
            'clients' => $clients,
            'categories' => $categories
        ]);
    }

    #[Route('/{id}/details', name: 'detail_client')]
    public function view(Request $request, Clients $client, EntityManagerInterface $entityManager, SessionInterface $session, ClientsRepository $clientsRepository): Response
    {
        $session->set('menu', 'clients');
        $session->set('subMenu', '');

        $edit_client = $this->createForm(ClientsType::class, $client, ['form_type' => 'edit']);
        $edit_client->handleRequest($request);

        $enfant = new Enfants();
        $new_enfant = $this->createForm(EnfantsType::class, $enfant, ['form_view' => 'detail_client']);
        $new_enfant->handleRequest($request);

        if ($edit_client->isSubmitted() && $edit_client->isValid()) {
            
            $client->updatedTimestamps();
            $client->updatedUserstamps($this->getUser());
            
            $entityManager->persist($client);
            $entityManager->flush();

            $this->addFlash('success', 'Modification de <b>'. $client->getNomComplet() .'</b> effectué avec succès.');
            return $this->redirectToRoute('detail_client', ['id' => $client->getId()], Response::HTTP_SEE_OTHER);
        }
        elseif ($new_enfant->isSubmitted() && $new_enfant->isValid()) {
            // Lier l'enfant au parent (client courant)
            $enfant->setParent($client)->updatedTimestamps();
            $enfant->updatedUserstamps($this->getUser());
            
            $entityManager->persist($enfant);
            $entityManager->flush();

            $this->addFlash('success', 'Ajout de l\'enfant effectué avec succès.');
            return $this->redirectToRoute('detail_client', ['id' => $client->getId()], Response::HTTP_SEE_OTHER);
        }
        elseif (
            $request->isMethod('POST') &&
            $editEnfant = $entityManager->getRepository(Enfants::class)->find($request->get('enfant_id'))
            ) {

            $editEnfant->setNomComplet($request->get('enfant_nomComplet'))
                ->setAge($request->get('enfant_age'))
                ->setTaille($request->get('enfant_taille') ?? null)
                ->setPointure($request->get('enfant_pointure') ?? null)
                ->updatedTimestamps();
            $editEnfant->updatedUserstamps($this->getUser());
            
            $entityManager->persist($editEnfant);
            $entityManager->flush();

            $this->addFlash('success', 'Modification de l\'enfant <b>'. $editEnfant->getNomComplet() .'</b> effectué avec succès.');
            return $this->redirectToRoute('detail_client', ['id' => $client->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/clients/details.html.twig', [
            'client' => $client,
            'edit_client' => $edit_client,
            'new_enfant' => $new_enfant,
        ]);
    }

    #[Route('/{id}/delete-enfant', name: 'enfant_delete', methods: ['POST'])]
    public function deleteEnfant(Request $request, Enfants $enfant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enfant->getId(), $request->getPayload()->getString('_token'))) {
            $enfant->remove($this->getUser());
            $entityManager->flush();
        }
        return $this->redirectToRoute('detail_client', ['id' => $enfant->getParent()->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/delete', name: 'clients_delete', methods: ['POST'])]
    public function deleteClient(Request $request, Clients $client, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->getPayload()->getString('_token'))) {
            $client->remove($this->getUser());
            $entityManager->flush();
        }

        return $this->redirectToRoute('clients', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete-selection', name: 'clients_delete_select', methods: ['POST'])]
    public function delete_select(Request $request, EntityManagerInterface $entityManager, ClientsRepository $clientsRepository): Response
    {
        // Récupérer les données JSON de la requête
        $data = json_decode($request->getContent(), true);

        if ($request->isXmlHttpRequest()) {
            foreach ($data['clientsDeleted'] as $id) {
                if ($client = $clientsRepository->find($id)) $client->remove($this->getUser());
                $entityManager->flush();
            }
        }
        return new JsonResponse($data, 200);
    }
}
