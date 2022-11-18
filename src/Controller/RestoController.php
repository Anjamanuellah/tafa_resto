<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class RestoController extends AbstractController
{
    /**
     * @Route("/acceuil", name="app_resto", methods={"GET","POST"})
     */
    public function index(PlatRepository $platRepository): Response
    {
        return $this->render('resto/index.html.twig', [
            'plats' => $platRepository->findAll(),
        ]);
    }
    /**
     * @Route("/unplat/{id}", name="app_unplat", methods="GET")
     */
    public function plat(Plat $plat): Response
    {
        return $this->render('resto/unplat.html.twig',  [
            'plat' => $plat,
        ]);
    }

}
