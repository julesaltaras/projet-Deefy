<?php

namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;

class CreatePlaylistAction extends Action
{
    public function execute(): string
    {
        $repo = DeefyRepository::getInstance();

        if ($this->http_method === 'POST') {
            $name = trim($_POST['name'] ?? '');
            if ($name === '') {
                return "<p>Nom de playlist obligatoire.</p>";
            }

            $plId = $repo->createEmptyPlaylist($name);

            $_SESSION['current_playlist_id'] = $plId;

            return "<p>Playlist créée.</p><p><a href='?action=display-playlist&id={$plId}'>Voir la playlist</a></p>";
        }

        return <<<HTML
<h1>Créer playlist</h1>
<form method="post" action="?action=create-playlist">
  <input type="text" name="name" required>
  <button type="submit">Créer</button>
</form>
HTML;
    }
}
