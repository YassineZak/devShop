<?php
namespace YZ\EcommerceBundle\Extension;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;


/**
 *
 */
class SommeProduits
{

  function somme(Request $request, array $produits ){
    $session = $request->getSession();
    $panier = $session->get('panier');
  $totalProduits = array();
  foreach ($produits as $produit) {
      $nombreProduit = $panier[$produit->getId()];
    array_push($totalProduits, $nombreProduit);
    }

//  }
  $totalProduits = array_sum($totalProduits);
  return $totalProduits;
  }

}
