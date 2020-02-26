<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function displayAction(){
        return $this->render("@Test/Default/index.html");
    }
}
