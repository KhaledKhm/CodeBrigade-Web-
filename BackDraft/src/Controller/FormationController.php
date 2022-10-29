<?php

namespace App\Controller;

use App\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    /**
     * @Route("/fajouterFormation", name="fajouterFormation")
     */
    public function fajouterFormation(Request $request): Response
    {

        if(isset($_POST['libelle']) and isset($_POST['description']) and isset($_POST['nbrParticipant']) and isset($_POST['datedebut']) and isset($_POST['datefin']) )
        {
            $formation=new Formation();
            $formation->setLibelle($_POST['libelle']);
            $formation->setDescription($_POST['description']);
            $formation->setNbrPatricipant($_POST['nbrParticipant']);

            echo ($_POST['datedebut']);
            $datedebut  = new \DateTime($_POST['datedebut']);
            $formation->setDateDebutFor( $datedebut);

            echo ($_POST['datefin']);
            $datefin = new \DateTime($_POST['datefin']);
            $formation->setDateFinFor( $datefin);

            $em=$this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();

        }
        return $this->render('front/ajouterFormation.html.twig');


    }


    /**
     * @Route("/ajouterFormation", name="ajouterFormation")
     */
    public function ajouterFormation(Request $request): Response
    {

        if(isset($_POST['libelle']) and isset($_POST['description']) and isset($_POST['nbrParticipant']) and isset($_POST['datedebut']) and isset($_POST['datefin']) )
        {
            $formation=new Formation();
            $formation->setLibelle($_POST['libelle']);
            $formation->setDescription($_POST['description']);
            $formation->setNbrPatricipant($_POST['nbrParticipant']);

            echo ($_POST['datedebut']);
            $datedebut  = new \DateTime($_POST['datedebut']);
            $formation->setDateDebutFor( $datedebut);

            echo ($_POST['datefin']);
            $datefin = new \DateTime($_POST['datefin']);
            $formation->setDateFinFor( $datefin);

            $em=$this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute('listFormation');
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
     * @Route("/deleteFormation/{id}", name="deleteFormation")
     */
    public function deleteFormation($id)
    {
        $em=$this->getDoctrine()->getManager();
        $formation=$em->getRepository(Formation::class)->find($id);
        $em->remove($formation);
        $em->flush();

        return $this->redirectToRoute('listFormation');




    }
    /**
     * @Route("/updateFormation/{id}", name="updateFormation")
     */
    public function updateFormation(Request $request,$id)
    {   $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository(Formation::class)->find($id);


        if(isset($_POST['libelle']) and isset($_POST['description']) and isset($_POST['nbrParticipant']) and isset($_POST['datedebut']) and isset($_POST['datefin']) )
        {
            $formation->setLibelle($_POST['libelle']);
            $formation->setDescription($_POST['description']);
            $formation->setNbrPatricipant($_POST['nbrParticipant']);
            if($_POST['datedebut'] != null){
            $datedebut  = new \DateTime($_POST['datedebut']);
            $formation->setDateDebutFor( $datedebut);
            }
            if($_POST['datefin'] != null){
            $datefin = new \DateTime($_POST['datefin']);
            $formation->setDateFinFor( $datefin);
            }
            $em->flush();
            return $this->redirectToRoute('listFormation');
        }
        return $this->render("formation/updateFormation.html.twig", [
            "formation" => $formation,
        ]);


    }
    /**
     * @Route("/statFormation", name="statFormation")
     */
    public function statFormation()
    {
        return $this->render("formation/stat.html.twig");


    }
}
