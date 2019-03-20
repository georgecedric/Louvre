<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\TicketType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;



class LouvreCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name',  TextType::class, [
            'attr' => [
                 'placeholder' => "entrez votre nom ici"],
                 'label' => "Votre Nom"    
                 ])
        ->add('surname',     TextType::class, [
          'attr' => [
               'placeholder' => "entrez votre prénom ici"],
               'label' => "Votre Prénom"
               ]
        )
            
            ->add('email', EmailType::class, [
                'attr' => [
                     'placeholder' => "entrez votre email ici"],
                     'label' => "Email"    
                     ])
           
                     ->add('tickets', CollectionType::class, array(
                        'entry_type'   => LouvreTicketType::class,
                        'allow_add'    => true,
                        'allow_delete' => true,
                        'by_reference' => false,
                        'label' => "Entrez les informations visiteurs ici" 
                      ))      


            ->add('save',      SubmitType::class,[
                'label' => "verifier votre panier"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
