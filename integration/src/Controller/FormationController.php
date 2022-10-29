<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Utilisateur;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class FormationController extends AbstractController
{
    /**
     * @Route("/fajouterFormation", name="fajouterFormation")
     */
    public function fajouterFormation(\Swift_Mailer $mailer,UserInterface $user1)
    {

        if(isset($_POST['libelle']) and isset($_POST['description']) and isset($_POST['nbrParticipant']) and isset($_POST['datedebut']) and isset($_POST['datefin']) )
        {   $userid=$user1->getId();
            $em=$this->getDoctrine()->getManager();
            $user=$em->getRepository(Utilisateur::class)->find($userid);
            $formation=new Formation();
            $formation->setLibelle($_POST['libelle']);
            $formation->setDescription($_POST['description']);
            $formation->setNbrPatricipant($_POST['nbrParticipant']);
            $formation->setIdutli($user->getId());


            $datedebut  = new \DateTime($_POST['datedebut']);
            $formation->setDateDebutFor( $datedebut);


            $datefin = new \DateTime($_POST['datefin']);
            $formation->setDateFinFor( $datefin);

            $em=$this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            $message = (new \Swift_Message('Formation Ajoutee'))
                ->setFrom('noreplyjobbookmail@gmail.com')
                ->setTo($user->getEmail())
                ->setBody('Bonjour '.$user->getNomPersonne().' , Merci pour choisir JobBook ,Votre Formation a ete ajoutee'
                );

            $mailer->send($message);
            return $this->redirectToRoute('notifajouterformation');

        }
        return $this->render('front/ajouterFormation.html.twig');


    }
    /**
     * @Route("/fafficheformation", name="fafficheformation")
     */
    public function fafficheformation(UserInterface $user1)
    {$userid=$user1->getId();
        $listFormation=$this->getDoctrine()
            ->getRepository(Formation::class)
            ->findAll();


        return $this->render('front/afficheFormation.html.twig',['listFormation'=>$listFormation,'userid'=>$userid]);





    }
    /**
     * @Route("/notifajouterformation", name="notifajouterformation")
     */
    public function notifajouterformation(FlashyNotifier $flashy)
    {

        $flashy->primarydark('Votre Formation a ete ajoutee avec succès. Un mail a ete envoyé', 'http://gmail.com');
        return $this->redirectToRoute('flistFormation');


    }
    /**
     * @Route("/notiajouterformation", name="notiajouterformation")
     */
    public function notiajouterformation(FlashyNotifier $flashy)
    {

        $flashy->primarydark('Votre Formation a ete ajoutee avec succès. Un mail a ete envoyé', 'http://gmail.com');
        return $this->redirectToRoute('listFormation');


    }
    /**
     * @Route("/ajouterFormation", name="ajouterFormation")
     */
    public function ajouterFormation( \Swift_Mailer $mailer,UserInterface $user1)
    {
        if(isset($_POST['libelle']) and isset($_POST['description']) and isset($_POST['nbrParticipant']) and isset($_POST['datedebut']) and isset($_POST['datefin']) )
        {   $userid=$user1->getId();
            $em=$this->getDoctrine()->getManager();
            $user=$em->getRepository(Utilisateur::class)->find($userid);
            $formation=new Formation();
            $formation->setLibelle($_POST['libelle']);
            $formation->setDescription($_POST['description']);
            $formation->setNbrPatricipant($_POST['nbrParticipant']);
            $formation->setIdutli($user->getId());


            $datedebut  = new \DateTime($_POST['datedebut']);
            $formation->setDateDebutFor( $datedebut);


            $datefin = new \DateTime($_POST['datefin']);
            $formation->setDateFinFor( $datefin);

            $em=$this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            $message = (new \Swift_Message('Formation Ajoutee'))
                ->setFrom('noreplyjobbookmail@gmail.com')
                ->setTo($user->getEmail())
                ->setBody('Bonjour '.$user->getNomPersonne().' , Merci pour choisir JobBook ,Votre Formation a ete ajoutee'
                );

            $mailer->send($message);
            return $this->redirectToRoute('notiajouterformation');
        }
        return $this->render('formation/ajouterFormation.html.twig');


    }


    /**
     * @Route("/listFormation", name="listFormation")
     */
    public function listFormation()
    {   $listFormation=$this->getDoctrine()
        ->getRepository(Formation::class)
        ->findAll();

        return $this->render('formation/listFormation.html.twig', array('listFormation'=>$listFormation)

        );
    }


    /**
     * @Route("/flistFormation", name="flistFormation")
     */
    public function flistFormation()
    {   $listFormation=$this->getDoctrine()
        ->getRepository(Formation::class)
        ->findAll();

        return $this->render('front/listFormation.html.twig', array('listFormation'=>$listFormation)

        );
    }



    /**
     * @Route("/deleteFormation/{id}", name="deleteFormation")
     */
    public function deleteFormation($id,FlashyNotifier $flashy, \Swift_Mailer $mailer,UserInterface $user1)
    {   $em=$this->getDoctrine()->getManager();
        $formation=$em->getRepository(Formation::class)->find($id);
        $em->remove($formation);
        $em->flush();
        $flashy->primarydark('Votre Formation a ete Supprimee avec succès. Un mail a ete envoyé', 'http://gmail.com');
        $message = (new \Swift_Message('Formation Supprimee'))
            ->setFrom('noreplyjobbookmail@gmail.com')
            ->setTo('wissem.lahbib@esprit.tn')
            ->setBody('Bonjour Wissem ,Merci pour choisir JobBook ,Votre Formation a ete Supprimee'
            );

        $mailer->send($message);
        return $this->redirectToRoute('listFormation');




    }

    /**
     * @Route("/fdeleteFormation/{id}", name="fdeleteFormation")
     */
    public function fdeleteFormation($id,FlashyNotifier $flashy, \Swift_Mailer $mailer)
    {
        $em=$this->getDoctrine()->getManager();
        $formation=$em->getRepository(Formation::class)->find($id);
        $em->remove($formation);
        $em->flush();
        $flashy->primarydark('Votre Formation a ete Supprimee avec succès. Un mail a ete envoyé', 'http://gmail.com');
        $message = (new \Swift_Message('Formation Supprimee'))
            ->setFrom('noreplyjobbookmail@gmail.com')
            ->setTo('wissem.lahbib@esprit.tn')
            ->setBody('Bonjour Wissem ,Merci pour choisir JobBook ,Votre Formation a ete Supprimee'
            );

        $mailer->send($message);
        return $this->redirectToRoute('flistFormation');




    }

    /**
     * @Route("/notiupdateformation", name="notiupdateformation")
     */
    public function notiupdateformation(FlashyNotifier $flashy)
    {

        $flashy->primarydark('Votre Formation a ete modifiee avec succès. Un mail a ete envoyé', 'http://gmail.com');

        return $this->redirectToRoute('listFormation');


    }
    /**
     * @Route("/updateFormation/{id}", name="updateFormation")
     */
    public function updateFormation($id, \Swift_Mailer $mailer,UserInterface $user1)
    {   $userid=$user1->getId();
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(Utilisateur::class)->find($userid);
        $formation = $em->getRepository(Formation::class)->find($id);


        if(isset($_POST['libelle']) and isset($_POST['description']) and isset($_POST['nbrParticipant']) and isset($_POST['datedebut']) and isset($_POST['datefin']) )
        {
            $formation->setLibelle($_POST['libelle']);
            $formation->setDescription($_POST['description']);
            $formation->setNbrPatricipant($_POST['nbrParticipant']);
            $formation->setIdutli($user->getId());;
            if($_POST['datedebut'] != null){
            $datedebut  = new \DateTime($_POST['datedebut']);
            $formation->setDateDebutFor( $datedebut);
            }
            if($_POST['datefin'] != null){
            $datefin = new \DateTime($_POST['datefin']);
            $formation->setDateFinFor( $datefin);
            }
            $em->flush();
            $message = (new \Swift_Message('Formation Modifiee'))
                ->setFrom('noreplyjobbookmail@gmail.com')
                ->setTo($user->getEmail())
                ->setBody('Bonjour '.$user->getNomPersonne().' ,Merci pour choisir JobBook ,Votre Formation a ete modifiee'
                );

            $mailer->send($message);
            return $this->redirectToRoute('notiupdateformation');
        }
        return $this->render("formation/updateFormation.html.twig", [
            "formation" => $formation,
        ]);


    }

    /**
     * @Route("/notifupdateformation", name="notifupdateformation")
     */
    public function notifupdateformation(FlashyNotifier $flashy)
    {

        $flashy->primarydark('Votre Formation a ete modifiee avec succès. Un mail a ete envoyé', 'http://gmail.com');

        return $this->redirectToRoute('fafficheformation');


    }
    /**
     * @Route("/fupdateFormation/{id}", name="fupdateFormation")
     */
    public function fupdateFormation($id, \Swift_Mailer $mailer,UserInterface $user1)
    {  $userid=$user1->getId();
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(Utilisateur::class)->find($userid);
        $formation = $em->getRepository(Formation::class)->find($id);


        if(isset($_POST['libelle']) and isset($_POST['description']) and isset($_POST['nbrParticipant']) and isset($_POST['datedebut']) and isset($_POST['datefin']) )
        {
            $formation->setLibelle($_POST['libelle']);
            $formation->setDescription($_POST['description']);
            $formation->setNbrPatricipant($_POST['nbrParticipant']);
            $formation->setIdutli($user->getId());;
            if($_POST['datedebut'] != null){
                $datedebut  = new \DateTime($_POST['datedebut']);
                $formation->setDateDebutFor( $datedebut);
            }
            if($_POST['datefin'] != null){
                $datefin = new \DateTime($_POST['datefin']);
                $formation->setDateFinFor( $datefin);
            }
            $em->flush();
            $message = (new \Swift_Message('Formation Modifiee'))
                ->setFrom('noreplyjobbookmail@gmail.com')
                ->setTo($user->getEmail())
                ->setBody('Bonjour '.$user->getNomPersonne().' ,Merci pour choisir JobBook ,Votre Formation a ete modifiee'
                );

            $mailer->send($message);
            return $this->redirectToRoute('notifupdateformation');
        }
        return $this->render("front/updateFormation.html.twig", [
            "formation" => $formation,
        ]);


    }
    /**
     * @Route("/statFormation", name="statFormation")
     */
    public function statFormation()
    {$listFormation=$this->getDoctrine()
        ->getRepository(Formation::class)
        ->findAll();

        return $this->render('formation/stat.html.twig', array('listFormation'=>$listFormation)

        );

    }

}
