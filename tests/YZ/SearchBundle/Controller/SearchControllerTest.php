<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 07/01/19
 * Time: 18:06
 */

namespace Tests\YZ\SearchBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchControllerTest extends WebTestCase
{
    public function testSearchPage(){
        $client = static::createClient();
        $client->request('GET', '/search');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

}