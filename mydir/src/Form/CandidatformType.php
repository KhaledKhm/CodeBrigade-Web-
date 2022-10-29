<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatformType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password')
            ->add('confirmPassword')
            ->add('role')
            ->add('accountStatus')
            ->add('cinPersonne')
            ->add('immatriculeEntreprise')
            ->add('nomPersonne')
            ->add('prenomPersonne')
            ->add('libelleEntreprise')
            ->add('sexePersonne')
            ->add('dateNaisPersonne')
            ->add('etatSocialePersonne')
            ->add('telephone')
            ->add('adresse')
            ->add('email')
            ->add('siteweb')
            ->add('domainePersonne')
            ->add('secteurEntreprise')
            ->add('confirm_password')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
