<?php

namespace App\Controller;


use App\Entity\Ticket;
use App\Entity\Commande;
use App\Entity\Category;
use App\Form\LouvreTicketType;
use App\Form\LouvreCommandeType;
use App\Form\DateChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use  Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
    public function home(Request $request, SessionInterface $session)
    {
        
        $commande = new Commande();
        
    
        $formCommande = $this->get('form.factory')->create(DateChoiceType::class, $commande);
        
    // Si la requête est en POST
    if ($request->isMethod('POST')) {
    // On fait le lien Requête <-> Formulaire
    // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
    $formCommande->handleRequest($request);

        // On vérifie que les valeurs entrées sont correctes
        
        if ($formCommande->isValid()) {
            $session->set('newCommande', $commande);
            return $this->redirectToRoute('firststage');
        }
    } 

        return $this->render('ticket/home.html.twig', array(
          'form' => $formCommande->createView(),
          
        ));
    }

    /**
     * @Route("/ticket/firststage", name="firststage")
     */
    public function firststage (Request $request, SessionInterface $session)
    {
        $newCommande = $session->get('newCommande');
        $ticketType =$newCommande->getTicketType();
        $dateVisit =$newCommande->getDateVisit();
     
        $commande = new Commande();
        $commande->setTicketType($ticketType);
        $commande->setDateVisit($dateVisit);
        
        

        

    
  
    $formCommande = $this->get('form.factory')->create(LouvreCommandeType::class, $commande);
    // Si la requête est en POST
        
    if ($request->isMethod('POST')) {
        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
        $formCommande->handleRequest($request);
    
            // On vérifie que les valeurs entrées sont correctes
           
            if ($formCommande->isValid()) {
                // On enregistre notre objet $commande dans la base de données, par exemple
        
                $session->set('newCommande', $commande);
                
                
        $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
                return $this->redirectToRoute('secondstage');
            }
      }
    return $this->render('ticket/firststage.html.twig', array(
      'form' => $formCommande->createView(),
      'ticketType'=> $ticketType,
      'dateVisit' => $dateVisit,
    ));
    }

     /**
     * @Route("/ticket/secondstage", name="secondstage")
     */
    public function secondstage (Request $request, SessionInterface $session)
    {
        $commande = $session->get('newCommande');
        
        $tickets = $commande->getTickets();
        $datetime1 = $commande->getDateVisit();
        $ticketType = $commande->getTicketType();
        
        $cmpt = 0 ;
        $pricecommande = 0; 

            foreach($tickets as $ticket){
                $reduc= $ticket ->getReduction();
                $ticket->setPrice(12);
                // calcul de l'age
                $datetime2 = $ticket ->getBirth();
                $age = $datetime1->diff($datetime2, true)->y;   
                $ticket->setAge($age); 
                
                // calcul du prix
                
                if ($reduc == true ) {  
                    $price = 10;

                }else {
                    if($age < 4){
                        $price = 0;
                    } elseif($age >= 4 and $age < 12){
                        $price = 8;
                    }elseif($age >= 12 and $age < 60){
                        $price = 16;
                    }elseif($age >= 60 ){
                        $price = 12;
                    }
                }
                // calcul du prix si choix de demi-journée
                if ($ticketType == 'demi-jour'){
                    $price = $price/2;
                }

                $ticket->setPrice($price);
        // calcul du nombre de ticket       
         $cmpt++;
        $pricecommande = $pricecommande + $price;
    }
        $commande->setNumberTicket($cmpt);
        $commande -> setPrice($pricecommande);
        
        return $this->render('ticket/secondstage.html.twig', array(
            
            'commande' => $commande,
            'tickets'=> $tickets,
        ));
    }
}
