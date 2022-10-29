<?php

namespace App\Controller;

use App\Entity\ParticipationEvaluation;
use App\Entity\Utilisateur;
use App\Entity\Evaluation;
use App\Entity\Quiz;
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
        $util = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        $quiz = $this->getDoctrine()->getRepository(Quiz::class)->findAll();
        $evaluation = $this->getDoctrine()->getRepository(Evaluation::class)->findAll();
        return $this->render('evaluation/listP.html.twig', ['classe'=>$class,'idE'=>$idE,'util'=>$util,'quiz'=>$quiz,'evaluation'=>$evaluation]);
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
        $participations= $this->getDoctrine()->getRepository(ParticipationEvaluation::class)->findAll();
        return $this->render('evaluation/addP.html.twig',['classe'=>$class,'Evaluation'=>$evaluation,'participations'=>$participations]);
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

    /**
     * @Route("/validerScore/{code}/{score}", name="validerScore")
     */
    public function validerScore($code,$score)
    {
            $em=$this->getDoctrine()->getManager();
            $pevaluation=$em->getRepository(ParticipationEvaluation::class)->find($code);
            $pevaluation->setNote($score);
            $em->flush();
            return $this->redirectToRoute('evaluationF');
    }
}
