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
     * @Route("/annonces" , name="annonces")
     */
    public function affProducts(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('GearPlusBundle:Product');
        $allprod = $repository->findAll();


        $new = new Product();
        $form = $this->createForm(ProductType::class, $new);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();


        if ($form->isSubmitted() && $form->isValid()) {
            $res = $form->getData();

            $res_title = '%'.$res->getTitle().'%';
            $res_cat = $res->getCategory();
            $res_prix = $res->getPrix();
            $res_charisme = $res->getCharisme();
            $res_intelligence = $res->getIntelligence();
            $res_beaute = $res->getBeaute();

            $parameters=[];
            
            $query = "SELECT p FROM GearPlusBundle:Product p WHERE p.id <> 0 ";
            if(isset($res_title) && $res_title != ''){
                $query= $query."AND p.title LIKE :title ";
               $parameters['title']=$res_title;
            }
            if (isset($res_cat) && $res_cat != null)
            {
                $query= $query."AND p.category = :cat ";
                $parameters['cat']=$res_cat;
            }
            if(isset($res_charisme))
            {
                $query= $query."AND p.charisme >= :charisme ";
                $parameters['charisme']=$res_charisme;
            }
            if(isset($res_beaute))
            {
                $query= $query."AND p.beaute >= :beaute ";
                $parameters['beaute']=$res_beaute;
            }
            if(isset($res_intelligence))
            {
                $query= $query."AND p.intelligence >= :intelligence ";
                $parameters['intelligence']=$res_intelligence;
            }
            //var_dump($query);
            $sql =  $em->createQuery($query);

            foreach ($parameters as $key => $value){
                $sql->setParameter($key , $value);
            }

            $find = $sql->getResult();
            return $this->render('GearPlusBundle:Default:product.html.twig',['products'=>$find, 'form'=>$form->createView()]);
        }


        return $this->render('GearPlusBundle:Default:product.html.twig',['form' => $form->createView(), 'products'=>$allprod]);
    }
}
