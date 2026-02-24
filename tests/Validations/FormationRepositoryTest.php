<?php

namespace App\tests\Validations;

use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Formation;

class FormationRepositoryTest extends KernelTestCase
{
    private function getRepository(): FormationRepository
    {
        self::bootKernel();
        return self::getContainer()->get(FormationRepository::class);
    }

    public function testNbFormations()
    {
        $repository = $this->getRepository();
        $nbFormations = $repository->count([]);
        $this->assertGreaterThan(0, $nbFormations, "La table formation devrait contenir des données.");
    }

    public function testFindByContainValue()
    {
        $repository = $this->getRepository();
        $formations = $repository->findByContainValue('title', 'Eclipse');
        $nbResultats = \count($formations);
        $this->assertNotEmpty($formations);
    }
   
    public function testFindAllForOnePlaylist()
    {
        $repository = $this->getRepository();
        $formations = $repository->findAllForOnePlaylist(1);
        $this->assertIsArray($formations);
        if (count($formations) > 0) {
            $this->assertInstanceOf(Formation::class, $formations[0]);
        }
    }
}