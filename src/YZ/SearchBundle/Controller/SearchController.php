<?php
namespace YZ\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;

class SearchController extends Controller{

  public function searchBarAction(){
    $form = $this->createFormBuilder(null)
    ->add('search', TextType::class)
    ->getForm();
    return $this->render('YZSearchBundle:Search:searchBar.html.twig', array('form' =>$form->createView()));
  }

  /**
  * @param Request $request
  * @Method("GET")
  */
  public function handleSearchAction(Request $request){

    $term = $request->get('form')['search'];
    $repository = $this->getDoctrine()
    ->getManager()
    ->getRepository('YZEcommerceBundle:Product');
    $searchresult = $repository->findByTerm($term);
    return $this->render('YZEcommerceBundle:Ecommerce:shop.html.twig', array('products' => $searchresult));
  }

  /**
  * @param Request $request
  * @Method("GET")
  */
  public function jsonResultSearchAction(Request $request){

    $term = $request->get('form')['search'];
    $repository = $this->getDoctrine()
    ->getManager()
    ->getRepository('YZEcommerceBundle:Product');
    $searchresult = $repository->findByTerm($term);
    $response = new JsonResponse();
    $response->setData($searchresult);
    return $response;
  }



}




 ?>
