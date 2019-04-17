<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;




class LouvreTicketType extends AbstractType
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
              ->add('nationality',   CountryType::class, [
                'label' => "Votre Nationalité"
            ])
              ->add('birth',   BirthdayType::class,[
                'label' => "Votre date de naissance",
                'format' => 'dd-MM-yyyy',
                'years' => range(date('Y')-100, date('Y')-1),
            ])
            ->add('reduction', CheckboxType::class, array('required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
