<?php
namespace App\tests\Validations;
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */
use App\Entity\Formation;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of FormationValidationTest
 *
 * @author jb_mu
 */
class FormationValidationTest extends KernelTestCase{
    private function getEntity(): Formation
    {
        return (new Formation())
            ->setTitle("Formation Test")
            ->setPublishedAt(new DateTime());
    }
    public function testValidDatePast()
    {
        self::bootKernel();
        $validator = self::getContainer()->get('validator');
        $formation = $this->getEntity();
        $datePassee = (new \DateTime())->modify('-1 day');
        $formation->setPublishedAt($datePassee);
        $errors = $validator->validate($formation);
        $this->assertCount(0, $errors, "Une date passée ne devrait pas générer d'erreur.");
    }
}
