<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\CandidatformType;
use App\Repository\UtilisateurRepository;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InscriptionCandidatController extends AbstractController
{
    /**
     * @Route("/inscription/candidat/inscription_condidat_add", name="inscription_condidat_add")
     */
    public function addCandidat(Request $request,UserPasswordEncoderInterface $encoder, GoogleAuthenticatorInterface $authenticator)
    {

        $utilisateur = new utilisateur();
        $form = $this->createForm(CandidatformType::class,$utilisateur);
        $form->add('Inscrire', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() /*&& $form->isValid()*/) {

            $hash = $encoder->encodePassword($utilisateur,$utilisateur->getPassword());
            $utilisateur->setPassword($hash);

            $utilisateur->setRole('ROLE_Candidat');

            $secret = $authenticator->generateSecret();
            $utilisateur->setGoogleAuthenticatorSecret($secret);

            $utilisateur = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();
            return $this->redirectToRoute('login');


        }
        return $this->render('inscription_candidat/addCandidat.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modifierCandidat/{id}", name="modifierCandidat")
     */
    public function updateCandidat(Request $request,$id,UserPasswordEncoderInterface $encoder)
    {

        $em = $this->getDoctrine()->getManager();
        $Utilisateur = $em->getRepository(Utilisateur::class)->find($id);
        $formedit = $this->createForm(CandidatformType::class, $Utilisateur);
        $formedit->add('Modifier', SubmitType::class);

        $formedit->handleRequest($request);
        if($formedit->isSubmitted() /*&& $formedit->isValid()*/)
        {
            $hash = $encoder->encodePassword($Utilisateur,$Utilisateur->getPassword());
            $Utilisateur->setPassword($hash);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('inscription/utilisateurs');
        }
        return $this->render('inscription_candidat/updateCandidat.html.twig',
            [
                'formedit'=>$formedit->createView(),
            ]
        );

    }


    /* /**
      * @Route("/inscription/candidat/inscription_candidat", name="/inscription/candidat/inscription_formateur2")
      */
    /*public function readCandidat()
    {
        $repository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateur = $repository->findAll();

        return $this->render('inscription_candidat/listCandidat.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }*/
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
