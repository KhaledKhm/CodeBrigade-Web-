<?php

namespace App\Controller;
use App\Entity\Evaluation;
use App\Entity\ParticipationEvaluation;
use App\Entity\Quiz;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class EvaluationController extends AbstractController
{
    /**
     * @Route("/evaluation", name="evaluation")
     */
    public function index(): Response
    {
        $class = $this->getDoctrine()->getRepository(Evaluation::class)->findAll();
        return $this->render('evaluation/list.html.twig', ['classe'=>$class]);
    }

    /**
     * @Route("/evaluationF", name="evaluationF")
     */
    public function listF(): Response
    {
        $class = $this->getDoctrine()->getRepository(Evaluation::class)->findAll();
        $participation = $this->getDoctrine()->getRepository(ParticipationEvaluation::class)->findAll();
        return $this->render('evaluation/listF.html.twig', ['classe'=>$class,'participation'=>$participation]);
    }


    /**
     * @Route("/afficherParticipants", name="afficherParticipants")
     */
    public function listparticipants(): Response
    {
        $class = $this->getDoctrine()->getRepository(Evaluation::class)->findAll();
        return $this->render('evaluation/participants.html.twig', ['classe'=>$class]);
    }
    /**
     * @Route("/afficherQuiz", name="afficherQuiz")
     */
    public function listquiz(): Response
    {
        $class = $this->getDoctrine()->getRepository(Evaluation::class)->findAll();
        return $this->render('evaluation/quiz.html.twig', ['classe'=>$class]);
    }

    /**
     * @Route("/ajouterEvaluation", name="ajouterEvaluation")
     */
    public function createEvaluation(Request $request)
    {
        if ($request->request->count()>0)
        {
            $evaluation=new Evaluation();
            $evaluation->setLibelle($request->get('Libelle'));
            $evaluation->setDescription($request->get('Description'));
            $evaluation->setDateevaluation($request->get('Dateevaluation'));
            $evaluation->setIdEntreprise($request->get('Identreprise'));
            $em=$this->getDoctrine()->getManager();
            $em->persist($evaluation);
            $em->flush();
            return $this->redirectToRoute('evaluation');
        }
        $entreprise=$this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        return $this->render('evaluation/add.html.twig',['classe'=>$entreprise]);
    }

    /**
     * @Route("/modifierEvaluation/{id}", name="modifierEvaluation")
     */
    public function updateEvaluation(Request $request,$id)
    {
        if ($request->request->count()>0)
        {
            $em=$this->getDoctrine()->getManager();
            $evaluation=$em->getRepository(Evaluation::class)->find($id);
            $evaluation->setLibelle($request->get('Libelle'));
            $evaluation->setDescription($request->get('Description'));
            $evaluation->setDateevaluation($request->get('Dateevaluation'));
            $evaluation->setIdEntreprise($request->get('Identreprise'));
            $em->flush();
            return $this->redirectToRoute('evaluation');
        }
        $evaluation=$this->getDoctrine()->getRepository(Evaluation::class)->find($id);
        $entreprise=$this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        return $this->render('evaluation/update.html.twig', ['evaluation'=>$evaluation,'classe'=>$entreprise]);
    }

    /**
     * @Route("/supprimerEvaluation/{id}",name="supprimerEvaluation")
     */
    public function deleteEvaluation($id)
    {
        $em = $this->getDoctrine()->getManager();
        $class = $this->getDoctrine()->getRepository(Evaluation::class)->find($id);
        $em->remove($class);
        $em->flush();
        return $this->redirectToRoute('evaluation');
    }

    /**
     * @Route("/pdfEvaluation/{id}/{libelle}/{description}/{dateevaluation}/{identreprise}",name="pdfEvaluation")
     */
    public function pdf($id,$libelle,$description,$dateevaluation,$identreprise)
    {
        $mdpdf = new \Mpdf\Mpdf();

        //Contenu du PDF
        $data= "";


        $data.="<h1>Votre Evaluation</h1>";

        $data.="<strong>ID Evaluation : </strong> " . $id . "<br>";
        $data.="<strong>libelle Evaluation : </strong> " . $libelle . "<br>";
        $data.="<strong>Description Evaluation : </strong> " . $description . "<br>";
        $data.="<strong>Date Dvaluation : </strong> " . $dateevaluation . "<br>";
        $data.="<strong>ID Entreprise : </strong>" . $identreprise . "<br>";

        $quiz = $this->getDoctrine()->getRepository(Quiz::class)->findall();
        $data.="<h2>Vos Questions du quiz</h2>";
        $cmp=0;
        foreach ($quiz as $q)
        {
            if($q->getIdEvaluation()==$id)
            {
                $data .= "<strong>Question$cmp : </strong> " . $q->getQuestion() . "<br>";
                $data .= "<strong>Choix1 : </strong> " . $q->getChoix1() . "<br>";
                $data .= "<strong>Choix2 : </strong> " . $q->getChoix2() . "<br>";
                $data .= "<strong>Choix3 : </strong> " . $q->getChoix3() . "<br><br>";
            }
        }

        //Création du PDF
        $mdpdf->WriteHTML($data);

        //Téléchargement du PDF
        $mdpdf->Output("Evaluation N".$id.".pdf","D");

        return $this->redirectToRoute('evaluation');
    }



}

