<?php
namespace YZ\EcommerceBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use YZ\EcommerceBundle\Entity\Product;
use YZ\EcommerceBundle\Entity\Category;
use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadCategory implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

            $names = array('jeux videos');
            $category = new Category();
              foreach($names as $name){

                  $category->setName($name);
                  $manager->persist($category);
                }

        $manager->flush();
    }

}