<?php

namespace App\Controller;

use App\Entity\CV;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CvController extends AbstractController
{

    /**
     * @Route("/fajouterCv", name="fajouterCv")
     */
    public function fajouterCv(Request $request): Response
    {
        if(isset($_POST['nom']) and isset($_POST['prenom']) )
        {
            $cv=new CV();
            $cv->setNom($_POST['nom']);
            $cv->setPrenom($_POST['prenom']);
            $fileName=$this->getParameter('upload_directory'). "/". basename($_FILES['cvdoc']['name']);
            if (move_uploaded_file($_FILES['cvdoc']['tmp_name'], $fileName)) {
                echo "Fichier Uploadee.\n";
                $cv->setCvDoc($_FILES['cvdoc']['name']);
            } else {
                echo "Erreur :Fichier n'est uploadee !\n";
            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($cv);
            $em->flush();

        }

        return $this->render('front/ajouterCv.html.twig');


    }



    /**
     * @Route("/ajouterCv", name="ajouterCv")
     */
    public function ajouterCv(Request $request): Response
    {

        if(isset($_POST['nom']) and isset($_POST['prenom']) )
        {
            $cv=new CV();
            $cv->setNom($_POST['nom']);
            $cv->setPrenom($_POST['prenom']);
            $fileName=$this->getParameter('upload_directory'). "/". basename($_FILES['cvdoc']['name']);
            if (move_uploaded_file($_FILES['cvdoc']['tmp_name'], $fileName)) {
                echo "Fichier Uploadee.\n";
                $cv->setCvDoc($_FILES['cvdoc']['name']);
            } else {
                echo "Erreur :Fichier n'est uploadee !\n";
            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($cv);
            $em->flush();
            return $this->redirectToRoute('listCv');
        }
        return $this->render('cv/ajouterCv.html.twig');


    }


    /**
     * @Route("/listCv", name="listCv")
     */
    public function listCv()
    {   $listCv=$this->getDoctrine()
        ->getRepository(Cv::class)
        ->findAll();

        return $this->render('cv/listCv.html.twig', array('listCv'=>$listCv)

        );
    }
    /**
     * @Route("/openfile/{name}", name="openfile")
     */
    public function openfile($name)
    {

        return new BinaryFileResponse($this->getParameter('upload_directory')."/".$name);



    }

    /**
     * @Route("/deleteCv/{id}", name="deleteCv")
     */
    public function deleteCv($id)
    {
        $em=$this->getDoctrine()->getManager();
        $cv=$em->getRepository(Cv::class)->find($id);
        $em->remove($cv);
        $em->flush();
        $filename=$this->getParameter('upload_directory')."/".$cv->getCvDoc();
        unlink($filename);
        return $this->redirectToRoute('listCv');




    }

    /**
     * @Route("/updateCV/{id}", name="updateCv")
     */
    public function updateCv(Request $request,$id)
    {   $cv=new CV();
        $em = $this->getDoctrine()->getManager();
        $cv = $em->getRepository(CV::class)->find($id);
        if(isset($_POST['nom']) and isset($_POST['prenom']) )
        {

            $cv->setNom($_POST['nom']);
            $cv->setPrenom($_POST['prenom']);
            if($_FILES['cvdoc']['name']!=null)
            {

                unlink($this->getParameter('upload_directory'). "/".$cv->getCvdoc());
                $fileName=$this->getParameter('upload_directory'). "/". basename($_FILES['cvdoc']['name']);
                if (move_uploaded_file($_FILES['cvdoc']['tmp_name'], $fileName)) {
                    echo "Fichier Uploadee.\n";
                    $cv->setCvDoc($_FILES['cvdoc']['name']);
                } else {
                    echo "Erreur :Fichier n'est uploadee !\n";
                }
            }

            $em->flush();
            return $this->redirectToRoute('listCv');

        }
        return $this->render("cv/updateCv.html.twig", [
            "cv" => $cv,
        ]);

    }


}
