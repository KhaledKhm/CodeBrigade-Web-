<?php

namespace App\Controller;

use App\Entity\ParticipationEvaluation;
use App\Entity\Utilisateur;
use App\Entity\Evaluation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipationEvaluationController extends AbstractController
{
    /**
     * @Route("/ListParticipationEvaluation/{idE}", name="ListParticipationEvaluation")
     */
    public function index($idE): Response
    {
        $class = $this->getDoctrine()->getRepository(ParticipationEvaluation::class)->findAll();
        return $this->render('evaluation/listP.html.twig', ['classe'=>$class,'idE'=>$idE]);
    }

    /**
     * @Route("/ajouterParticipationEvaluation/{idE}", name="ajouterParticipationEvaluation")
     */
    public function createParticipationEvaluation(Request $request,$idE)
    {
        if ($request->request->count()>0)
        {
            $Pevaluation=new ParticipationEvaluation();
            $Pevaluation->setIdE($request->get('idE'));
            $Pevaluation->setIdP($request->get('idP'));
            $em=$this->getDoctrine()->getManager();
            $em->persist($Pevaluation);
            $em->flush();
            return $this->redirectToRoute('afficherParticipants');
        }
        $class = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        $evaluation=$this->getDoctrine()->getRepository(Evaluation::class)->find($idE);
        return $this->render('evaluation/addP.html.twig',['classe'=>$class,'Evaluation'=>$evaluation]);
    }

    /**
     * @Route("/supprimerParticipationEvaluation/{code}",name="supprimerParticipationEvaluation")
     */
    public function deleteParticipationEvaluation($code)
    {
        $em = $this->getDoctrine()->getManager();
        $class = $this->getDoctrine()->getRepository(ParticipationEvaluation::class)->find($code);
        $em->remove($class);
        $em->flush();
        return $this->redirectToRoute('afficherParticipants');
    }
}
