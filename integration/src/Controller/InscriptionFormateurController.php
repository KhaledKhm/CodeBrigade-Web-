<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\FormateurformType;
use App\Repository\UtilisateurRepository;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
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
     * @Route("/inscription_formateur_add", name="inscription_formateur_add")
     */
    public function addFormateur(Request $request, UserPasswordEncoderInterface $encoder, GoogleAuthenticatorInterface $authenticator) //Inscription d'un formateur
    {
        $utilisateur = new utilisateur();
        $form=$this->createForm(FormateurformType::class,$utilisateur);
        $form->add('Inscrire',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() /*&& $form->isValid()*/) {

            $hash = $encoder->encodePassword($utilisateur,$utilisateur->getPassword());
            $utilisateur->setPassword($hash);

            $utilisateur = $form->getData();
            $utilisateur->setRole('ROLE_Formateur');

            $secret = $authenticator->generateSecret();
            $utilisateur->setGoogleAuthenticatorSecret($secret);

            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();
            return $this->redirectToRoute('login');


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


    /**
     * @Route("/formateur/modifierFormateur/{id}", name="modifierFormateur")
     */
    public function updateFormateur(Request $request,$id,UserPasswordEncoderInterface $encoder)
    {

        $em = $this->getDoctrine()->getManager();
        $Utilisateur = $em->getRepository(Utilisateur::class)->find($id);
        $formedit = $this->createForm(FormateurformType::class,$Utilisateur);
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
        return $this->render('inscription_Formateur/updateFormateur.html.twig',
            [
                'formedit'=>$formedit->createView(),
            ]
        );

    }



}
