<?php

namespace tests\YZ\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class EcommerceControllerTest extends WebTestCase
{
    public function testHomePage(){

        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        echo $client->getResponse()->getContent();
    }

    public function testShopPage(){
        $client = static::createClient();
        $client->request('GET', '/shop/1');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testPromoPage(){
        $client = static::createClient();
        $client->request('GET', '/promo/1');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
    public function testProductPage(){
        $client = static::createClient();
        $client->request('GET', '/product/xbox-one-standard');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

}

