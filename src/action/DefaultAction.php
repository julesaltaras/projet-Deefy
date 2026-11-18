<?php

namespace iutnc\deefy\action;

class DefaultAction extends Action
{
    public function execute(): string
    {
        $links = [
            'Mes playlists' => '?action=my-playlists',
            'Afficher playlist courante' => '?action=show-current',
            'Créer une playlist' => '?action=create-playlist',
            'Ajouter une piste' => '?action=add-track'
        ];

        $html = "<h1>Deefy</h1><ul>";
        foreach ($links as $txt => $url) {
            $html .= "<li><a href=\"{$url}\">{$txt}</a></li>";
        }
        $html .= "</ul>";
        return $html;
    }
}
