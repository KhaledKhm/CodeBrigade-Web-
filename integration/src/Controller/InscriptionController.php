<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\FormateurformType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class InscriptionController extends AbstractController
{
    /**
     * @Route("/formateur/inscription/utilisateurs", name="inscription/utilisateurs")
     */
    /*public function index(): Response
    {
        return $this->render('inscription/listUtilisateur.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }*/

    public function readUtilisateur()
    {
        $repository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateur = $repository->findAll();

        return $this->render('inscription/listUtilisateur.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }
    /**
     * @Route("/inscription/choix", name="choix_user")
     */
    public function choix(){
        return $this->render('inscription/choixuser.html.twig');
    }

    /**
     * @Route("/modifierUtilisateur/{id}", name="modifierUtilisateur")
     */
    public function updateUtilisateur(Request $request,$id,UserPasswordEncoderInterface $encoder)
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
        return $this->render('inscription_formateur/updateFormateur.html.twig',
            [
                'formedit'=>$formedit->createView(),
            ]
        );

    }
    /**
     * @Route("/supprimerUtilisateur/{id}",name="supprimerUtilisateur")
     */
    public function deleteUtilisateur($id)
    {
        $em = $this->getDoctrine()->getManager();
        $class = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
        $em->remove($class);
        $em->flush();
        return $this->redirectToRoute('inscription/utilisateurs');
    }

    /**
     * @Route("/banUtilisateur/{id}",name="banUtilisateur")
     */
    public function banUtilisateur($id){


        $em = $this->getDoctrine()->getManager();
        $Utilisateur = $em->getRepository(Utilisateur::class)->find($id);
        $Utilisateur->setAccountStatus("Banned");
      //  $Utilisateur->setIsBlocked(1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($Utilisateur);
        $em->flush();
        return $this->redirectToRoute('inscription/utilisateurs');
    }

    /**
     * @Route("/unbanUtilisateur/{id}",name="unbanUtilisateur")
     */
    public function unbanUtilisateur($id){
        $em = $this->getDoctrine()->getManager();
        $Utilisateur = $em->getRepository(Utilisateur::class)->find($id);
        $Utilisateur->setAccountStatus(NULL);
        //$Utilisateur->setIsBlocked(false);
        $em = $this->getDoctrine()->getManager();
        $em->persist($Utilisateur);
        $em->flush();
        return $this->redirectToRoute('inscription/utilisateurs');
    }

}


