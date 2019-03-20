<?php

namespace App\Controller;


use App\Entity\Ticket;
use App\Entity\Commande;
use App\Entity\Category;
use App\Form\LouvreTicketType;
use App\Form\LouvreCommandeType;
use App\Form\LouvreValidationType;
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
     * @Route("/noticket", name="noticket")
     */
    public function noticket()
    {
        return $this->render('ticket/noticket.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }



    /**
     * @Route("/", name="home")
     */
    public function home(Request $request, SessionInterface $session)
    {
        
        $commande = new Commande();
        
        
        function random($car) {
            $string = "";
            $chaine = "abcdefghijklmnpqrstuvwxy0123456789";
            srand((double)microtime()*1000000);
            for($i=0; $i<$car; $i++) {
            $string .= $chaine [rand()%strlen($chaine  )];
            }
            return $string;
            }
            // APPEL
            // Génère une chaine de longueur 20
            $chaine = random(12);
            $commande -> setNumberCommande( $chaine );
    
        $formCommande = $this->get('form.factory')->create(DateChoiceType::class, $commande);
        
    // Si la requête est en POST
    if ($request->isMethod('POST')) {
    // On fait le lien Requête <-> Formulaire
    // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
   
    $formCommande->handleRequest($request);

        // On vérifie que les valeurs entrées sont correctes
        
        if ($formCommande->isValid()) {
            
            $session->set('newCommande', $commande);
            $dateVisit =$commande->getDateVisit();

        // recherche du nombre de ticket deja vendu pour une date precise

            $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository(Commande::class);
                $listeCommandes = $repository->findBy(array('dateVisit' => $dateVisit));
                $nbTotalTicket=0;

                foreach($listeCommandes as $listeCommande)
                    {
                        $commandeId=$listeCommande->getId();
                        $em = $this->getDoctrine()->getManager();
                        $nbTicket = $em->getRepository(Ticket::class);
                        $nb = $nbTicket->getNb($commandeId);
                        $nbTotalTicket = $nb + $nbTotalTicket;
                    }

                $ticketRestant = 1000 - $nbTotalTicket;
                $ticketRestant = 3;
                
                    if ($ticketRestant == 0){
                        return $this->redirectToRoute('noticket');
                    }

                    elseif ($ticketRestant >= 8){
                        $ticketRestant = 8;
                        
                    }
                    
            $session->set('newTicketRestant', $ticketRestant);    
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
       
        $ticketRestant = $session->get('newTicketRestant');
        
        $commande = new Commande();
        $newCommande = $session->get('newCommande', $commande );
        $ticketType =$newCommande->getTicketType();
        $dateVisit =$newCommande->getDateVisit();
        $commande->setTicketType($ticketType);
        $commande->setDateVisit($dateVisit);


 
 
  
    $formCommande = $this->createForm(LouvreCommandeType::class, $newCommande);
    // Si la requête est en POST
        
    if ($request->isMethod('POST')) {
        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
        $formCommande->handleRequest($request);
    
            // On vérifie que les valeurs entrées sont correctes
           
            if ($formCommande->isValid()) {
                // On enregistre notre objet $commande dans la base de données, par exemple
        
                $session->set('newCommande', $newCommande);
                $session->set('newTicketRestant', $ticketRestant);

                return $this->redirectToRoute('secondstage');
            }
      }
    return $this->render('ticket/firststage.html.twig', array(
      'form' => $formCommande->createView(),
      'ticketType'=> $ticketType,
      'dateVisit' => $dateVisit,
      'ticketRestant'=> $ticketRestant,
    ));
    }

     /**
     * @Route("/ticket/secondstage", name="secondstage")
     */
    public function secondstage (Request $request, SessionInterface $session)
    {
        $commande = $session->get('newCommande');
        $ticketRestant = $session->get('newTicketRestant');
        $tickets = $commande->getTickets();
        $datetime1 = $commande->getDateVisit();
        $ticketType = $commande->getTicketType();
        
        $cmpt = 0 ;
        $pricecommande = 0; 

            foreach($tickets as $ticket){
                $reduc= $ticket ->getReduction();
                
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
                if ($ticketType == 'demi-journee'){
                    $price = $price/2;
                }

                $ticket->setPrice($price);
        // calcul du nombre de ticket       
         $cmpt++;
        $pricecommande = $pricecommande + $price;
    }
        $commande->setNumberTicket($cmpt);
        $commande -> setPrice($pricecommande);

         $formCommande = $this->get('form.factory')->create(LouvreValidationType::class, $commande);

        if ($request->isMethod('POST') && $formCommande->handleRequest($request)->isValid()) {
            $session->set('newCommande', $commande);
         

          return $this->redirectToRoute('payment');
        }


        return $this->render('ticket/secondstage.html.twig', array(
            'form' => $formCommande->createView(),
            'commande' => $commande,
            'tickets'=> $tickets,
            
        ));
    }


    /**
     * @Route("/ticket/payment", name="payment")
     */
    public function payment(Request $request, SessionInterface $session)
    {
        $commande = $session->get('newCommande');       
        return $this->render('ticket/payment.html.twig', array(
            
            'commande' => $commande,
            
        ));
    }

    

/**
     * @Route(
     *     "/checkout",
     *     name="order_checkout",
     *     methods="POST"
     * )
     */
    public function checkoutAction(Request $request, SessionInterface $session, \Swift_Mailer $mailer)
    {
        $commande = $session->get('newCommande');

        $price = $commande->getPrice();
        $email = $commande->getEmail();

        \Stripe\Stripe::setApiKey("sk_test_FbpFiCrOl0hmGJFlBNmJ8jzQ");

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $price*100, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Paiement  -" . $email
            ));
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            //envoyer email ici

            $message = (new \Swift_Message('Hello Email'))
            ->setFrom(array ('contact@lartdchoix.com'=>'billetterie le louvre'))
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    // templates/emails/registration.html.twig
                    'emails/registration.html.twig', array('commande' => $session->get('newCommande'),  'tickets' => $commande->getTickets())
                ),
                'text/html'
            );
    
        $mailer->send($message);



            return $this->redirectToRoute('validation');
            
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Snif ça marche pas :(");
            return $this->redirectToRoute('payment');
            // The card has been declined
        }
    }

    /**
     * @Route("/ticket/validation", name="validation")
     */
    public function validation()
    {
        return $this->render('ticket/validation.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }

}
