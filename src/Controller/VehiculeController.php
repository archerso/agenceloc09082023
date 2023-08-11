<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeFormType;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VehiculeController extends AbstractController
{
    #[Route('/admin', name: 'app_vehicule')]
    public function index(): Response
    {
        return $this->render('vehicule/index.html.twig', [
            'controller_name' => 'VehiculeController',
        ]);
    }

    
    #[Route('/admin/ajoutVehicule', name: 'ajout_vehicule')]
    public function ajoutvehicule(Request $request, EntityManagerInterface $manager)
    { 
        // return $this->render(admin/ajoutVehicule.html.twig);
        $vehicule = new Vehicule;
        $form = $this->createForm(VehiculeFormType::class, $vehicule);
        
        $form->handleRequest($request);  
        
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($vehicule);
            $manager->flush();
            return $this->redirectToRoute('ajout_vehicule'); 
        }
        return $this->render('admin/ajoutVehicule.html.twig', [
            'formvoiture' => $form, 
            'vehicule' => $vehicule,
        ]);
    }
    // modifier les modeles de voitures pour l'administrateur
    // #[Route('/admin/{id}/modifier', name: 'modifier_vehicule')]
    #[Route('/admin/modifier', name: 'modifier_vehicule')]
    public function modifiervehicule(Vehicule $vehicule = null, Request $request, EntityManagerInterface $manager)
    { 
        dump($vehicule);
        if($vehicule)
        {
        $vehicule = new Vehicule;
        }
        $form = $this->createForm(VehiculeFormType::class, $vehicule);
        
        $form->handleRequest($request);  
        
        if($form->isSubmitted() && $form->isValid())
        {
            if(!$vehicule->getId())

        {
           $manager->persist($vehicule);
            $manager->flush();
        }
        $this->addFlash('success', 'Les modifications ont bien été enregistrés'); 
        return $this->redirectToRoute('ajout_vehicule');

        return $this->render('admin/ajoutVehicule.html.twig', [
            'formvoiture' => $form, 
            'vehicule' => $vehicule,
        ]);
    }
    }

        // supprimer des modeles de voitures pour l'admin
        // #[Route('admin/supprimer/{id}', name:"supprimer_vehicule")]
            // #[Route('/admin/supprimer/{id}', name: 'supprimer_vehicule')]
            #[Route('/admin/supprimer', name: 'supprimer_vehicule')]
            public function supprimer(Vehicule $vehicule, EntityManagerInterface $manager)
            {
                $manager->remove($vehicule);
                $manager->flush();
                return $this->redirectToRoute('ajout_vehicule');

            }
            // affichage des modeles de voitures pour tout les utilisateurs
            #[Route('/vehicule/showvehicule', name:'show_vehicule')]
            public function affichagevehicule(VehiculeRepository $vehicule) : Response
            {
                $vehicule = $vehicule->findAll();
                return $this->render('vehicule/showvehicule.html.twig' , [
                    'vehicule' => $vehicule,
                ]);
            }
        }
