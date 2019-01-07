<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 07/01/19
 * Time: 17:56
 */

namespace Tests\YZ\ContactFormBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class ContactControllerTest extends WebTestCase
{
    public function testContactPage(){
        $client = static::createClient();
        $client->request('GET', '/contact');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

}