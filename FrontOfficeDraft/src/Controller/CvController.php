<?php

namespace App\Controller;

use App\Entity\CV;
use App\Form\CvType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CvController extends AbstractController
{
    /**
     * @Route("/ajouterCv", name="ajouterCv")
     */
    public function ajouterCv(Request $request): Response
    {   $cv=new CV();
        $form=$this->CreateForm(CvType::class,$cv);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $file=$cv->getCvDoc();
            $fileName=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$fileName);
            $cv->setCvDoc($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($cv);
            $em->flush();
            return $this->redirectToRoute('listCv');

        }

        return $this->render('cv/ajouterCv.html.twig', array('form'=>$form->createView(),)

        );
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
    {

        $em = $this->getDoctrine()->getManager();
        $cv = $em->getRepository(CV::class)->find($id);

        $nametmp = $this->getParameter('upload_directory') . "/" . $cv->getCvDoc();
        $nomtmp=$cv->getNom();
        $prenomtmp=$cv->getPrenom();


        $form1 = $this->createFormBuilder()
            ->add('Nom',null,['data' => $nomtmp])
            ->add('prenom',null,['data' => $prenomtmp])
            ->add('CvDoc', FileType::class)
            ->add('Modifier', SubmitType::class)
            ->getForm();


        $form1->handleRequest($request);
        if ($form1->isSubmitted() && $form1->isValid()) {
            if ($form1->get('CvDoc')->getData() == null) {
                if($form1->get('Nom')->getData()==null)
                    $cv->setNom($nomtmp);
                else
                $cv->setNom($form1->get('Nom')->getData());
                if($form1->get('prenom')->getData()==null)
                $cv->setPrenom($prenomtmp);
                else
                    $cv->setPrenom($form1->get('prenom')->getData());
                $em->flush();
                return $this->redirectToRoute('listCv');
            } else {

                unlink($nametmp);
                $file = new File($form1->get('CvDoc')->getData());
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                if($form1->get('Nom')->getData()==null)
                    $cv->setNom($nomtmp);
                else
                    $cv->setNom($form1->get('Nom')->getData());
                if($form1->get('prenom')->getData()==null)
                    $cv->setPrenom($prenomtmp);
                else
                    $cv->setPrenom($form1->get('prenom')->getData());
                $cv->setCvDoc($fileName);
                $em->flush();
                return $this->redirectToRoute('listCv');
            }


        }

        return $this->render("cv/updateCv.html.twig", [
            "form_title" => "Modifier un CV",
            "form" => $form1->createView(),
        ]);
    }
}
