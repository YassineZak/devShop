<?php
namespace YZ\EcommerceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use YZ\EcommerceBundle\Entity\Product;
use YZ\EcommerceBundle\Entity\Tva;
use YZ\EcommerceBundle\Entity\Category;

class LoadTva implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

            $names = array('10%');
            $multiplicates = array(20);
            $tva = new Tva();
              foreach($names as $name){

                  $tva->setName($name);
                  $manager->persist($tva);
                }
            foreach($multiplicates as $multiplicate){
                $tva->setMultiplicate($multiplicate);
                $manager->persist($tva);
            }

        $manager->flush();
    }

}