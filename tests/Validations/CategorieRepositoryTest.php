<?php

namespace App\tests\Validations;

use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategorieRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->em = static::getContainer()->get(EntityManagerInterface::class);
    }

    public function testAddAndRemoveCategorie(): void
    {
        $categorie = new Categorie();
        $categorie->setName('Categorie Test');
        $this->em->persist($categorie);
        $this->em->flush();
        $this->assertNotNull($categorie->getId());
        $id = $categorie->getId();
        $this->em->remove($categorie);
        $this->em->flush();
        $this->assertNull($this->em->getRepository(Categorie::class)->find($id));
    }
}