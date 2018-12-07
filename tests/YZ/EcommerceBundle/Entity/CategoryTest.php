<?php


namespace tests\YZ\EcommerceBundle\Entity;
use PHPUnit\Framework\TestCase;
use YZ\EcommerceBundle\Entity\Category;


class CategoryTest extends TestCase
{
    public function testCreationCategory(){
        $category = new Category();
        $category->setName('téleviseur');
        $category->setSlug('televiseur');
        $this->assertSame('téleviseur', $category->getName());
    }


}