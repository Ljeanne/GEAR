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
    public function indexAction()
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
            $ok = $form->getData();
            $tit = '%'.$ok->getTitle().'%';
//            var_dump($tit);
            $query = $em->createQuery("SELECT p FROM GearPlusBundle:Product p WHERE p.title LIKE :title"
            )->setParameter('title', $tit);
            $find = $query->getResult();
            return $this->render('GearPlusBundle:Default:index.html.twig',['allprod'=>$find]);
        }

        return $this->render('GearPlusBundle:Default:succes.html.twig',['nouveauPost' => $form->createView()]);
    }
}
