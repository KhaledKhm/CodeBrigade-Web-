<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\Postulant;
use App\Entity\Utilisateur;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UtilisateurOffreController extends AbstractController
{
    /**
     * @Route("/postulant", name="postulant")
     */
    public function index(): Response
    {
        $class = $this->getDoctrine()->getRepository(Offre::class)->findAll();
        return $this->render('postulant/index2.html.twig', [
            'class' => $class,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @param UserInterface $user1
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/ajoutPost/{id}", name="ajoutPost")
     */
    public function AjouterPostul(Request $request, $id,UserInterface $user1){
        $userId = $user1->getId();
        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository(Offre::class)->find($id);

        if ($request->request->count()>0){
            $user = $em->getRepository(Utilisateur::class)->find($userId);
            $user->setEmail($request->get('Email'));
            $user->addOffre($offre);
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('postulant');
        }
        $user = $em->getRepository(Utilisateur::class)->find($userId);

        return $this->render('postulant/add1.html.twig', ['user'=>$user]);
    }

    /**
     * @Route("/suppPost/{id}", name="suppPost")
     */
    public function suppPost($id){
        $em = $this->getDoctrine()->getManager();
        $class = $this->getDoctrine()->getRepository(Postulant::class)->find($id);
        $em->remove($class);
        $em->flush();
        return $this->redirectToRoute('offre');
    }



}
