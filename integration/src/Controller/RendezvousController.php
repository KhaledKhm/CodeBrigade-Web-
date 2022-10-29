<?php

namespace App\Controller;

use App\Entity\Postulant;
use App\Entity\Utilisateur;
use App\Form\RendezVousType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RendezvousController extends AbstractController
{
    /**
     * @Route("/rendezvous/{id}", name="rendezvous")
     */
    public function index(Request $request , \Swift_Mailer $mailer, $id)
    {
        $form = $this->createForm(RendezVousType::class);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Utilisateur::class)->find($id);
        if($form->isSubmitted() && $form->isValid()){
            $rdv = $form->getData();

            //envoie du mail
            $message = (new \Swift_Message('Nouveau Rendez-Vous'))
                //sender
                ->setFrom($rdv['email'])
                //destinataire
                ->setTo($post->getEmail())
                //renvoie au twig
                ->setBody(
                    $this->renderView(
                        'emails/rendezvous.html.twig', compact('rdv')
                    ),
                    'text/html'
                )
            ;
            //envoie le msg
            $mailer->send($message);
            $this->addFlash('message', 'le message a bien été envoyé');
            return $this->redirectToRoute('offre');
        }
        return $this->render('rendezvous/index.html.twig', [
            'rdv' => $form->createView()
        ]);
    }
}
