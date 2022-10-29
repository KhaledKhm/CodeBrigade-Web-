<?php

namespace App\Controller;

use App\Entity\Entretien;
use App\Entity\ParticipationEvaluation;
use App\Repository\EntretienRepository;
use App\Entity\Evaluation;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Security\Core\User\UserInterface;


class EntretienController extends AbstractController
{
    /**
     * @Route("/entretien", name="entretien")
     */
    public function index(): Response
    {
        $class = $this->getDoctrine()->getRepository(Entretien::class)->findAll();
        $participants= $this->getDoctrine()->getRepository(ParticipationEvaluation::class)->findAll();
        $utilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        $evaluation = $this->getDoctrine()->getRepository(Evaluation::class)->findAll();
        return $this->render('entretien/list.html.twig', ['classe'=>$class,'participants'=>$participants,'utilisateur'=>$utilisateur,'evaluation'=>$evaluation]);
    }

    /**
     * @Route("/entretienF", name="entretienF")
     */
    public function indexF(UserInterface $user): Response
    {
        $class = $this->getDoctrine()->getRepository(Entretien::class)->findAll();
        $userid=$user->getId();
        return $this->render('entretien/listF.html.twig', ['classe'=>$class,'userid'=>$userid]);
    }

    /**
     * @Route("/ajouterEntretien", name="ajouterEntretien")
     */
    public function createEntretien(Request $request)
    //public function createEntretien(Request $request)
    {
        if ($request->request->count()>0)
        {
            $entretien=new Entretien();
            $entretien->setLibelle($request->get('Libelle'));
            $entretien->setDescription($request->get('Description'));
            $entretien->setDateentretien($request->get('Dateentretien'));
            $entretien->setIdEvaluation($request->get('Idevaluation'));
            $em=$this->getDoctrine()->getManager();
            $em->persist($entretien);
            $em->flush();
            return $this->redirectToRoute('entretien');
        }
        $class = $this->getDoctrine()->getRepository(Evaluation::class)->findAll();
        $participant = $this->getDoctrine()->getRepository(ParticipationEvaluation::class)->findAll();
        $entretien = $this->getDoctrine()->getRepository(Entretien::class)->findAll();
        return $this->render('entretien/add.html.twig', ['classe'=>$class,'participant'=>$participant,'entretien'=>$entretien]);
    }

    /**
     * @Route("/modifierEntretien/{id}", name="modifierEntretien")
     */
    public function updateEntretien(Request $request,$id)
    {
        if ($request->request->count()>0)
        {
            $em=$this->getDoctrine()->getManager();
            $entretien=$em->getRepository(Entretien::class)->find($id);
            $entretien->setLibelle($request->get('Libelle'));
            $entretien->setDescription($request->get('Description'));
            $entretien->setDateentretien($request->get('Dateentretien'));
            $em->flush();
            return $this->redirectToRoute('entretien');
        }
        $entretien=$this->getDoctrine()->getRepository(Entretien::class)->find($id);
        $utilisateur=$this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        $evaluation=$this->getDoctrine()->getRepository(Evaluation::class)->findAll();
        return $this->render('entretien/update.html.twig', ['entretien'=>$entretien,'utilisateur'=>$utilisateur,'evaluation'=>$evaluation]);
    }

    /**
     * @Route("/supprimerEntretien/{id}",name="supprimerEntretien")
     */
    public function deleteEntretien($id)
    {
        $em = $this->getDoctrine()->getManager();
        $class = $this->getDoctrine()->getRepository(Entretien::class)->find($id);
        $em->remove($class);
        $em->flush();
        return $this->redirectToRoute('entretien');
    }

    /**
     * @Route("/ajouterParticipantEntretien/{id}/{libelle}/{description}/{dateentretien}/{idevaluation}", name="ajouterParticipantEntretien")
     */
    public function ajouterParticipant(Request $request,$id,$libelle,$description,$dateentretien,$idevaluation)
    {
        if ($request->request->count()>0)
        {
            $em=$this->getDoctrine()->getManager();
            $entretien=$em->getRepository(Entretien::class)->find($id);
            $entretien->setIdParticipant($request->get('IdParticipant'));
            $em->flush();
            //mailing
            $mail = new PHPMailer(true);

            try {
                $idP=$request->get('IdParticipant');
                $utilisateur=$em->getRepository(Utilisateur::class)->find($idP);
                $nom=$utilisateur->getNomPersonne();
                $prenom=$utilisateur->getPrenomPersonne();
                $email=$utilisateur->getEmail();

                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'houssem.ouerdiane@esprit.tn';             // SMTP username
                $mail->Password   = 'fallout3';                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                //Recipients
                $mail->setFrom('houssem.ouerdiane@esprit.tn', 'JOBBOOK');
                $mail->addAddress($email, 'JOBBOOK USER');     // Add a recipient

                // Content
                $corps="Bonjour Monsieur/Madame ".$nom." ".$prenom." Nous sommes ravi de vous informer que vous etes affectué a un entretien d' id ".$id." ".$libelle." qui est ".$description." le ".$dateentretien." d'ID d'Evaluation ".$idevaluation;
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Vous Etes Affectue A Un Entretien!';
                $mail->Body    = $corps;

                $mail->send();

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            //end mailing
            return $this->redirectToRoute('entretien');
        }
        $entretien=$this->getDoctrine()->getRepository(Entretien::class)->find($id);
        $participant = $this->getDoctrine()->getRepository(ParticipationEvaluation::class)->findAll();
        $utilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        $evaluation = $this->getDoctrine()->getRepository(Evaluation::class)->findAll();
        return $this->render('entretien/addP.html.twig', ['entretien'=>$entretien,'participant'=>$participant,'utilisateur'=>$utilisateur,'evaluation'=>$evaluation]);
    }

    /**
     * @Route("/pdfEntretien/{id}/{libelle}/{description}/{dateentretien}/{idevaluation}/{idparticipant}",name="pdfEntretien")
     */
    public function pdf($id,$libelle,$description,$dateentretien,$idevaluation,$idparticipant)
    {
        $mdpdf = new \Mpdf\Mpdf();

        //Contenu du PDF
        $data= "";


        $data.="<h1>Vos Informations</h1>";

        $data.="<strong>ID Entretien : </strong> " . $id . "<br>";
        $data.="<strong>Libelle Entretien : </strong> " . $libelle . "<br>";
        $data.="<strong>Description Entretien : </strong> " . $description . "<br>";
        $data.="<strong>Date Entretien : </strong> " . $dateentretien . "<br>";
        $data.="<strong>ID Evaluation : </strong>" . $idevaluation . "<br>";
        $data.="<strong>ID Participant : </strong>" . $idparticipant . "<br>";

        //Création du PDF
        $mdpdf->WriteHTML($data);

        //Téléchargement du PDF
        $mdpdf->Output("Entretien N".$id.".pdf","D");

        return $this->redirectToRoute('entretien');
    }

    /**
     * @Route("/PDFE", name="PDFE", methods={"GET"})
     */
    public function PDFE(EntretienRepository $EntretienRepository): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('entretien/pdf.html.twig', [
            'entretiens' => $EntretienRepository->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A2', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("ListeEntretiens.pdf", [
            "Attachment" => false
        ]);
    }

    /**
     * @Route("/EntretienT", name="EntretienT")
     */
    public function sortByTitleASC(): Response
    {
        $rep=$this->getDoctrine()->getRepository(Entretien::class);
        $participants= $this->getDoctrine()->getRepository(ParticipationEvaluation::class)->findAll();
        $utilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        $evaluation = $this->getDoctrine()->getRepository(Evaluation::class)->findAll();
        $class=$rep->sortByTitleASC();
        return $this->render('entretien/list.html.twig', [
            'classe' => $class,'participants'=>$participants,'utilisateur'=>$utilisateur,'evaluation'=>$evaluation
        ]);
    }

    /**
     * @Route("/EntretienTD", name="EntretienTD")
     */
    public function sortByTitleDSC(): Response
    {
        $rep=$this->getDoctrine()->getRepository(Entretien::class);
        $participants= $this->getDoctrine()->getRepository(ParticipationEvaluation::class)->findAll();
        $utilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        $evaluation = $this->getDoctrine()->getRepository(Evaluation::class)->findAll();
        $class=$rep->sortByTitleDSC();
        return $this->render('entretien/list.html.twig', [
            'classe' => $class,'participants'=>$participants,'utilisateur'=>$utilisateur,'evaluation'=>$evaluation
        ]);
    }

}
