<?php

namespace GearPlusBundle\Controller;

use GearPlusBundle\Entity\Favoris;
use GearPlusBundle\Entity\Product;
use GearPlusBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * Product controller.
 *
 * @Route("annonces")
 */
class ProductController extends Controller
{
    /**
     * Check if this user has this product as favoris
     * @param $product_id
     * @return bool
     */
    public function hasFavoris($product_id){

        $userId=$this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $elements=$em->createquery('SELECT DISTINCT f.id FROM GearPlusBundle:Favoris f WHERE f.user=:userid AND f.product=:productid')
            ->setParameter('userid',$userId)
            ->setParameter('productid',$product_id)
            ->getResult();

        if(count($elements)>0){
            return $elements[0]['id'];
        }
        else{
            return false;
        }

    }
    /**
     * @Route("/addFavoris/{userid}/{productid}", name="addFavoris")
     */
    public function addFavoris($productid)
    {
        $em = $this->getDoctrine()->getManager();
        $favoris = new favoris();

        $user = $this->getUser();


        $prodrep = $this->getDoctrine()->getRepository(Product::class);
        $prod= $prodrep->findOneById($productid);

        $favoris -> setUser($user);
        $favoris -> setProduct($prod);


        $em->persist($favoris);
        $em->flush();

        return $this->redirectToRoute('product_show', array('id' => $productid));


    }

    /**
     * @Route("/removeFavoris/{favorisid}", name="removeFavoris")
     * @param $favorisid
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeFavoris($favorisid){
        $repository = $this->getDoctrine()->getRepository(Favoris::class);
        $remove = $repository->findById($favorisid);
        $em = $this->getDoctrine()->getManager();
        $em->remove($remove);
        $em->flush();


        $repository = $this->getDoctrine()->getRepository(Favoris::class);
        $productid = $repository->findOneById($favorisid);
        $productid = $productid->getId();


        return $this->redirectToRoute('product_show', array('id' => $productid));

    }

    /**
     * Lists all product entities.
     *
     * @Route("/", name="product_index")
     * @Method("POST")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('GearPlusBundle:Product')->findAll();

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new product entity.
     *
     * @Route("/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('GearPlusBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush($product);

            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="product_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $fav=$this->hasFavoris($product->getId());
        return $this->render('product/show.html.twig', array(
            'fav'=> $fav,
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {

        $user = $this->getUser();
        $userID = $this->getUser()->getId();
        $product_user_id = $product->getUser()->getId();

        if ($userID == $product_user_id OR $user->hasRole('ROLE_ADMIN') OR  $user->hasRole('ROLE_SUPER_ADMIN'))
        {
            $deleteForm = $this->createDeleteForm($product);
            $editForm = $this->createForm('GearPlusBundle\Form\ProductType', $product);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
            }

            return $this->render('product/edit.html.twig', array(
                'product' => $product,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));

        }
        else
        {
            $request->getSession()
                ->getFlashBag()
                ->add('failure', 'Vous ne pouvez modifier ce produit: Il ne vous appartient pas !!!')
            ;
            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/{id}", name="product_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Product $product)
    {

        $user = $this->getUser();
        $userID = $this->getUser()->getId();
        $product_user_id = $product->getUser()->getId();

        if ($userID == $product_user_id OR $user->hasRole('ROLE_ADMIN') OR  $user->hasRole('ROLE_SUPER_ADMIN'))
        {
            $form = $this->createDeleteForm($product);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($product);
                $em->flush();
            }

            return $this->redirectToRoute('product_index');
        }
        else
        {
            $request->getSession()
                ->getFlashBag()
                ->add('failure', 'Vous ne pouvez supprimer ce produit: Il ne vous appartient pas !!!')
            ;
            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }

    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
