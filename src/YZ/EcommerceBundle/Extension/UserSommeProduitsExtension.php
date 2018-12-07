<?php
namespace YZ\EcommerceBundle\Extension;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RequestStack;
use YZ\EcommerceBundle\Extension\sommeProduits as SommeProduits;
use Doctrine\ORM\EntityManager;

class UserSommeProduitsExtension extends \Twig_Extension
{
/**
 * @var EntityManager
 */
private $entityManager;

protected $requestStack;

/**
 * @param UserProfileDataService $userProfileDataService
 */
public function __construct(EntityManager $entityManager, RequestStack $requestStack, SommeProduits $sommeProduits )
{
    $this->entityManager = $entityManager;
    $this->requestStack = $requestStack;
    $this->sommeProduits = $sommeProduits;
}

/**
 * @return array
 */
public function getFunctions()
{
    return array(
        new \Twig_SimpleFunction('get_somme_produit', array($this, 'getMySommeProduits')),
    );
}

/**
 * @return array
 */
public function getMySommeProduits()
{
    $request = $this->requestStack->getCurrentRequest();
    $session = $request->getSession();
    if (!$session->has('panier')) {
      $sommeProduits = 0;
    }
    else{
      $panier = $session->get('panier');
      $cartProducts = $this->entityManager->getRepository('YZEcommerceBundle:Product')->findByArray(array_keys($panier));
      $sommeProduits = $this->sommeProduits->somme($request, $cartProducts);
    }

    return $sommeProduits;
}

/**
 * Returns the name of the extension.
 *
 * @return string The extension name
 */
public function getName()
{
    return 'user_somme_produit';
}
}
