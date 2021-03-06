<?php

namespace GearPlusBundle\Controller;

use GearPlusBundle\Entity\Favoris;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GearPlusBundle\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use GearPlusBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{


    /**
     * @Route("/", name="home")
     */
    // ACCUEIL
    public function accueilObject()
    {
        $entitymanager = $this->getDoctrine()->getManager();
        $elements = $entitymanager->createquery('SELECT p.id FROM GearPlusBundle:Product p')->getResult();
        $length = count($elements);
        $i = 0;
        $tableau = [];
        while ($i < 5) {
            $rand = rand(0, $length - 1);
            $id1 = $elements[$rand];
            $repository = $this->getDoctrine()->getRepository(Product::class);
            $ele1 = $repository->findById($id1['id']);
            array_push($tableau, $ele1);
            $i++;
        }
        return $this->render('GearPlusBundle:Default:index.html.twig', ['tableau' => $tableau]);
    }

    /**
     * @Route("/profileuser", name="profileuser")
     */

    // Profil
    public function userObject()
    {
        $userId = $this->getUser()->getId();
        $allProducts = $this->getDoctrine()->getRepository(Product::class)->findBy(array('user' => $userId));

        $allFav = $this->getDoctrine()->getRepository(Favoris::class)->findBy(array('user' => $userId));
        return $this->render('GearPlusBundle:Default:user.html.twig', ['tout_les_prod' => $allProducts, 'tout_fav' => $allFav]);
    }


    /**
     * @Route("/annonces", name="annonces")
     */
    public function affProducts(Request $request)
    {
        if ($this->getUser()) {

            $repository = $this->getDoctrine()->getRepository('GearPlusBundle:Product');
            $allprod = $repository->findAll();


            $new = new Product();
            $form = $this->createForm(ProductType::class, $new);
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();


            if ($form->isSubmitted() && $form->isValid()) {
                $res = $form->getData();

                $res_title = '%' . $res->getTitle() . '%';
                $res_cat = $res->getCategory();
                $res_prix = $res->getPrix();
                $res_charisme = $res->getCharisme();
                $res_intelligence = $res->getIntelligence();
                $res_beaute = $res->getBeaute();

                $parameters = [];

                $query = "SELECT p FROM GearPlusBundle:Product p WHERE p.id <> 0 ";
                if (isset($res_title) && $res_title != '') {
                    $query = $query . "AND p.title LIKE :title ";
                    $parameters['title'] = $res_title;
                }
                if (isset($res_cat) && $res_cat != null) {
                    $query = $query . "AND p.category = :cat ";
                    $parameters['cat'] = $res_cat;
                }
                if (isset($res_charisme)) {
                    $query = $query . "AND p.charisme >= :charisme ";
                    $parameters['charisme'] = $res_charisme;
                }
                if (isset($res_beaute)) {
                    $query = $query . "AND p.beaute >= :beaute ";
                    $parameters['beaute'] = $res_beaute;
                }
                if (isset($res_intelligence)) {
                    $query = $query . "AND p.intelligence >= :intelligence ";
                    $parameters['intelligence'] = $res_intelligence;
                }
                if (isset($res_prix)) {
                    $query = $query . "AND p.prix <= :prix ";
                    $parameters['prix'] = $res_prix;
                }
                //var_dump($query);
                $sql = $em->createQuery($query);

                foreach ($parameters as $key => $value) {
                    $sql->setParameter($key, $value);
                }

                $find = $sql->getResult();
                return $this->render('GearPlusBundle:Default:search.html.twig', ['products' => $find, 'form' => $form->createView()]);
            }


            return $this->render('GearPlusBundle:Default:search.html.twig', ['form' => $form->createView(), 'products' => $allprod]);
        } else {
            return $this->redirectToRoute('fos_user_registration_register');

        }
    }
}
