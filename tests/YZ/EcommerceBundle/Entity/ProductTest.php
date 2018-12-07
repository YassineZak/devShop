<?php


namespace tests\YZ\EcommerceBundle\Entity;
use PHPUnit\Framework\TestCase;
use YZ\EcommerceBundle\Entity\Product;
use YZ\EcommerceBundle\Entity\Tva;


class ProductTest Extends TestCase
{
    public function testGettingTvaPriceWithPromo(){
        $tva = new Tva();
        $tva->setMultiplicate(20);
        $product = new Product;
        $product->setTva($tva);
        $product->setPromo(10);
        $product->setPrixTva(2);
        $this->assertSame(2, $product->getPrixTva());
    }
    public function testSettingTvaPriceWithPromo(){
        $tva = new Tva();
        $tva->setMultiplicate(20);
        $product = new Product;
        $product->setTva($tva);
        $product->setPromo(10);
        $product->setPrixTva(2);
        $this->assertTrue(true);
    }
    public function testTvaPriceWithoutPromo(){
        $tva = new Tva();
        $tva->setMultiplicate(20);
        $product = new Product;
        $product->setTva($tva);
        $product->setPrix(10);
        $product->setPrixTva(2);
        $this->assertSame(2, $product->getPrixTva());
    }
    public function testPrixTtc(){
        $tva = new Tva();
        $tva->setMultiplicate(20);
        $product = new Product;
        $product->setTva($tva);
        $product->setPrix(10);
        $product->setPrixTva(2);
        $product->setPrixTtc(12);
        $this->assertSame(12, $product->getPrixTtc());

    }
    public function testPromotc(){
        $tva = new Tva();
        $tva->setMultiplicate(20);
        $product = new Product;
        $product->setTva($tva);
        $product->setPromo(10);
        $product->setPrixTva(2);
        $product->setPromoTtc(12);
        $this->assertSame(12, $product->getPromoTtc());
    }

}