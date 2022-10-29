<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthentificationController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login()
    {

        return $this->render('authentification/login.html.twig');
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){

    }


    /**
     * @Route("/2fa", name="2fa_login")
     */

    public function check2fa(GoogleAuthenticatorInterface $authenticator, TokenStorageInterface $storage){
        $code = $authenticator->getQRContent($storage->getToken()->getUser());
        $qrCode ="http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl=".$code;
        return $this->render('authentification/2fa.html.twig', [
            'qrCode' => $qrCode]);
    }

    /**
     * @Route("/banned", name="banned")
     */
    public function banned(){


        return $this->render('authentification/banned.html.twig');
    }


   /**
     * @Route("/", name="main")
     */
    public function index()
    {
        if ($this->isGranted('ROLE_Formateur')){
           /* $em = $this->getDoctrine()->getManager();
            $Utilisateur = $em->getRepository(Utilisateur::class)->find("app.user.id");
            if ($Utilisateur->getAccountStatus() == Banned){
                return $this->redirectToRoute("banned");
            }else*/


            return  $this->redirectToRoute("formateur/index");
        }else if ($this->isGranted('ROLE_Entreprise')){
            return  $this->redirectToRoute("evaluation");
        }else if ($this->isGranted('ROLE_Candidat')){
            return  $this->redirectToRoute("candidat/index");
        }else if ($this->isGranted('ROLE_Admin')){
            return  $this->redirectToRoute("admin/index");
        }


    }



}
