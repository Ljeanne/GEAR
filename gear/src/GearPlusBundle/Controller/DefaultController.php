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
    public function affProducts(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('GearPlusBundle:Product');
        $allprod = $repository->findAll();

//        return $this->render('GearPlusBundle:Default:index.html.twig',['allprod'=>$allprod]);
//    }
//
//    /**
//     * @Route("/recherche")
//     */
//    public function search(Request $request)
//    {
//        $repository = $this->getDoctrine()->getRepository('GearPlusBundle:Product');

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

            $query = "SELECT p FROM GearPlusBundle:Product p WHERE p.id <> 0 ";
            $parameters =array(
                'title' => null,
                'cat' => null,
                'beaute' => null,
                'intelligeance' => null,
            );
            if(isset($res_title)){
                $query= $query."AND p.title LIKE :title ";
                $parameters['title'] = $res_title;

            }
            if (isset($res_cat))
            {
                $query= $query."AND p.category = :cat ";
                $parameters['cat'] = $res_cat;
            }
            if(isset($res_charisme))
            {
                $query= $query."AND p.charisme >= :charisme ";
                $parameters['charisme'] = $res_charisme;
            }
            if(isset($res_beaute))
            {
                $query= $query."AND p.beaute >= :beaute ";
                $parameters['beaute'] = $res_beaute;
            }
            if(isset($res_intelligence))
            {
                $query= $query."AND p.intelligence >= :intelligence ";
                $parameters['intelligeance'] = $res_intelligence;
            }

            $sql =  $em->createQuery($query);
            $sql->setParameter($parameters);
            var_dump($query);
            file_put_contents("log.text",$query);

            $find = $sql->getResult();
            return $this->render('GearPlusBundle:Default:index.html.twig',['allprod'=>$find, 'form'=>$form->createView()]);
        }

        return $this->render('GearPlusBundle:Default:index.html.twig',['form' => $form->createView(), 'allprod'=>$allprod]);
    }
}
