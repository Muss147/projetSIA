<?php

namespace App\Controller;

use App\Entity\Actions;
use App\Entity\Permissions;
use App\Entity\BusinessUnits;
use App\Form\BusinessUnitsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BusinessUnitsRepository;
use App\Repository\RolesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/business-units')]
final class BusinessUnitsController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    #[Route('/', name: 'bu_list')]
    public function list(Request $request, SessionInterface $session, BusinessUnitsRepository $buRepository, RolesRepository $rolesRepository): Response
    {
        $session->set('menu', 'business_units');
        
        $bu = new BusinessUnits();
        $form = $this->createForm(BusinessUnitsType::class, $bu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bu->generateSlug();
            $bu->updatedTimestamps();
            $bu->updatedUserstamps($this->getUser());

            $this->em->persist($bu);
            $this->em->flush();

            $this->addFlash('success', 'B.U ajouté avec succès.');
            return $this->redirectToRoute('bu_list', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('business_units/liste.html.twig', [
            'new_bu' => $form,
            'roles' => $rolesRepository->findAll(),
            'businessUnits' => $buRepository->findAll()
        ]);
    }

    #[Route('/modification', name: 'edit_permissions')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = $request->request->all();
        if (($request->isMethod('POST')) && $permission = $entityManager->getRepository(Permissions::class)->find($data['permission_id'])) {

            // Nettoyer les anciennes actions (optionnel selon le besoin)
            foreach ($permission->getActions() as $existingAction) {
                $permission->removeAction($existingAction);
                $entityManager->remove($existingAction);
            }

            foreach ($data['actions'] as $key => $value) {
                $action = !empty($value['id']) ? $entityManager->getRepository(Actions::class)->find($value['id']) : new Actions();
                $action->setLibelle($value['libelle']);
                
                $permission->addAction($action);
                $entityManager->persist($action);
            }

            $permission->setLibelle($data['permission_libelle'])->generateSlug();
            $permission->updatedTimestamps();
            $permission->updatedUserstamps($this->getUser());

            $entityManager->persist($permission);
            $entityManager->flush();

            $this->addFlash('success', 'Permission <b>'. $permission->getLibelle() .'</b> modifiée avec succès.');
        }
        return $this->redirectToRoute('permissions', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/delete', name: 'permission_delete', methods: ['POST'])]
    public function delete(Request $request, Permissions $permission, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$permission->getId(), $request->getPayload()->getString('_token'))) {
            $permission->remove($this->getUser());
            $entityManager->flush();
        }

        return $this->redirectToRoute('permissions', [], Response::HTTP_SEE_OTHER);
    }

}
