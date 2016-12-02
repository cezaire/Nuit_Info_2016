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

        $informationRepository=$this->getDoctrine()->getManager()->getRepository('AppBundle:Information');
        $informations=$informationRepository->findAll();
        
        return $this->render('AppBundle:Default:index.html.twig',array(
            "informations" => $informations
        ));
    }

    /**
     * @Route("/inventaire/", name="inventaire")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function inventaireAction(){

        $security = $this->get('security.token_storage');
        $token = $security->getToken();
        $user = $token->getUser();

        $inventaireRepository=$this->getDoctrine()->getManager()->getRepository('AppBundle:Inventaire');
        $inventaires=$inventaireRepository->findByUser($user);

        return $this->render('AppBundle:Inventaire:inventaire.html.twig',array(
            "inventaires" => $inventaires
        ));
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
     * @Route("/inventaire/edit/{id}", name="inventaireEdit")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editInventaireAction($id,Request $request){
        $InventaireRepository=$this->getDoctrine()->getManager()->getRepository('AppBundle:Inventaire');
        $inventaire=$InventaireRepository->find($id);


        $form = $this->createForm(InventaireType::class,$inventaire,array(
            "action" => $this->generateUrl("inventaireEdit", array('id' =>$id)),
        ));

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($inventaire);
            $em->flush();
            return $this->redirectToRoute('inventaire');
        }

        return $this->render('AppBundle:Inventaire:editInventaire.html.twig',array(
            'form' => $form->createView()));

    }


    /**
     * @Route("/inventaire/delete/{id}", name="inventaireDelele")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteInventaireAction(){

    }

    /**
     * @Route("/inventaire/details/{id}", name="inventaireDetails")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function detailsInventaireAction(){

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

    /**
     * @Route("/information/util/{id}", name="informationUtile")
     */
    public function jaimeAction(Request $request){

       // $informationRepository=$this->getDoctrine()->getManager()->getRepository('AppBundle:Information');
        //$information=$informationRepository->findById($id);

        //$res=$information->getUtile()+1;
        //$information->setUtile($res);


        //$em = $this->getDoctrine()->getManager();
        //$em->flush;
     //   $informations=$informationRepository->findAll();

        return $this->render('AppBundle:Default:index.html.twig'
            //,array(
         //   "informations" => $informations
      //  )
    );
    }
}

