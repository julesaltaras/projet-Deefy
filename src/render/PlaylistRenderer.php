<?php

namespace iutnc\deefy\render;

use iutnc\deefy\audio\Playlist;

class PlaylistRenderer
{
    private Playlist $pl;

    public function __construct(Playlist $p)
    {
        $this->pl = $p;
    }

    public function render(): string
    {
        $html = "<h1>" . htmlspecialchars($this->pl->nom) . "</h1>";
        if (empty($this->pl->tracks)) {
            return $html . "<p>Aucune piste.</p>";
        }
        $html .= "<ul>";
        foreach ($this->pl->tracks as $t) {
            $html .= (new TrackRenderer($t))->render();
        }
        $html .= "</ul>";
        return $html;
    }
}
