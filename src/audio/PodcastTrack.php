<?php

namespace iutnc\deefy\audio;

class PodcastTrack extends Track
{
    public ?string $auteur = null;
    public ?string $datePodcast = null;

    public function __construct(string $titre, ?string $filename, ?string $auteur, ?string $datePodcast, ?int $duree, ?string $genre)
    {
        parent::__construct($titre, $duree, $filename, $genre);
        $this->auteur = $auteur;
        $this->datePodcast = $datePodcast;
    }
}
