<?php

namespace DemandeBundle\Controller;
use Ivory\GoogleMap\Event\Event;
use Ivory\GoogleMap\Control\ControlPosition;
use Ivory\GoogleMap\Control\CustomControl;
use Ivory\GoogleMap\Service\Geocoder\GeocoderService;
use Http\Adapter\Guzzle6\Client;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Overlay\Animation;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\Marker;
use Ivory\GoogleMap\Overlay\MarkerShape;
use Ivory\GoogleMap\Overlay\MarkerShapeType;
use Ivory\GoogleMap\Overlay\Symbol;
use Ivory\GoogleMap\Overlay\SymbolPath;
use Composer\Command\SearchCommand;
use DemandeBundle\Entity\Demande;
use DemandeBundle\Entity\Message;
use DemandeBundle\Entity\Ordre;
use DemandeBundle\Form\DemandeType;
use DemandeBundle\Form\MessageType;
use DemandeBundle\Repository\MessageRepository;
use http\Client\Response;
use Ivory\GoogleMap\Map;
use LoginBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class DemandeController extends Controller
{

    public function addDemandeAction(Request $request){
        $authChecker=$this->container->get('security.authorization_checker');

        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('display');
        }
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->add("ajouter", SubmitType::class);
        $form = $form->handleRequest($request);

        if($form->isValid()){



            foreach ($_FILES['demandebundle_demande']['name'] as $name => $value)
            {
                $my_file_name = explode(".", $_FILES['demandebundle_demande']['name'][$name]);

                //{
                $NewImageName = md5(rand()) . '.' . $my_file_name[1];
                $SourcePath = $_FILES['demandebundle_demande']['tmp_name'][$name];
                $TargetPath = "ImagesDemandes/".$NewImageName;

                move_uploaded_file($SourcePath, $TargetPath);

            }

            $today = new \DateTime();
            $demande->setEtat('non traitee');
            $demande->setDateDemande($today);
            $demande->setImage($TargetPath);
            $demande->setClient($this->getUser());



            $en = $this->getDoctrine()->getManager();
            $en->persist($demande);
            $en->flush();
            return $this->redirectToRoute('display');
        }

        return $this->render('@Demande/Default/addDemande.html.twig', array('form'=>$form->createView()));
    }

    public function displayDemandeAction()
    {
        $roles = $this->getUser()->getRoles();
        $role = $roles[0];
        if ($role == 'ROLE_ADMIN') {
            return $this->redirectToRoute('displayAdmin');
        } else {
            $demandes = $this->getDoctrine()->getRepository(Demande::class)->findByClient($this->getUser()->getId());
            $role = "ROLE_USER";
        }

        $message = new Message();
        $today = new \DateTime();
        return $this->render(
                        '@Demande/Default/displayDemande.html.twig',
                                array(
                                "demandes" => $demandes,
                                "role" => $role,
                                ));
    }


    public function displayDemandeAdminAction(Request $request){
        $roles = $this->getUser()->getRoles();
        $role = $roles[0];
        if ($role == 'ROLE_ADMIN') {
            $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        } else {
            $role = "ROLE_USER";
            return $this->redirectToRoute('display');
        }

        $message = new Message();
        $today = new \DateTime();
        $allMessages = $this->getDoctrine()->getRepository(Message::class)->findMessage();
        $formMessage = $this->createForm(MessageType::class, $message)
                            ->add('envoyer',SubmitType::class);

        return $this->render(
                     '@Demande/Default/displayDemandeAdmin.html.twig',
                            array("demandes" => $demandes,
                            "role" => $role,
                            "formMessage"=>$formMessage->createView(),
                            "allMessages" => $allMessages
                            ));
    }




    public function imageDemandeAdminAction($id){
        $roles = $this->getUser()->getRoles();
        $role = $roles[0];
        if ($role == 'ROLE_ADMIN') {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findById($id);
        return $this->render('@Demande/Default/ImageDemandeAdmin.html.twig', array('demandes'=>$demandes));
        }else{
            return $this->redirectToRoute('display');
        }
    }


    public function imageDemandeAction($id){
        $roles = $this->getUser()->getRoles();
        $role = $roles[0];
        if ($role == 'ROLE_ADMIN') {
            return $this->redirectToRoute('display');
        }
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findById($id);
        return $this->render('@Demande/Default/ImageDemande.html.twig', array('demandes'=>$demandes));
    }

    public function removeAction($id){
        $demande = $this->getDoctrine()->getRepository(Demande::class)->find($id);
        $messages = $this->getDoctrine()->getRepository(Message::class)->findByDemande($id);
        $ordres = $this->getDoctrine()->getRepository(Ordre::class)->findByDemande($id);
        $en = $this->getDoctrine()->getManager();
        foreach ($messages as $row){
            $en->remove($row);
        }
        foreach ($ordres as $row){
            $en->remove($row);
        }
        $en->remove($demande);
        $en->flush();
        return $this->redirectToRoute('display');

    }

    public function confirmerAction( $id){
        $demande = $this->getDoctrine()->getRepository(Demande::class)->findOneById($id);
        $ordre = new Ordre();
        $ordre->setEtat("enAttente");
        $ordre->setDemande($demande);
        $today = new \DateTime();
        $ordre->setDateOrdre($today);

        $demande->setEtat("confirmee");

        $en = $this->getDoctrine()->getManager();
        $en->persist($demande);
        $en->persist($ordre);
        $en->flush();

        return $this->redirectToRoute('display');
    }

    public function envoyerMessageAction(Request $request, $demande, $senderRole){
        $message = new Message();
        $today = new \DateTime();
        $form = $this->createForm(MessageType::class, $message)
            ->add('envoyer',SubmitType::class);
        $form->handleRequest($request);
        $message->setDateEnvoi($today);
        $message->setSenderRole($senderRole);
        $message->setDemande($demande);

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            return $this->redirectToRoute('display');
        }

        public function messengerAdminAction($idDemande,Request $request){
            $message = new Message();
            $today = new \DateTime();
            $demande = $this->getDoctrine()->getRepository(Demande::class)->find($idDemande);
            $messages = $this->getDoctrine()->getRepository(Message::class)->findByDemande($idDemande);
            $form = $this->createForm(MessageType::class, $message)->add('envoyer', SubmitType::class);
            $demande->setNotificationAdmin(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();

            $form->handleRequest($request);

            if($form->isSubmitted()){
                $message->setDemande($demande);
                $message->setDateEnvoi($today);
                $message->setSenderRole('ROLE_ADMIN');
                $demande->setNotificationClient(true);

                $em->persist($message);
                $em->persist($demande);
                $em->flush();
                return $this->redirectToRoute('display');
            }
            return $this->render('@Demande/Default/messengerAdmin.html.twig', array(
                                                                                        'messages'=>$messages,
                                                                                        'formMessage'=>$form->createView(),
                                                                                        'demande'=> $demande
                                                                                        ));
        }

    public function messengerClientAction($idDemande,Request $request){
        $message = new Message();
        $today = new \DateTime();
        $demande = $this->getDoctrine()->getRepository(Demande::class)->find($idDemande);
        $messages = $this->getDoctrine()->getRepository(Message::class)->findByDemande($idDemande);
        $form = $this->createForm(MessageType::class, $message)->add('envoyer', SubmitType::class);
        $demande->setNotificationClient(false);
        $em = $this->getDoctrine()->getManager();
        $em->persist($demande);
        $em->flush();

        $form->handleRequest($request);


        if($form->isSubmitted()){
            $message->setDemande($demande);
            $message->setDateEnvoi($today);
            $message->setSenderRole('ROLE_USER');
            $demande->setNotificationAdmin(true);

            $em->persist($message);
            $em->persist($demande);
            $em->flush();
            return $this->redirectToRoute('display');
        }
        return $this->render('@Demande/Default/messengerClient.html.twig', array(
                                                                                        'messages'=>$messages,
                                                                                        'formMessage'=>$form->createView(),
                                                                                        'demande'=> $demande,
                                                                                        ));
    }

    public function exporterCSVAction(){
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        $writer = $this->container->get('egyg33k.csv.writer');
        $csv = $writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['Date','Description','Etat']);
        foreach($demandes as $row){
            //if($row->getEtat() == 'confirmee')
                $csv->insertOne([$row->getDateDemande()->format('Y-m-D'),$row->getDescription(), $row->getEtat()]);
        }
        $csv->output('Demandes.csv');
        die();
    }

    public function renderMapAction($adresse){

        $marker = new Marker(
            new Coordinate(),
            Animation::BOUNCE,
            new Icon(),
            new Symbol(SymbolPath::CIRCLE),
            new MarkerShape(MarkerShapeType::CIRCLE, [1.1, 2.1, 1.4]),
            ['clickable' => false]
        );

        $curl     = new \Ivory\HttpAdapter\CurlHttpAdapter();
        $geocoder = new \Geocoder\Provider\GoogleMaps($curl, "fr", "Tunisia",true, 'AIzaSyA-F4w3LW441-_czP0uzY_YEDktp7-7hnU');
        $request = $geocoder->geocode($adresse);
        $marker->setPosition(new Coordinate($request->first()->getLatitude(), $request->first()->getLongitude()));



        $map = new Map();
        $map->addStylesheetOptions(array('width'=>'100%'));
        $map->getOverlayManager()->addMarker($marker);
        $event = new Event(
            $marker->getVariable(),
            'click',
            'function(){alert("Marker clicked!");}',
            true
        );
        $map->getEventManager()->addDomEventOnce($event);
        return $this->render('@Demande/Default/renderMap.html.twig', array('map'=>$map));
    }

}
