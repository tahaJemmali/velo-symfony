<?php

namespace DemandeBundle\Controller;

use DemandeBundle\Entity\Demande;
use DemandeBundle\Entity\Ordre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrdreController extends Controller
{
    public function displayAction(){

        $authChecker=$this->container->get('security.authorization_checker');
        if ($authChecker->isGranted('ROLE_ADMIN')) {

            $ordres = $this->getDoctrine()->getRepository(Ordre::class)->findAll();
            $roles = $this->getUser()->getRoles();
            $role = $roles[0];
            if ($role == 'ROLE_ADMIN') {
            } else {
                $role = "ROLE_USER";
            }
            return $this->render('@Demande/Default/displayOrdre.html.twig', array('ordres'=>$ordres, 'role'=>$role));
        }

        return $this->redirectToRoute('display');
    }

    public function removeAction($id){


        $ordre = $this->getDoctrine()->getRepository(Ordre::class)->find($id);
        $en = $this->getDoctrine()->getManager();
        $en->remove($ordre);
        $en->flush();
        return $this->redirectToRoute('displayOrdre');
    }
}
