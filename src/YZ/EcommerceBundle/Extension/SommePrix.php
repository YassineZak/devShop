<?php
namespace YZ\EcommerceBundle\Extension;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;


/**
 *
 */
class SommePrix
{

  function somme(Request $request, array $produits ){
    $session = $request->getSession();
    $panier = $session->get('panier');
  $totalPrix = array();
  foreach ($produits as $produit) {
    if ($produit->getPromo() !== null) {
      $prixProduit = (($produit->getPromoTtc()) * $panier[$produit->getId()]);
    }
    else {
      $prixProduit = (($produit->getPrixTtc()) * $panier[$produit->getId()]);
    }
    array_push($totalPrix, $prixProduit);
    }

//  }
  $totalPrix = array_sum($totalPrix);
  return $totalPrix;
  }

}
