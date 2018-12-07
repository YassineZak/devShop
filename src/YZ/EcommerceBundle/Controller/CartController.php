<?php

namespace YZ\EcommerceBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\Session;

class CartController extends Controller
{
  public function cartAction(Request $request)
  {
    $session = $request->getSession();
    if (!$session->has('panier')) {
    $panier = $session->set('panier', array());
    }
    else{
      $panier = $session->get('panier');
    }
    $totalprixTva = array();
    $cartProducts = array();
    $repository = $this->getDoctrine()
    ->getManager()
    ->getRepository('YZEcommerceBundle:Product');
    if ($panier !== null) {
      $cartProducts = $repository->findByArray(array_keys($panier));
    }
    else {
      $cartProducts == 0;
    }
    $sommeTva = $this->container->get('yz_somme_tva');
    $sommeTva = $sommeTva->somme($request, $cartProducts);
    $sommePrix = $this->container->get('yz_somme_prix');
    $sommePrix = $sommePrix->somme($request, $cartProducts);
    return $this->render('YZEcommerceBundle:Ecommerce:cart.html.twig', array('cartProducts' => $cartProducts, 'sommeTva' => $sommeTva, 'sommePrix' => $sommePrix));
  }

  public function addToCartAction($id, Request $request){
    $getRequest = Request::createFromGlobals();
    $session = $request->getSession();
    $get = $request->query->get('qte');
    if ($get == 0) {
      $get = 1;
    }
    if (!$session->has('panier')) {
    $panier = $session->set('panier', array());
    }
    else{
      $panier = $session->get('panier');
    }

    $panier[$id] = $get;

    $session->set('panier', $panier);
    return $this->redirect($this->generateUrl('yz_ecommerce_cartpage'));
  }
  public function removeCartAction($id, Request $request){
    $session = $request->getSession();
    $panier = $session->get('panier');
    if (isset($panier[$id])) {
      unset($panier[$id]);
      $session->set('panier', $panier);
    }
    return $this->redirect($this->generateUrl('yz_ecommerce_cartpage'));
  }


}
