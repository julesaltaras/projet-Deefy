<?php

namespace iutnc\deefy\dispatch;

use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\ListMyPlaylistsAction;
use iutnc\deefy\action\DisplayPlaylistAction;
use iutnc\deefy\action\CreatePlaylistAction;
use iutnc\deefy\action\AddTrackAction;
use iutnc\deefy\action\ShowCurrentPlaylistAction;

class Dispatcher
{
    private string $action;

    public function __construct()
    {
        $this->action = $_GET['action'] ?? 'default';
    }

    public function run(): void
    {
        switch ($this->action) {
            case 'my-playlists':
                $a = new ListMyPlaylistsAction();
                break;
            case 'display-playlist':
                $a = new DisplayPlaylistAction();
                break;
            case 'create-playlist':
                $a = new CreatePlaylistAction();
                break;
            case 'add-track':
                $a = new AddTrackAction();
                break;
            case 'show-current':
                $a = new ShowCurrentPlaylistAction();
                break;
            default:
                $a = new DefaultAction();
        }

        $content = $a->execute();

        echo <<<HTML
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Deefy</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <nav>
    <a href="?action=default">Accueil</a> |
    <a href="?action=my-playlists">Mes playlists</a> |
    <a href="?action=create-playlist">Créer playlist</a> |
    <a href="?action=show-current">Playlist courante</a>
  </nav>
  <hr>
</header>
{$content}
</body>
</html>
HTML;
    }
}
