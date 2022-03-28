<?php

namespace App\Controller;

use App\Entity\Package;
use App\Form\PackageType;
use App\Message\SentPackage;
use App\Repository\PackageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/package')]
class PackageController extends AbstractController
{
    #[Route('/', name: 'app_package_index', methods: ['GET'])]
    public function index(PackageRepository $packageRepository): Response
    {
        return $this->render('package/index.html.twig', [
            'packages' => $packageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_package_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PackageRepository $packageRepository, MessageBusInterface $bus): Response
    {
        $package = new Package();
        $form = $this->createForm(PackageType::class, $package);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $packageRepository->add($package);
            $bus->dispatch(
                new SentPackage($package->getId())
            );
            return $this->redirectToRoute('app_package_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('package/new.html.twig', [
            'package' => $package,
            'form' => $form,
        ]);
    }
}
