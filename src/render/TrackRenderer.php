<?php

namespace iutnc\deefy\render;

use iutnc\deefy\audio\Track;

class TrackRenderer
{
    private Track $track;

    public function __construct(Track $t)
    {
        $this->track = $t;
    }

    public function render(): string
    {
        $t = htmlspecialchars($this->track->titre);
        $g = $this->track->genre ? " (" . htmlspecialchars($this->track->genre) . ")" : "";
        $d = $this->track->duree ? " - {$this->track->duree}s" : "";
        return "<li>{$t}{$g}{$d}</li>";
    }
}
