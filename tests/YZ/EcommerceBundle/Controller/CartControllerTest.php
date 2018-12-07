<?php

namespace tests\YZ\Ecommercebundle\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class CartControllerTest extends WebTestCase
{
    public function testCartPage(){

        $client = static::createClient();
        $crawler = $client->request('GET', '/cart');
        $this->assertSame(1, $crawler->filter('html:contains("Panier d\'achat")')->count());

    }

    public function testAddToCartPage(){

        $client = static::createClient();
        $client->request('GET', '/cart/5');
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('html:contains("The Witcher 3 ps4")')->count());

    }
    public function testDeletefromCartPage(){

        $client = static::createClient();
        $client->request('GET', '/cart/remove/5');
        $crawler = $client->followRedirect();
        $this->assertSame(0, $crawler->filter('html:contains("The Witcher 3 ps4")')->count());
    }

}