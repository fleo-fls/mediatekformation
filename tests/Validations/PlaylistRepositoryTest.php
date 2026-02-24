<?php

namespace App\tests\Validations;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PlaylistRepositoryTest extends KernelTestCase
{
    private PlaylistRepository $repo;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->repo = static::getContainer()->get(PlaylistRepository::class);
    }

    public function testFindAllOrderByName(): void
    {
        $playlists = $this->repo->findAllOrderByName('ASC');

        $this->assertIsArray($playlists);
        foreach ($playlists as $p) {
            $this->assertInstanceOf(Playlist::class, $p);
        }
        for ($i = 1; $i < count($playlists); $i++) {
            $previous = $playlists[$i - 1]->getName();
            $current  = $playlists[$i]->getName();
            $this->assertTrue(
            strcasecmp($previous, $current) <= 0,
        );
}
        
    }

    public function testFindByContainValue(): void
    {
        $playlists = $this->repo->findByContainValue('name', 'Java', '');

        $this->assertIsArray($playlists);
        foreach ($playlists as $p) {
            $this->assertInstanceOf(Playlist::class, $p);
        }
    }

    public function testFindAllOrderByNbFormation(): void
    {
        $playlists = $this->repo->findAllOrderByNbFormation('DESC');

        $this->assertIsArray($playlists);
        foreach ($playlists as $p) {
            $this->assertInstanceOf(Playlist::class, $p);
        }
    }
}
