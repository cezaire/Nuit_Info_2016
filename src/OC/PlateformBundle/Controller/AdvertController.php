<?php
/**
 * Created by PhpStorm.
 * User: jzaire
 * Date: 29/11/2016
 * Time: 00:16
 */

namespace OC\PlateformBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdvertController extends Controller{
    public function indexAction(){
        $content = $this
            ->get('templating')
            ->render('OCPlateformBundle:Advert:index.html.twig', array('nom' => 'Jérémy'));
        return new Response($content);
    }

    public function viewAction(){

    }

    public function addAction(){

    }

    public function editAction(){

    }

    public function deleteAction(){

    }
}