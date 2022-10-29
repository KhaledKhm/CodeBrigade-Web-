<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\FormateurformType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;





use Doctrine\Persistence\ObjectManager;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class InscriptionFormateurController extends AbstractController
{
    /**
     * @Route("/inscription/formateur/inscription_formateur_add", name="inscription_formateur_add")
     */
    public function addFormateur(Request $request, UserPasswordEncoderInterface $encoder) //Inscription d'un formateur
    {
        $utilisateur = new utilisateur();
        $form=$this->createForm(FormateurformType::class,$utilisateur);
        $form->add('Inscrire',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() /*&& $form->isValid()*/) {
            $hash = $encoder->encodePassword($utilisateur,$utilisateur->getPassword());
            $utilisateur->setPassword($hash);

            $utilisateur = $form->getData();
            $utilisateur->setRole('Formateur');
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();
            return $this->redirectToRoute('inscription/utilisateurs');


        }
                return $this->render('inscription_formateur/addFormateur.html.twig',[
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/inscription/formateur/inscription_formateur", name="/inscription/formateur/inscription_formateur2")
     */
    public function readFormateur()
    {
        $repository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateur = $repository->findAll();

        return $this->render('inscription_formateur/listFormateur.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }






    /* public function adduser(Request $request)
     {
         $utilisateur= new $utilisateur();
         $form=$this->createForm(AddsocieteType::class,$utilisateur);
         $form->add('Add',SubmitType::class);
         $form->handleRequest($request);
         if($form->isSubmitted() && $form->isValid())
         {



             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($user);
             $entityManager->flush();
             return $this->redirectToRoute("manager");
         }

         return $this->render('user/add1.html.twig', [
             'form' => $form->createView(),
         ]);
     }*/


}
