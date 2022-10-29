<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Reclamation;
use App\Form\AvisType;
use App\Repository\AvisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AvisController extends AbstractController
{
    /**
     * @Route("/avisss", name="aviss")
     */
    public function index(): Response
    {
        return $this->render('ajoutavis.html.twig', [
            'controller_name' => 'AvisController',
        ]);
    }
    /**
     * @param AvisRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/Affiche",name="afficheravis")
     */
    public function Affiche(AvisRepository $repository)
    {
        $reclamation=$this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
        $avis=$repository->findAll();
        return $this->render('afficheavis.html.twig',
            ['avis'=>$avis,'reclamation'=>$reclamation]);
    }

    /**
     * @Route("/SupprimerAvis/{id}",name="deleteavis")
     */
    function Delete($id,AvisRepository $repository)
    {
        $avis=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($avis);
        $em->flush();
        return $this->redirectToRoute('afficheravis');
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/Ajout",name="ajouteravis")
     */
    function Add(Request $request)
    {
        $avis=new Avis();
        $form=$this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($avis);
            $em->flush();

            return $this->redirectToRoute('ajouteravis');
        }
        return $this->render('Avis.html.twig',
            [
                'form'=>$form->createView(),
            ]
        );
    }


    /**
     * @param Request $request
     * @Route("/Modifieravis/{id}",name="modifieravis")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(avisRepository $repository,$id,Request $request)
    {
        $avis=$repository->find($id);
        $form=$this->createForm(AvisType::class,$avis);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheravis');
        }
        return $this->render('Avis.html.twig',
            [
                'form'=>$form->createView(),
            ]
        );
    }


function compteur(AvisRepository $repository)
{
    $star1 = 0;
    $star2 = 0;
    $star3 = 0;
    $star4 = 0;
    $star5 = 0;
    $avis=$repository->findAll();
    for ($a=0 ; $a<count($avis);++$a ) {
        if ($avis[$a]['etoiles'] == 1)
            ++$star1;
        elseif ($avis[$a]['etoiles'] == 2)
            ++$star2;
        elseif ($avis[$a]['etoiles'] == 3)
            ++$star3;
        elseif ($avis[$a]['etoiles'] == 4)
            ++$star4;
        elseif ($avis[$a]['etoiles'] == 5)
            ++$star5;
    }

    return $this->render('Avis.html.twig',
        [
            'star1'=>$star1,
            'star2'=>$star2,
            'star3'=>$star3,
            'star4'=>$star4,
            'star5'=>$star5,
        ]
    );
}
}
