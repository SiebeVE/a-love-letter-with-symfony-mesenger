<?php

namespace App\Controller;

use App\Entity\Letter;
use App\Form\LetterType;
use App\Message\SentLetter;
use App\Repository\LetterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
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
    public function new(Request $request, LetterRepository $letterRepository, MessageBusInterface $bus): Response
    {
        $letter = new Letter();
        $form = $this->createForm(LetterType::class, $letter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $letterRepository->add($letter);
            $bus->dispatch(
              new SentLetter($letter->getId())
            );
            return $this->redirectToRoute('app_letter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('letter/new.html.twig', [
            'letter' => $letter,
            'form' => $form,
        ]);
    }
}
