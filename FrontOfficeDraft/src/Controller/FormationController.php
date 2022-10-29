<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{

    /**
     * @Route("/ajouterFormation", name="ajouterFormation")
     */
    public function ajouterFormation(Request $request): Response
    {

        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $formation= $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute('listFormation');


        }
        return $this->render('formation/ajouterFormation.html.twig', [
            'form' => $form->createView(),
        ]);

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
    {

        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository(Formation::class)->find($id);
        $form = $this->createForm(FormationType::class,
            $formation);
        $form->add('Modifier', SubmitType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('listFormation');
        }

        return $this->render("formation/updateFormation.html.twig", [
            "form" => $form->createView(),
        ]);

    }
}
