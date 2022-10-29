<?php

namespace App\Controller;

use App\Entity\ParticipationEvaluation;
use App\Entity\Quiz;
use App\Entity\Evaluation;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use mpdf\mpdf;
use Symfony\Component\Security\Core\User\UserInterface;

class QuizController extends AbstractController
{
    /**
     * @Route("/ListQuiz/{idE}", name="ListQuiz")
     */
    public function index($idE): Response
    {
        $class = $this->getDoctrine()->getRepository(Quiz::class)->findAll();
        $evaluation = $this->getDoctrine()->getRepository(Evaluation::class)->findAll();
        return $this->render('evaluation/listQ.html.twig', ['classe'=>$class,'idE'=>$idE,'evaluation'=>$evaluation]);

    }

    /**
     * @Route("/ajouterQuiz/{idE}", name="ajouterQuiz")
     */
    public function createQuiz(Request $request,$idE)
    {
        if ($request->request->count()>0)
        {
            $quiz=new Quiz();
            $quiz->setIdEvaluation($request->get('idE'));
            $quiz->setQuestion($request->get('Question'));
            $quiz->setChoix1($request->get('Choix1'));
            $quiz->setChoix2($request->get('Choix2'));
            $quiz->setChoix3($request->get('Choix3'));
            $quiz->setReponse($request->get('Response'));
            $em=$this->getDoctrine()->getManager();
            $em->persist($quiz);
            $em->flush();
            return $this->redirectToRoute('afficherQuiz');
        }
        $evaluation=$this->getDoctrine()->getRepository(Evaluation::class)->find($idE);
        return $this->render('evaluation/addQ.html.twig',['Evaluation'=>$evaluation]);
    }

    /**
     * @Route("/supprimerQuiz/{id}",name="supprimerQuiz")
     */
    public function deleteQuiz($id)
    {
        $em = $this->getDoctrine()->getManager();
        $class = $this->getDoctrine()->getRepository(Quiz::class)->find($id);
        $em->remove($class);
        $em->flush();
        return $this->redirectToRoute('afficherQuiz');
    }

    /**
     * @Route("/participerQuiz/{id}",name="participerQuiz")
     */
    public function participerQuiz(Request $request,$id,UserInterface $user)
    {
        if ($request->request->count()>0)
        {
            $em=$this->getDoctrine()->getManager();
            $evaluation=$em->getRepository(Evaluation::class)->find($id);
            /*$evaluation->setLibelle($request->get('Libelle'));
            $evaluation->setDescription($request->get('Description'));
            $evaluation->setDateevaluation($request->get('Dateevaluation'));
            $evaluation->setIdEntreprise($request->get('Identreprise'));
            $em->flush();*/
            return $this->redirectToRoute('evaluationF');
        }
        $evaluation=$this->getDoctrine()->getRepository(Evaluation::class)->find($id);
        $quiz=$this->getDoctrine()->getRepository(Quiz::class)->findAll();
        $participation=$this->getDoctrine()->getRepository(ParticipationEvaluation::Class)->findAll();
        $userid=$user->getId();
        return $this->render('evaluation/quizF.html.twig', ['evaluation'=>$evaluation,'quiz'=>$quiz,'participation'=>$participation,'userid'=>$userid]);
    }




}
