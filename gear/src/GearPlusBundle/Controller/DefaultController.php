<?php

namespace GearPlusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GearPlusBundle\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use GearPlusBundle\Entity\Product;

class DefaultController extends Controller
{
    /**
     * @Route("/annonces")
     */
    public function affProducts()
    {
        $repository = $this->getDoctrine()->getRepository('GearPlusBundle:Product');
        $allprod = $repository->findAll();

        return $this->render('GearPlusBundle:Default:index.html.twig',['allprod'=>$allprod]);
    }

    /**
     * @Route("/recherche")
     */
    public function search(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('GearPlusBundle:Product');

        $new = new Product();
        $form = $this->createForm(ProductType::class, $new);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();


        if ($form->isSubmitted() && $form->isValid()) {
            $res = $form->getData();

//            Gestion du titre
            $res_title = '%'.$res->getTitle().'%';
            $res_cat = $res->getCategory();
            $res_prix = $res->getPrix();
            $res_charisme = $res->getCharisme();
            $res_intelligence = $res->getIntelligence();
            $res_beaute = $res->getBeaute();

            if(isset($res_cat)){
                $query = $em->createQuery("SELECT p FROM GearPlusBundle:Product p WHERE p.title LIKE :title AND p.category = :cat"
                )->setParameter('title', $res_title)->setParameter('cat',$res_cat);
            }
            else{
                $query = $em->createQuery("SELECT p FROM GearPlusBundle:Product p WHERE p.title LIKE :title"
                )->setParameter('title', $res_title);
            }

            $find = $query->getResult();
            return $this->render('GearPlusBundle:Default:index.html.twig',['allprod'=>$find]);
        }

        return $this->render('GearPlusBundle:Default:succes.html.twig',['nouveauPost' => $form->createView()]);
    }
}
