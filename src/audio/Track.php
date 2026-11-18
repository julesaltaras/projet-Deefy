<?php

namespace iutnc\deefy\audio;

class Track
{
    public ?int $id = null;
    public string $titre;
    public ?string $genre = null;
    public ?int $duree = null;
    public ?string $filename = null;

    public function __construct(string $titre, ?int $duree = null, ?string $filename = null, ?string $genre = null)
    {
        $this->titre    = $titre;
        $this->duree    = $duree;
        $this->filename = $filename;
        $this->genre    = $genre;
    }
}
