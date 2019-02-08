<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\Commande;
use App\Form\LouvreTicketType;
use App\Form\LouvreCommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;



class TicketController extends AbstractController
{
    /**
     * @Route("/ticket", name="ticket")
     */
    public function index()
    {
        return $this->render('ticket/index.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('ticket/home.html.twig' ); 
    }

    /**
     * @Route("/ticket/firststage", name="firststage")
     */
    public function firststage()
    {
        // On crée un objet Ticket
    $ticket = new Ticket();
    $commande = new Commande();
    $formCommande = $this->get('form.factory')->create(LouvreCommandeType::class, $commande);
    
    

    // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard

    // À partir du formBuilder, on génère le formulaire
    

    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('ticket/firststage.html.twig', array(
      'form' => $formCommande->createView(),
      
    ));
    }
}
