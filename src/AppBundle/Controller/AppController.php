<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Information;
use AppBundle\Entity\Inventaire;
use AppBundle\Form\InformationType;
use AppBundle\Form\InventaireType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
class AppController extends Controller
{

    /**
     * @Route("/", name="homepage")
     *
     */
    public function indexAction(Request $request)
    {
        
        //return $this->render('AppBundle:Default:index.html.twig');
        return $this->render('AppBundle:Default:index.html.twig');
    }

    /**
     * @Route("/inventaire/", name="inventaire")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function inventaireAction(){

        return $this->render('AppBundle:Inventaire:inventaire.html.twig');
    }

    /**
     * @Route("/inventaire/create/", name="inventaireCreate")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createInventaireAction(Request $request){

        $security = $this->get('security.token_storage');
        $token = $security->getToken();
        $user = $token->getUser();

        $inventaire=new Inventaire();
        $inventaire->setUser($user);

        $form = $this->createForm(InventaireType::class,$inventaire,array(
            "action" => $this->generateUrl("inventaireCreate"),
        ));

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inventaire);
            $em->flush();
            return $this->redirectToRoute('inventaire');
        }

        return $this->render('AppBundle:Inventaire:createInventaire.html.twig',array(
            'form' => $form->createView()));
    }

    /**
     * @Route("/information/", name="information")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function informationAction(){

        $security = $this->get('security.token_storage');
        $token = $security->getToken();
        $user = $token->getUser();

        $informationRepository=$this->getDoctrine()->getManager()->getRepository('AppBundle:Information');
        $informations=$informationRepository->findByUser($user);

        return $this->render('AppBundle:Information:information.html.twig',array(
                "informations" =>$informations
            ));
    }

    /**
     * @Route("/information/create/", name="informationCreate")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createInformationAction(Request $request){

        $security = $this->get('security.token_storage');
        $token = $security->getToken();
        $user = $token->getUser();

        $information=new Information();
        $information->setUser($user);

        $form = $this->createForm(InformationType::class,$information,array(
            "action" => $this->generateUrl("informationCreate"),
        ));

        $form->handleRequest($request);
        //var_dump($form);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($information);
            $em->flush();
            return $this->redirectToRoute('information');
        }

        return $this->render('AppBundle:Information:createInformation.html.twig',array(
            'form' => $form->createView()));
    }
}

