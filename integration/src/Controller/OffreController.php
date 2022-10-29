<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\Postulant;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class OffreController extends AbstractController
{
    /**
     * @Route("/offre", name="offre")
     */
    public function index(): Response
    {
        $class = $this->getDoctrine()->getRepository(Offre::class)->findAll();
        return $this->render('offre/index.html.twig', [
            'class' => $class,
        ]);
    }

    /**
     * @Route("/Ajouteroffre", name="Ajouteroffre")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function AjouterOffre(Request $request){

        if ($request->request->count()>0)
        {
            $offre=new Offre();
            $offre->setDescription($request->get('Description'));
            $offre->setLibelle($request->get('Libelle'));
            $offre->setDateLimite($request->get('DateLimite'));
            $offre->setSalaire($request->get('Salaire'));
            $offre->setDisponabilite($request->get('Disponabilite'));
            $em=$this->getDoctrine()->getManager();
            $em->persist($offre);
            $em->flush();
            return $this->redirectToRoute('offre');
        }
        return $this->render('offre/add.html.twig');

    }

    /**
     * @Route("/supprimerOffre/{id}",name="supprimerOffre")
     */
    public function SupprimerOffre($id){
        $em = $this->getDoctrine()->getManager();
        $class = $this->getDoctrine()->getRepository(Offre::class)->find($id);
        $em->remove($class);
        $em->flush();
        return $this->redirectToRoute('offre');
    }
    /**
     * @Route("/modifierOffre/{id}",name="modifierOffre")
     */

    public function modifierOffre(Request $request,$id ){
        if ($request->request->count()>0)
        {
            $em=$this->getDoctrine()->getManager();
            $offre=$em->getRepository(Offre::class)->find($id);
            $offre->setLibelle($request->get('Libelle'));
            $offre->setDescription($request->get('Description'));
            $offre->setDateLimite($request->get('DateLimite'));
            $offre->setSalaire($request->get('Salaire'));
            $offre->setDisponabilite($request->get('Disponabilite'));
            $em->flush();
            return $this->redirectToRoute('offre');
        }
        $offre =$this->getDoctrine()->getRepository(Offre::class)->find($id);
        return $this->render('offre/update.html.twig', ['offre'=>$offre]);
    }

    /**
     * @param $id
     * @Route ("/listPost/{id}", name="listPost")
     */

    public function ListPost($id){
        $class = $this->getDoctrine()->getRepository(Offre::class)->find($id);
        $post =$class->getUtilisateurs();
        return  $this->render('postulant/list.html.twig', ['post'=>$post]);


    }

//    /**
//     * @param $id
//     * @return Response
//     * @Route("/ajoutFav/{id}", name="ajoutFav")
//     */
//
//    public function AjoutFavoris($id){
//        $em = $this->getDoctrine()->getManager();
//        $offre = $em->getRepository(Offre::class)->find($id);
//        $class = new Postulant();
//        $fav = $class->getFavoris();
//
//        return $this->render('postulant/fav.html.twig',['fav'=>$fav]);
//    }

    /**
     * @param $id
     * @param UserInterface $user1
     * @return Response
     * @Route("/ajoutFav/{id}", name="ajoutFav")
     */

    public function AjoutFavoris($id,UserInterface $user1){
        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository(Offre::class)->find($id);
        $userId = $user1->getId();
        $user = $em->getRepository(Utilisateur::class)->find($userId);
        $user->addFavori($offre);
        $em->persist($user);
        $em->flush();
        $fav = $user->getFavoris();

        return $this->render('postulant/fav.html.twig',['fav'=>$fav]);
    }


}
