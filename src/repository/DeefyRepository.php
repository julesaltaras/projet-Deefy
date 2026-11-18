<?php

namespace iutnc\deefy\repository;

use PDO;
use iutnc\deefy\audio\Playlist;
use iutnc\deefy\audio\PodcastTrack;
use iutnc\deefy\audio\Track;

class DeefyRepository
{
    private PDO $pdo;
    private static ?DeefyRepository $instance = null;
    private static array $config = [];

    private function __construct(array $conf)
    {
        $dsn = "{$conf['driver']}:host={$conf['host']};dbname={$conf['database']};charset={$conf['charset']}";
        $this->pdo = new PDO($dsn, $conf['username'], $conf['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public static function setConfig(string $file): void
    {
        $c = parse_ini_file($file);
        if ($c === false) {
            throw new \Exception("config BD introuvable");
        }
        self::$config = $c;
    }

    public static function getInstance(): DeefyRepository
    {
        if (is_null(self::$instance)) {
            self::$instance = new DeefyRepository(self::$config);
        }
        return self::$instance;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /* ======================
       PLAYLISTS
       ====================== */

    public function findAllPlaylists(): array
    {
        $st = $this->pdo->query("SELECT id, nom FROM playlist ORDER BY id");
        return $st->fetchAll();
    }

    public function createEmptyPlaylist(string $name): int
    {
        $st = $this->pdo->prepare("INSERT INTO playlist (nom) VALUES (:n)");
        $st->execute([':n' => $name]);

        return (int) $this->pdo->lastInsertId();
    }

    /* ======================
       PLAYLIST PAR ID
       ====================== */

    public function findPlaylistById(int $id): ?Playlist
    {
        $st = $this->pdo->prepare("SELECT id, nom FROM playlist WHERE id = :id");
        $st->execute([':id' => $id]);
        $row = $st->fetch();
        if (!$row)
            return null;

        $pl = new Playlist($row['nom']);
        $pl->id = (int) $row['id'];

        // pistes
        $sql = "SELECT t.*
                FROM playlist2track p2t
                JOIN track t ON t.id = p2t.id_track
                WHERE p2t.id_pl = :id
                ORDER BY p2t.no_piste_dans_liste";
        $st2 = $this->pdo->prepare($sql);
        $st2->execute([':id' => $id]);

        while ($trow = $st2->fetch()) {
            if ($trow['type'] === 'P') {
                $t = new PodcastTrack(
                    $trow['titre'],
                    $trow['filename'],
                    $trow['auteur_podcast'],
                    $trow['date_posdcast'],
                    $trow['duree'],
                    $trow['genre']
                );
            } else {
                $t = new Track(
                    $trow['titre'],
                    $trow['duree'],
                    $trow['filename'],
                    $trow['genre']
                );
            }
            $t->id = (int) $trow['id'];
            $pl->addTrack($t);
        }

        return $pl;
    }

    /* ======================
       TRACKS
       ====================== */

    public function savePodcastTrack(PodcastTrack $t): int
    {
        $sql = "INSERT INTO track (titre, genre, duree, filename, type, auteur_podcast, date_posdcast)
                VALUES (:titre, :genre, :duree, :filename, 'P', :auteur, :datep)";
        $st = $this->pdo->prepare($sql);
        $st->execute([
            ':titre' => $t->titre,
            ':genre' => $t->genre,
            ':duree' => $t->duree,
            ':filename' => $t->filename,
            ':auteur' => $t->auteur,
            ':datep' => $t->datePodcast,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function addTrackToPlaylist(int $plId, int $trackId): void
    {
        $st = $this->pdo->prepare("SELECT COALESCE(MAX(no_piste_dans_liste),0)+1 AS n
                                   FROM playlist2track WHERE id_pl = :id");
        $st->execute([':id' => $plId]);
        $num = (int) $st->fetch()['n'];

        $ins = $this->pdo->prepare("INSERT INTO playlist2track (id_pl, id_track, no_piste_dans_liste)
                                    VALUES (:pl, :tr, :no)");
        $ins->execute([
            ':pl' => $plId,
            ':tr' => $trackId,
            ':no' => $num
        ]);
    }
}
