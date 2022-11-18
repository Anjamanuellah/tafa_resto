<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Entity\Commande;
use App\Form\CommandeType;
use Doctrine\ORM\EntityManager;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="app_commande")
     * 
     */
    public function index(): Response
    {
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
    /**
     * @Route("/commande/{id}", name="app_commande_show")
     * @isGranted("ROLE_USER")
     */
    public function show(Plat $plat, Request $request, PlatRepository $platRepository, EntityManagerInterface $manager): Response
    {
        $commande = new Commande();

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            
            $commande->setUser($this->getUser());

            $commande->setPlat($plat);

            $plat->setQuantite($plat->getQuantite() - $commande->getQuantite());

            $manager->persist($commande);
            $manager->persist($plat);

            $manager->flush();

            return $this->redirectToRoute('app_resto');

        }

        return $this->render('commande/show.html.twig', [
            'form' => $form->createView(),
            'plat' => $plat,
        ]);
    }
    
}
