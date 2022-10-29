<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Avis;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ReclamationController extends AbstractController
{
    /**
     * @Route("/reclamation", name="reclamation")
     */
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
    /**
     * @param ReclamationRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/AfficheRec",name="affichereclamation")
     */
    public function Affiche(ReclamationRepository $repository)
    {
        $avis=$this->getDoctrine()->getManager()->getRepository(avis::class)->findAll();
        $reclamation=$repository->findAll();
        return $this->render('affichereclamation.html.twig',
            ['reclamation'=>$reclamation,'avis'=>$avis]);
    }

    /**
     * @Route("/Supprimerreclamation/{id}",name="deletereclamation")
     */
    function Delete($id,ReclamationRepository $repository)
    {
        $reclamation=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute('affichereclamation');
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/ajrec",name="ajouterreclamation")
     */
    function Add(Request $request)
    {
        $reclamation=new Reclamation();
        $form=$this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        echo($reclamation->getImageFile());
        echo($reclamation->getImageName());
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('affichereclamation');
        }
        return $this->render('Reclamation.html.twig',
            [
                'form'=>$form->createView(),
            ]
        );
    }


    /**
     * @param Request $request
     * @Route("/Modifierreclamation/{id}",name="modifierreclamation")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(reclamationRepository $repository,$id,Request $request)
    {
        $reclamation=$repository->find($id);
        $form=$this->createForm(reclamationType::class,$reclamation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('affichereclamation');
        }
        return $this->render('Reclamation.html.twig',
            [
                'form'=>$form->createView(),
            ]
        );
    }
}
