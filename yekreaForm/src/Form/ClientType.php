<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void

    {
        // Si on arrive sur le forme sans passer par le form User, 
        //alors la variable GET 'User 'n'existe pas, 
        //donc on affiche le champ de 'User' 

        if(!isset($_GET['id'])){
            $builder
                ->add('user',EntityType::class,[
                    'class' => user::class,
                    'choice_label' => 'email'
                ]);
        }
        $builder
            ->add('societe',TextType::class,[
                'required' => false
            ])
            ->add('telephone',TelType::class,[
                'required' => false
            ])
            ->add('Reseaux',TextareaType::class,[
                'required' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
