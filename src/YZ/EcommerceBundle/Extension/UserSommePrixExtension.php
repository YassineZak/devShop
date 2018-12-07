<?php
namespace YZ\EcommerceBundle\Extension;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RequestStack;
use YZ\EcommerceBundle\Extension\sommePrix as SommePrix;
use Doctrine\ORM\EntityManager;

class UserSommePrixExtension extends \Twig_Extension
{
/**
 * @var EntityManager
 */
private $entityManager;

protected $requestStack;

/**
 * @param UserProfileDataService $userProfileDataService
 */
public function __construct(EntityManager $entityManager, RequestStack $requestStack, SommePrix $sommePrix )
{
    $this->entityManager = $entityManager;
    $this->requestStack = $requestStack;
    $this->sommePrix = $sommePrix;
}

/**
 * @return array
 */
public function getFunctions()
{
    return array(
        new \Twig_SimpleFunction('get_somme_prix', array($this, 'getMySommePrix')),
    );
}

/**
 * @return array
 */
public function getMySommePrix()
{
    $request = $this->requestStack->getCurrentRequest();
    $session = $request->getSession();
    if (!$session->has('panier')) {
      $sommePrix = 0;
    }
    else{
      $panier = $session->get('panier');
      $cartProducts = $this->entityManager->getRepository('YZEcommerceBundle:Product')->findByArray(array_keys($panier));
      $sommePrix = $this->sommePrix->somme($request, $cartProducts);
    }

    return $sommePrix;
}

/**
 * Returns the name of the extension.
 *
 * @return string The extension name
 */
public function getName()
{
    return 'user_somme_prix';
}
}
