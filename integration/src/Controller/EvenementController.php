<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Promotion;

use App\Repository\UtilisateurRepository;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class EvenementController extends AbstractController


{
    /**
     * @Route("/evenement", name="evenement")
     */
    public function index(): Response
    {
        $class = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

        return $this->render('evenement/list.html.twig', ['classe'=>$class]);

    }
    /**
     * @Route("/evenementf", name="evenementf")
     */
    public function ind(): Response
    {
        $class = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

        return $this->render('evenement/f.html.twig', ['classe'=>$class]);

    }
    /**
     * @Route("/home", name="home")
     */
    public function in(): Response
    {
        $class = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

        return $this->render('evenement/home.html.twig', ['classe'=>$class]);

    }
    /**
     * @Route("/stats", name="stats")
     */
    public function statistiques(EvenementRepository $categEvent){
        // On va chercher toutes les Evenements
        $evenements = $categEvent->findAll();

        $categNom = [];
        $categColor = [];
        $categCount = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($evenements as $evenement){
            $categNom[] = $evenement->getlibelle();
            $categColor[] = $evenement->getColor();
            $categCount[] = count($evenement->getUtilisateurs());
        }



        return $this->render('evenement/stats.html.twig', [
            'categNom' => json_encode($categNom),
            'categColor' => json_encode($categColor),
            'categCount' => json_encode($categCount),
        ]);
    }


    /**
     * @param $id
     * @Route ("/listPost0/{id}", name="listPost0")
     */

    public function ListPost($id){
        $class = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $post =$class->getUtilisateurs();
        return  $this->render('postulant/a.html.twig', ['post'=>$post]);


    }

    /**
     * @param $id
     * @Route ("/listPost1/{id}", name="listPost1")
     */

    public function ListPost1($id){
        $class = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $post =$class->getPromotions();
        return  $this->render('promotion/b.html.twig', ['post'=>$post]);


    }

    /**
     * @Route("/ajouterEvenement", name="ajouterEvenement")
     */
    public function createEvenement(Request $request)
    {
        if ($request->request->count()>0)
        {
            $evenement=new Evenement();
            $evenement->setLibelle($request->get('Libelle'));
            $evenement->setDescription($request->get('description'));
            $evenement->setDateDebut($request->get('DateDebut'));
            $evenement->setDateFin($request->get('DateFin'));
            $evenement->setPrixInscription($request->get('PrixInscription'));
            $evenement->setcolor($request->get('color'));
            $em=$this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('evenement');
        }
        return $this->render('evenement/add.html.twig');
    }

    /**
     * @Route("/modifierEvenement/{id}", name="modifierEvenement")
     */
    public function updateEvenement(Request $request,$id)
    {
        if ($request->request->count()>0)
        {
            $em=$this->getDoctrine()->getManager();
            $evenement=$em->getRepository(Evenement::class)->find($id);
            $evenement->setLibelle($request->get('Libelle'));
            $evenement->setDescription($request->get('description'));
            $evenement->setDateDebut($request->get('DateDebut'));
            $evenement->setDateFin($request->get('DateFin'));
            $evenement->setPrixInscription($request->get('PrixInscription'));
            $evenement->setcolor($request->get('color'));

            $em->flush();
            return $this->redirectToRoute('evenement');
        }
        $evenement=$this->getDoctrine()->getRepository(Evenement::class)->find($id);
        return $this->render('evenement/update.html.twig', ['evenement'=>$evenement]);
    }

    /**
     * @Route("/supprimerEvenement/{id}",name="supprimerEvenement")
     */
    public function deleteEvenement($id)
    {
        $em = $this->getDoctrine()->getManager();
        $class = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $em->remove($class);
        $em->flush();
        return $this->redirectToRoute('evenement');
    }

}
