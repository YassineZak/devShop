<?php

namespace YZ\EcommerceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use YZ\EcommerceBundle\Entity\Product;
use YZ\EcommerceBundle\Entity\Tva;
use YZ\EcommerceBundle\Entity\Category;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class LoadProduct implements FixtureInterface
{

    private $em;
    public function load(ObjectManager $manager)
    {
        $titre = 'the witcher';
        $resume= 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.';
        $description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
        $price = 15;
        $reference = 'ref0254';
        $categorie = New Category();
        $imageProduit = '5c0bf50bc27be121664383.jpg';
        $prixTva = 189;
        $repository = $manager
            ->getRepository('YZEcommerceBundle:Tva');
        $tva= $repository->find(1);
        $repository = $manager
            ->getRepository('YZEcommerceBundle:Category');
        $category= $repository->find(1);
        $product = new Product();
        $product->setTitre($titre);
        $product->setResume($resume);
        $product->setDescription($description);
        $product->setPrix($price);
        $product->setReference($product);

        $product->setCategory($category);
        $product->setTva($tva);
        $product->setPrixTva($prixTva);

        $manager->persist($product);



        $manager->flush();
    }

}