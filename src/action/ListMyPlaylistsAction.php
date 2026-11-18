<?php

namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;

class ListMyPlaylistsAction extends Action
{
    public function execute(): string
    {
        $repo = DeefyRepository::getInstance();
        $pls = $repo->findAllPlaylists();

        $html = "<h1>Mes playlists</h1><ul>";
        foreach ($pls as $pl) {
            $id = $pl['id'];
            $nom = htmlspecialchars($pl['nom']);
            $html .= "<li><a href='?action=display-playlist&id={$id}'>{$nom}</a></li>";
        }
        $html .= "</ul>";

        return $html;
    }
}
