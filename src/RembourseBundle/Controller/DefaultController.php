<?php

namespace RembourseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RembourseBundle:Default:rembourse.html.twig');
    }
}
