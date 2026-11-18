<?php

namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\render\PlaylistRenderer;

class ShowCurrentPlaylistAction extends Action
{
    public function execute(): string
    {
        $plId = $_SESSION['current_playlist_id'] ?? null;
        if (!$plId) {
            return "<p>Aucune playlist courante.</p>";
        }

        $repo = DeefyRepository::getInstance();
        $pl = $repo->findPlaylistById($plId);
        if (is_null($pl)) {
            return "<p>Playlist introuvable.</p>";
        }

        $r = new PlaylistRenderer($pl);
        return $r->render();
    }
}
