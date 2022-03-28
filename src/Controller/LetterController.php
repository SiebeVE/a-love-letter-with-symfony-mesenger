<?php

namespace App\Controller;

use App\Entity\Letter;
use App\Form\LetterType;
use App\LetterService\LetterService;
use App\Repository\LetterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LetterController extends AbstractController
{
    #[Route('/', name: 'app_letter_index', methods: ['GET'])]
    public function index(LetterRepository $letterRepository): Response
    {
        return $this->render('letter/index.html.twig', [
            'letters' => $letterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_letter_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LetterRepository $letterRepository, LetterService $letterService): Response
    {
        $letter = new Letter();
        $form = $this->createForm(LetterType::class, $letter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $letterRepository->add($letter);
            $letterService->send($letter);
            return $this->redirectToRoute('app_letter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('letter/new.html.twig', [
            'letter' => $letter,
            'form' => $form,
        ]);
    }
}
