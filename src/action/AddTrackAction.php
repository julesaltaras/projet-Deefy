<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\PodcastTrack;
use iutnc\deefy\repository\DeefyRepository;

class AddTrackAction extends Action
{
    public function execute(): string
    {
        $plId = $_SESSION['current_playlist_id'] ?? null;
        if (!$plId) {
            return "<p>Aucune playlist courante. <a href='?action=my-playlists'>Mes playlists</a></p>";
        }

        if ($this->http_method === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $genre = trim($_POST['genre'] ?? '');
            $auteur = trim($_POST['auteur'] ?? '');
            $duree = filter_input(INPUT_POST, 'duree', FILTER_VALIDATE_INT) ?: null;

            if ($title === '' || $auteur === '') {
                return "<p>Titre et auteur obligatoires.</p>";
            }

            $track = new PodcastTrack($title, null, $auteur, date('Y-m-d'), $duree, $genre);

            $repo = DeefyRepository::getInstance();
            $trackId = $repo->savePodcastTrack($track);
            $repo->addTrackToPlaylist($plId, $trackId);

            return "<p>Piste ajoutée.</p><p><a href='?action=display-playlist&id={$plId}'>Retour à la playlist</a></p>";
        }

        return <<<HTML
<h1>Ajouter une piste</h1>
<form method="post" action="?action=add-track">
  <p><label>Titre : <input type="text" name="title" required></label></p>
  <p><label>Auteur : <input type="text" name="auteur" required></label></p>
  <p><label>Genre : <input type="text" name="genre"></label></p>
  <p><label>Durée (s) : <input type="number" name="duree" min="0"></label></p>
  <button type="submit">Ajouter</button>
</form>
HTML;
    }
}
