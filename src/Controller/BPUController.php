<?php

namespace App\Controller;

use App\Entity\BPU;
use App\Form\BPUType;
use App\Entity\Parametres;
use App\Repository\BPURepository;
use App\Repository\ParametresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/bordereau-des-prix-unitaires')]
final class BPUController extends AbstractController
{
    public function __construct(
        private SluggerInterface $slugger,
        private EntityManagerInterface $em
    ) {}

    #[Route('/rubrique-{parent}', name: 'bpu_list')]
    public function bpu_list(Request $request, Parametres $parent, BPURepository $bpuRepository, SessionInterface $session): Response
    {
        $session->set('menu', 'bpu');
        $parametres = $bpuRepository->findByParametre($parent);

        $parametre = new BPU();
        // Pré-remplir les actions possibles de cette permission
        $parametre->setParametre($parent);

        $form = $this->createForm(BPUType::class, $parametre);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $parametre->generateSlug();
            $parametre->updatedTimestamps();
            $parametre->updatedUserstamps($this->getUser());

            $this->em->persist($parametre);
            $this->em->flush();
    
            $this->addFlash('success', ' ajout effectué avec succès.');
            return $this->redirectToRoute('bpu_list', ['parent' => $parent->getId()]);
        }
        return $this->render('parametres/bpu.html.twig', [
            'BPUs' => $parametres,
            'new_form' => $form,
            'parent' => $parent
        ]);
    }

    #[Route('/modification', name: 'bpu_edit')]
    public function editBPU(Request $request, ParametresRepository $parametresRepository): Response
    {
        if ($request->isMethod('POST') &&
            $parametre = $parametresRepository->find($request->get('param_id'))) {
            
            $libelle = $request->get('param_libelle');

            $parametre->setLibelle($libelle)->generateSlug();
            $parametre->updatedTimestamps();
            $parametre->updatedUserstamps($this->getUser());

            $this->em->persist($parametre);
            $this->em->flush();
            $this->addFlash('success', 'Modification de <b>'. $libelle .'</b> effectuée avec succès.');
        }
        return $this->redirectToRoute('bpu_list', ['type' => $parametre->getType(), 'parent' => $parametre->getParent() ?? null]);
    }

    #[Route('/delete/{param}', name: 'bpu_delete', methods: ['POST'])]
    public function deleteBPU(Request $request, BPU $param): Response
    {
        if ($this->isCsrfTokenValid('delete'.$param->getId(), $request->getPayload()->getString('_token'))) {
            $param->remove($this->getUser());
            $this->em->flush();
        }
        $this->addFlash('success', 'Suppression effectuée avec succès.');
        return $this->redirectToRoute('bpu_list', ['parent' => $param->getParametre()->getId() ?? null]);
    }

    #[Route('/delete-params-selected', name: 'bpu_selected_delete', methods: ['POST'])]
    public function deleteBPUSelected(Request $request, BPURepository $bpuRepository): Response
    {
        // Récupérer les données JSON de la requête
        $data = json_decode($request->getContent(), true);

        if ($request->isXmlHttpRequest()) {
            foreach ($data['usersDeleted'] as $id) {
                if ($param = $bpuRepository->find($id)) $param->remove($this->getUser());
                $this->em->flush();
            }
        }
        return new JsonResponse(true, 200);
    }
}
