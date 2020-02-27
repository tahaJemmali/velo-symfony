<?php

namespace MontageBundle\Controller;


use ECommerceBundle\Entity\Cart;
use MontageBundle\Entity\PieceDeRechange;
use MontageBundle\Entity\VeloPerso;
use MontageBundle\Form\PieceDeRechangeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class PieceDeRechangeController extends Controller
{

    public function readAction(){
        $cartn='';
        if ($this->getUser())
            $cartn = $this->getDoctrine()->getRepository(Cart::class)->Cart_user_id($this->getUser()->getId());

        $pieces = $this->getDoctrine()->getRepository(PieceDeRechange::class)->findAll();
        return $this->render('@Montage/Default/read.html.twig', array('pieces' => $pieces,'cart'=>$cartn));

    }




    public function addAction(Request $request)
    {

        $piece = new PieceDeRechange();
        $form = $this->createForm(PieceDeRechangeType::class, $piece);
        $form->add('Ajouter', SubmitType::class);

        $form = $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('photo')->getData();
            $em = $this->getDoctrine()->getManager();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('piece'), $filename);
            $piece->setPhoto($filename);
            $piece->setPrix(50);
            $em->persist($piece);
            $em->flush();
            return $this->redirectToRoute('read');
        }

        return $this->render('@Montage/Default/add.html.twig', array('form' => $form->createView()));
    }



    public function editAction(Request $request, $id)
    {

        $piece = $this->getDoctrine()->getRepository(PieceDeRechange::class)->find($id);
        $form = $this->createForm(PieceDeRechangeType::class, $piece);
        $form->add('Modifier', SubmitType::class);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photo')->getData();
            $em = $this->getDoctrine()->getManager();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('piece'), $filename);
            $piece->setPhoto($filename);
            $en = $this->getDoctrine()->getManager();
            $en->persist($piece);
            $en->flush();
            return $this->redirectToRoute('read');
        }
        return $this->render('@Montage/Default/edit.html.twig', array('form' => $form->createView()));
    }




    public function removeAction(Request $request, $id)
    {

        $piece = $this->getDoctrine()->getRepository(PieceDeRechange::class)->find($id);
        $en = $this->getDoctrine()->getManager();
        $en->remove($piece);
        $en->flush();
        return $this->redirectToRoute('read');

    }

    public function veloPersoAction(){
        $cartn='';
        if ($this->getUser())
            $cartn = $this->getDoctrine()->getRepository(Cart::class)->Cart_user_id($this->getUser()->getId());

        $roues = $this->getDoctrine()->getRepository(PieceDeRechange::class)->findByCategorie('roue');
        $pedales = $this->getDoctrine()->getRepository(PieceDeRechange::class)->findByCategorie('pedal');
        $corps = $this->getDoctrine()->getRepository(PieceDeRechange::class)->findByCategorie('corp');

        $nbC = 0;
        foreach ($corps as $row){
            $nbC++;
        }
      return $this->render('@Montage/Default/veloPerso.html.twig', array('roues'=>$roues, 'pedales'=>$pedales, 'corps'=>$corps, 'nbC'=>$nbC,'cart'=>$cartn));
      //  return $this->render('@Montage/Default/veloPerso1.html.twig', array('roues'=>$roues, 'pedales'=>$pedales, 'corps'=>$corps, 'nbC'=>$nbC));
    }


   /** public function selectCorpAction(Request $request){
        $corp = $request->get('idCorp');
        return new Response(json_encode($corp));
    }
    public function selectRoueAction(Request $request){
        $roue = $request->get('idRoue');
        return new Response(json_encode($roue));
    }
    **/

   // ajax work


    public function ajaxAction(Request $request){
//corp

        $corpnom =  $request->get('corpnom');
        $corpdesc =  $request->get('corpdesc');
        $corpprix =  $request->get('corpprix');
        $corpid =  $request->get('corpid');

        //
        $pedalenom =  $request->get('pedalenom');
        $pedaledesc =  $request->get('pedaledesc');

        $pedaleprix =  $request->get('pedaleprix');
        $pedaleid =  $request->get('pedaleid');

        //roue
        $rouenom =  $request->get('rouenom');

        $rouedesc =  $request->get('rouedesc');

        $roueprix =  $request->get('roueprix');

        $roueid=  $request->get('roueid');


        // creation de l'entité VeloPerso lors de click de la bouton :: creer votre velo

            $veloPerso = new VeloPerso();


            $veloPerso->setCorp($corpid);
            $veloPerso->setPedale($pedaleid);
            $veloPerso->setRoue($roueid);
            // 5 dt pour le tax
            $veloPerso->setPrix($corpprix + $pedaleprix + $roueprix + 5);



            // envoyer le vloPerso au fonction confimerVelo



          /*  $em = $this->getDoctrine()->getManager();
            $em->persist($veloPerso);
            $em->flush(); */

            return  $this->render('@Montage/Default/veloP.html.twig',array('veloPerso'=>$veloPerso , 'corpnom'=>$corpnom


            , 'corpdesc'=>$corpdesc, 'corpprix'=>$corpprix , 'rouenom'=>$rouenom ,'rouedesc'=>$rouedesc , 'roueprix'=>$roueprix


            , 'pedalenom'=>$pedalenom , 'pedaledesc'=>$pedaledesc , 'pedaleprix'=>$pedaleprix)) ;
        }




        public function confirmerVeloAction($corp, $roue, $pedale, $prix){


            $veloPerso = new VeloPerso();
            $veloPerso->setCorp($corp);
            $veloPerso->setPedale($pedale);
            $veloPerso->setRoue($roue);
            $veloPerso->setPrix($prix);


            $em = $this->getDoctrine()->getManager();
            $em->persist($veloPerso);
            $em->flush();
            return $this->redirectToRoute('fos_user_profile_show');
        }


}
