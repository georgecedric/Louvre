<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class DateChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = [
            'texte 1' => 'valeur1',
            'texte 2' => 'valeur2'
        ];
        
        $builder
        ->add('dateVisit',  DateType::class, [
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'html5' => false,
            'attr' => ['class' => 'js-datepicker'],
        ])
        
           
                     
        ->add('ticketType', ChoiceType::class, [
            'label' => "choissisez votre billet",
                'choices'  => [
                'Journée' => 'journée',
                'Demi-journée' => 'demi-journee',
                
                        ],
                    ])
        ->add('save',      SubmitType::class,[
                        'label' => "Je commande"
                    ]
                    );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
