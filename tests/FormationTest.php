<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Formation;

/**
 * Description of FormationTest
 *
 * @author jb_mu
 */
class FormationTest extends TestCase{
    
    public function testGetPublishedAtString()
    {
        $formation = new Formation();
        $date = new \DateTime("2026-02-22 10:00:00");
        $formation->setPublishedAt($date);
        $result = $formation->getPublishedAtString();
        $this->assertEquals("22/02/2026", $result, "Le formatage de la date est incorrect.");
    }
}