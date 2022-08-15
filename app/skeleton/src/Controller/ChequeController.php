<?php

namespace App\Controller;

use App\Entity\Cheque;
use App\Form\ChequeType;
use App\Repository\ChequeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/cheque')]
class ChequeController extends AbstractController
{
    #[Route('/', name: 'app_cheque_index', methods: ['GET'])]
    public function index(ChequeRepository $chequeRepository): Response
    {
        return $this->render('cheque/index.html.twig', [
            'cheques' => $chequeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cheque_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ChequeRepository $chequeRepository): Response
    {
        $cheque = new Cheque();
        $form = $this->createForm(ChequeType::class, $cheque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chequeRepository->add($cheque, true);

            return $this->redirectToRoute('app_cheque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cheque/new.html.twig', [
            'cheque' => $cheque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cheque_show', methods: ['GET'])]
    public function show(Cheque $cheque): Response
    {
        $this->denyAccessUnlessGranted('VIEW', $cheque);
        return $this->render('cheque/show.html.twig', [
            'cheque' => $cheque,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_cheque_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cheque $cheque, ChequeRepository $chequeRepository): Response
    {
        $this->denyAccessUnlessGranted('EDIT', $cheque);

        $form = $this->createForm(ChequeType::class, $cheque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chequeRepository->add($cheque, true);

            return $this->redirectToRoute('app_cheque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cheque/edit.html.twig', [
            'cheque' => $cheque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cheque_delete', methods: ['POST'])]
    public function delete(Request $request, Cheque $cheque, ChequeRepository $chequeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cheque->getId(), $request->request->get('_token'))) {
            $chequeRepository->remove($cheque, true);
        }

        return $this->redirectToRoute('app_cheque_index', [], Response::HTTP_SEE_OTHER);
    }
}
