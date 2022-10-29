<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\EnterpriseformType;
use App\Form\FormateurformType;
use App\Repository\UtilisateurRepository;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InscriptionEntrepriseController extends AbstractController
{
    /**
     * @Route("/inscription/entreprise", name="inscription_entreprise")
     */
    public function index(): Response
    {
        return $this->render('inscription_entreprise/login.html.twig', [
            'controller_name' => 'InscriptionEntrepriseController',
        ]);
    }

    /**
     * @Route("/inscription/entreprise/inscription_entreprise_add", name="inscription_entreprise_add")
     */
    public function addEntreprise(Request $request,UserPasswordEncoderInterface $encoder, GoogleAuthenticatorInterface $authenticator)
    {
        $utilisateur = new utilisateur();
        $form=$this->createForm(EnterpriseformType::class,$utilisateur);
        $form->add('Inscrire', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() /*&& $form->isValid()*/) {
            $hash = $encoder->encodePassword($utilisateur,$utilisateur->getPassword());
            $utilisateur->setPassword($hash);
            $utilisateur->setRole('ROLE_Entreprise');

            $secret = $authenticator->generateSecret();
            $utilisateur->setGoogleAuthenticatorSecret($secret);

            $utilisateur = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();
            return $this->redirectToRoute('login');


        }
        return $this->render('inscription_entreprise/addEntreprise.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modifierEntreprise/{id}", name="modifierEntreprise")
     */
    public function updateEntreprise(Request $request,$id,UserPasswordEncoderInterface $encoder)
    {

        $em = $this->getDoctrine()->getManager();
        $Utilisateur = $em->getRepository(Utilisateur::class)->find($id);
        $formedit=$this->createForm(EnterpriseformType::class,$Utilisateur);
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
        return $this->render('inscription_Entreprise/updateEntreprise.html.twig',
            [
                'formedit'=>$formedit->createView(),
            ]
        );

    }
}
