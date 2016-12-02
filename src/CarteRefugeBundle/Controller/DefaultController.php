<?php

namespace CarteRefugeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CarteRefugeBundle:Default:carteRefuge.html.php');
    }
}
