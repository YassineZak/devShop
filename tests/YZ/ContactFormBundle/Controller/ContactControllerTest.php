<?php


namespace tests\YZ\ContactFormBundle\Controller;


use Goutte\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    public function testContactForm(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');
        $form = $crawler->selectButton('Submit')->form();
        $form['contact[subject]'] = 'test';
        $form['contact[name]'] = 'test';
        $form['contact[email]'] = 'test@hotmail.fr';
        $form['contact[message]'] = 'test';
        $client->submit($form);
        $crawler = $client->followRedirect();

       $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }
}