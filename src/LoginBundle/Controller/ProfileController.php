<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 07/02/2020
 * Time: 21:55
 */

namespace LoginBundle\Controller;

use ECommerceBundle\Entity\Cart;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\HttpFoundation\Request;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class ProfileController extends BaseController
{
    public function __construct()
    {
    }

    /**
     * Show the user.
     */
    public function showAction()
    {
        $cart='';
        if ($this->getUser())
            $cart = $this->getDoctrine()->getRepository(Cart::class)->Cart_user_id($this->getUser()->getId());

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $trophets = $this->getDoctrine()->getRepository('EventBundle:Trophet')->findAll();
        $events = $this->getDoctrine()->getRepository('EventBundle:Evenement')->findByUser($user->getId());
        return $this->render('@FOSUser/Profile/show.html.twig',compact("user","trophets","events",'cart'));
    }

    public function trophetsAction(){
        $cart='';
        if ($this->getUser())
            $cart = $this->getDoctrine()->getRepository(Cart::class)->Cart_user_id($this->getUser()->getId());

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $trophets = $this->getDoctrine()->getRepository('EventBundle:Trophet')->findAll();
        $events = $this->getDoctrine()->getRepository('EventBundle:Evenement')->findByUser($user->getId());
        return $this->render('@Login/profile/trophet.html.twig',compact("user","trophets","events",'cart'));
    }

    public function informationsAction(){
        $cart='';
        if ($this->getUser())
            $cart = $this->getDoctrine()->getRepository(Cart::class)->Cart_user_id($this->getUser()->getId());

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $trophets = $this->getDoctrine()->getRepository('EventBundle:Trophet')->findAll();
        $events = $this->getDoctrine()->getRepository('EventBundle:Evenement')->findByUser($user->getId());
        return $this->render('@Login/profile/information.html.twig',compact("user","trophets","events",'cart'));
    }
}