<?php

namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\render\PlaylistRenderer;

class DisplayPlaylistAction extends Action
{
    public function execute(): string
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            return "<p>id manquant</p>";
        }

        $repo = DeefyRepository::getInstance();
        $pl = $repo->findPlaylistById($id);
        if (is_null($pl)) {
            return "<p>Playlist introuvable</p>";
        }

        // on met en session
        $_SESSION['current_playlist_id'] = $id;

        $renderer = new PlaylistRenderer($pl);
        return $renderer->render()
            . "<p><a href='?action=add-track'>Ajouter une piste</a></p>"
            . "<p><a href='?action=my-playlists'>Retour</a></p>";
    }
}
