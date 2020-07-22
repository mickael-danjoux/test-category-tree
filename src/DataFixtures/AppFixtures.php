<?php

namespace App\DataFixtures;

use App\Entity\CategoryActuality;
use App\Entity\CategoryProduct;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

class AppFixtures extends Fixture
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->createTree();

        $this->em->flush();
    }

    public function createTree(){
        $categoryProduct = new CategoryProduct();
        $categoryProduct->setTitle("Produits");
        $this->em->persist($categoryProduct);

        $catP1 = new CategoryProduct();
        $catP1->init('Cat Produit 1',$categoryProduct);
        $this->em->persist($catP1);

        $catP2 = new CategoryProduct();
        $catP2->init('Cat Produit 2',$categoryProduct);
        $this->em->persist($catP2);


        $categoryActu = new CategoryActuality();
        $categoryActu->setTitle("Actualités");
        $this->em->persist($categoryActu);

        $catA1 = new CategoryActuality();
        $catA1->init('Cat Actu 1',$categoryActu);
        $this->em->persist($catA1);

        $catA2 = new CategoryActuality();
        $catA2->init('Cat Actu 2',$categoryActu);
        $this->em->persist($catA2);

    }
}
