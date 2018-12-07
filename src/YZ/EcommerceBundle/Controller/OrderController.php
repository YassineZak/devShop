<?php

namespace YZ\EcommerceBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\Session;
use YZ\Userbundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use YZ\EcommerceBundle\Entity\Commande;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

class OrderController extends Controller
{
  public function summaryAction(Request $request)
  {
    $session = $request->getSession();
    if (!$session->has('panier') || $session->get('panier') == null) {
    throw new NotFoundHttpException("Cette page n'existe pas.");
    }
    else{
      $panier = $session->get('panier');
    }
    $totalprixTva = array();
    $repository = $this->getDoctrine()
    ->getManager()
    ->getRepository('YZEcommerceBundle:Product');
    $cartProducts = $repository->findByArray(array_keys($panier));
    $sommeTva = $this->container->get('yz_somme_tva');
    $sommeTva = $sommeTva->somme($request, $cartProducts);
    $sommePrix = $this->container->get('yz_somme_prix');
    $sommePrix = $sommePrix->somme($request, $cartProducts);
    $repository = $this->getDoctrine()
    ->getManager()
    ->getRepository('YZUserBundle:User');
    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    return $this->render('YZEcommerceBundle:Ecommerce:orderSummary.html.twig', array('cartProducts' => $cartProducts, 'sommeTva' => $sommeTva, 'sommePrix' => $sommePrix, 'user' => $user));
  }

  public function paymentAction() {
    return $this->render('YZEcommerceBundle:Ecommerce:orderPayment.html.twig');
  }

  public function checkoutAction(Request $request) {
    \Stripe\Stripe::setApiKey("sk_test_IC1U6xRv8IcPpKx3RRJWQstR");

        if ($request->isMethod('POST')) {
          // code...
        $token = $_POST['stripeToken'];
        $session = $request->getSession();
        if (!$session->has('panier') || $session->get('panier') == null) {
        throw new NotFoundHttpException("Cette page n'existe pas.");
        }
        else{
          $panier = $session->get('panier');
        }
        $repository = $this->getDoctrine()
        ->getManager()
        ->getRepository('YZEcommerceBundle:Product');
        $cartProducts = $repository->findByArray(array_keys($panier));
        $sommePrix = $this->container->get('yz_somme_prix');
        $sommePrix = $sommePrix->somme($request, $cartProducts);
        $user = $this->container->get('security.token_storage')->getToken()->getUser()->getNom();
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()
        ->getManager()
        ->getRepository('YZEcommerceBundle:Commande');
        $qteProduct = array();
        $productsName = array();
        $lastCommande = $repository->findLastCommande();
        if ($lastCommande == null) {
          $lastCommande = 0;
        }
        else {
          $lastCommande = $lastCommande[0]['c_reference'];
        }
        foreach ($cartProducts as $cartProduct) {
          array_push($qteProduct, $panier[$cartProduct->getId()]);
        }
        foreach ($cartProducts as $cartProduct) {
          array_push($productsName, $cartProduct->getTitre());
        }
        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $sommePrix*100, // Amount cents
                "currency" => "eur",
                "source" => $token,
                "description" => $user
            ));


            $commande = new commande;
            $commande->setUser($this->container->get('security.token_storage')->getToken()->getUser());
            $commande->setReference($lastCommande + 1);
            $commande->setProducts($cartProducts);
            $commande->setQteProduct(array_combine($productsName,$qteProduct));
            $commande->setValidation(true);
            $commande->setAmount($sommePrix);
            $em->persist($commande);
            $em->flush();
            $this->addFlash("success","Merci pour votre achat");
            $session->remove('panier');
            $lastCommande = $repository->findLastCommande();
            $orderId = $lastCommande[0]['c_id'];

            return $this->redirectToRoute('yz_ecommerce_orderpdf', array('id' => $orderId));
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error", "Une erreur s'est produite");
            return $this->redirectToRoute("yz_ecommerce_ordersummary");
            // The card as been declined
        }
      }
      else {
        return $this->redirectToRoute("yz_ecommerce_homepage");
      }
  }
  public function userOrdersAction($id){
    $repository = $this->getDoctrine()
    ->getManager()
    ->getRepository('YZEcommerceBundle:Commande');
    $userOrder = $repository->findOrderByUser($id);
      return $this->render('YZEcommerceBundle:Ecommerce:userOrders.html.twig', array('userOrders'=>$userOrder));
    }
  public function orderPdfAction($id){
    $repository = $this->getDoctrine()
    ->getManager()
    ->getRepository('YZEcommerceBundle:Commande');
    $order = $repository->findOrder($id);
    $userId = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
    if ($order === null) {
      throw new NotFoundHttpException("Cette page n'existe pas.");
    }
    if ($userId !== $order->getUser()->getId()) {
      throw new NotFoundHttpException("Cette page n'existe pas.");
    }


    return $this->render('YZEcommerceBundle:Ecommerce:orderPdf.html.twig', array('order'=>$order));
    }
    public function pdfAction($id)
{
  $repository = $this->getDoctrine()
  ->getManager()
  ->getRepository('YZEcommerceBundle:Commande');
  $order = $repository->findOrder($id);
  $user = $this->container->get('security.token_storage')->getToken()->getUser();
  $userId = $user->getId();
  if ($order === null) {
    throw new NotFoundHttpException("Cette page n'existe pas.");
  }
  if ($userId !== $order->getUser()->getId()) {
    throw new NotFoundHttpException("Cette page n'existe pas.");
  }
    $html = $this->renderView('YZEcommerceBundle:Ecommerce:pdf.html.twig', array(
        'order'  => $order));
        $userName = $user->getNom();
        $date = date("d_M_Y_");
        $filename = $userName.'_'.$date;
         $snappy = $this->get('knp_snappy.pdf');
        return new Response(
        $snappy->getOutputFromHtml($html),
        200,
        array(
            'Content-Type'          => 'application/pdf',
            'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
        )
    );

}
  }
