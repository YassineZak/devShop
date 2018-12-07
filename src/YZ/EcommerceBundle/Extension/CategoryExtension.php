<?php
namespace YZ\EcommerceBundle\Extension;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager;

class CategoryExtension extends \Twig_Extension
{
/**
 * @var EntityManager
 */
private $entityManager;


public function __construct(EntityManager $entityManager )
{
    $this->entityManager = $entityManager;
}

/**
 * @return array
 */
public function getFunctions()
{
    return array(
        new \Twig_SimpleFunction('get_categories', array($this, 'getCategories')),
    );
}

/**
 * @return array
 */
public function getCategories()
{
      $categories = $this->entityManager->getRepository('YZEcommerceBundle:Category')->findAll();

    return $categories;
}

/**
 * Returns the name of the extension.
 *
 * @return string The extension name
 */
public function getName()
{
    return 'get_categories';
}
}
