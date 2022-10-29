<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Promotion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PromotionController extends AbstractController
{
    /**
     * @Route("/promotion", name="promotion")
     */
    public function index(): Response
    {
        $class = $this->getDoctrine()->getRepository(Promotion::class)->findAll();
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->findAll();
        return $this->render('promotion/list.html.twig', ['classe'=>$class,'class'=>$evenement]);
    }
    /**
     * @Route("/ajouterPromotion", name="ajouterPromotion")
     */
    public function createPromotion(Request $request)
    {
        if ($request->request->count()>0)
        {
            $promotion=new Promotion();
            $promotion->setLibelle($request->get('Libelle'));
            $promotion->setPoucentageReduction($request->get('PoucentageReduction'));
            $em=$this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();
            return $this->redirectToRoute('promotion');
        }
        $evenement=$this->getDoctrine()->getRepository(Evenement::class)->findAll();
        return $this->render('promotion/add.html.twig',['class'=>$evenement]);
    }
    /**
     * @Route("/modifierPromotion/{id}", name="modifierPromotion")
     */
    public function updatePromotion(Request $request,$id)
    {
        if ($request->request->count()>0)
        {
            $em=$this->getDoctrine()->getManager();
            $promotion=$em->getRepository(Promotion::class)->find($id);
            $promotion->setLibelle($request->get('libelle'));
            $promotion->setPoucentageReduction($request->get('PoucentageReduction'));
            $em->flush();
            return $this->redirectToRoute('promotion');
        }

        $promotion=$this->getDoctrine()->getRepository(Promotion::class)->find($id);
        return $this->render('promotion/update.html.twig', ['promotion'=>$promotion]);
    }

    /**
     * @Route("/supprimerPromotion/{id}",name="supprimerPromotion")
     */
    public function deletePromotion($id)
    {
        $em = $this->getDoctrine()->getManager();
        $class = $this->getDoctrine()->getRepository(Promotion::class)->find($id);
        $em->remove($class);
        $em->flush();
        return $this->redirectToRoute('promotion');
    }
    /**
     * @param Request $request
     * @param $id
     * @Route ("/ajoutPromo/{id}", name="ajoutPromo")
     */
    public function AjouterPromo(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Evenement::class)->find($id);
        if ($request->request->count()>0)
        {
            $promotion=new Promotion();
            $promotion->setLibelle($request->get('Libelle'));
            $promotion->setPoucentageReduction($request->get('PoucentageReduction'));
            $em=$this->getDoctrine()->getManager();
            $promotion->addEvenement($event);
            $em->persist($promotion);
            $em->flush();
            return $this->redirectToRoute('promotion');


            return $this->redirectToRoute('evenementf');
        }
        return $this->render('promotion/add.html.twig');
    }

}
