<?php

namespace iutnc\deefy\audio;

class Playlist
{
    public ?int $id = null;
    public string $nom;
    /** @var Track[] */
    public array $tracks = [];

    public function __construct(string $nom)
    {
        $this->nom = $nom;
    }

    public function addTrack(Track $t): void
    {
        $this->tracks[] = $t;
    }
}
