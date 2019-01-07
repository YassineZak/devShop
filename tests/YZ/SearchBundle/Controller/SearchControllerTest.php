<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 07/01/19
 * Time: 18:06
 */

namespace Tests\YZ\SearchBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use YZ\EcommerceBundle\Entity\Product;
use Symfony\Component\HttpFoundation\JsonResponse;


class SearchControllerTest extends WebTestCase
{
    public function testSearchPage(){
        $client = static::createClient();
        $client->request('GET', '/search');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
    public function testJsonResultSearch(){

        $term = 'xbox';
        static::bootKernel();
        $entityManager = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $repository = $entityManager->getRepository('YZEcommerceBundle:Product');
        $searchresult = $repository->findByTerm($term);
        $response = new JsonResponse();
        $response->setData($searchresult);
        dump($response);
        die;
        return $response;
    }

}