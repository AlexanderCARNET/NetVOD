<?php



namespace iutnc\netvod\repository;

use iutnc\netvod\video\episode\Episode;
use iutnc\netvod\video\serie\Serie;

use PDO;
use DateTime;

class Repository
{

    static private array $config = [];
    static private ?Repository $instance = null;
    private ?PDO $pdo = null;

    static public function setConfig($file): void
    {
        self::$config = parse_ini_file($file);
    }

    static public function getInstance(): Repository
    {
        if (self::$instance === null) {
            self::$instance = new Repository();
        }
        return self::$instance;
    }

    private function __construct()
    {
        if (!empty(self::$config)) {
            $driver = self::$config['driver'];
            $host = self::$config['host'];
            $database = self::$config['database'];
            $user = self::$config['username'];
            $pass = self::$config['password'];
            $dsn = "$driver:host=$host;dbname=$database";
            try {
                $this->pdo = new PDO($dsn, $user, $pass);
            } catch (\PDOException $e) {
                echo "Erreur PDO : " . $e->getMessage() . "<br>";
            }
        } else {
            echo "Configuration vide<br>";
        }
    }

    public function getPDO(): ?PDO
    {
        return $this->pdo;
    }

    // retourne une série sans ses épisodes à partir de son id pour render au format compact
    public function getSerieById($id_serie): Serie|null
    {
        $stmt = $this->pdo->prepare("SELECT nom_serie, chemin_image, serie_id FROM serie WHERE serie_id = :id_serie");
        $stmt->execute([':id_serie' => $id_serie]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Serie(
                $row['nom_serie'],
                '',0,new DateTime(),
                $row['chemin_image']
                ,$row['serie_id']
            );
        }
        return null;
    }

    //retourne une série avec ses épisodes à partir de son id
    public function getFullSerieById($id_serie): Serie|null{
        $query = "SELECT * FROM serie WHERE serie_id = :id_serie";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id_serie' => $id_serie]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // private int $nbEpisode;
        // private array $liste;
        // private string $cheminImage;
        // private $id;
        if ($row) {
            $titre = $row['nom_serie'];
            $annee = $row['date_sortie'];
            $date_ajout = new DateTime($row['date_ajout']);
    
            $descriptif = $row['resume'];
            $chemin_image = $row['chemin_image'];
            $genre = $this->getLibelleById($id_serie);
            $typePublic = $this->getTypePublicById($id_serie);

            $serie = new Serie(
                $titre,
                $descriptif,
                (int)$annee,
                $date_ajout,
                $chemin_image,
                $id_serie
            );

            $serie->setGenres($genre);
            $serie->setTypePublic($typePublic);


            // Récupérer les épisodes associés à la série
            $episodeQuery = "SELECT *, COUNT(*) as episode_count FROM video WHERE saison_id = :serie_id";
            $episodeStmt = $this->pdo->prepare($episodeQuery);
            $episodeStmt->execute([':serie_id' => $id_serie]);
            $episodes = $episodeStmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($episodes as $epRow) {
                $episode = new Episode(
                    $epRow['video_id'],
                    $epRow['titre'],
                    $epRow['duree'],
                    $epRow['chemin_image']??"",
                    $epRow['fichier']??"",
                    $epRow['num_dans_saison']
                );
                $serie->addEpisode($episode);
            }
    }
    return $serie;
}

// retourne les libelles d'une série en fonction de son id (liste tout les episodes associés)
function getLibelleById($id_libelle): array|null
{
    $stmt = $this->pdo->prepare(
        "SELECT DISTINCT g.lib_genre
        FROM Genre g
        JOIN Video2Genre vg ON g.genre_id = vg.genre_id
        JOIN Video v ON vg.video_id = v.video_id
        JOIN Saison s ON v.saison_id = s.saison_id
        WHERE s.serie_id = :serie_id");
        $stmt->execute([':serie_id' => $id_libelle]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows ? array_column($rows, 'lib_genre') : null;
}

// retourne les types de public d'une série en fonction de son id (liste tout les episodes associés)
function getTypePublicById($serie_id): array|null
{
    $stmt = $this->pdo->prepare(
        "SELECT DISTINCT pc.lib_public
        FROM publicCible pc
        JOIN Video2Public vtp ON pc.public_id = vtp.public_id
        JOIN Video v ON vtp.video_id = v.video_id
        JOIN Saison s ON v.saison_id = s.saison_id
        WHERE s.serie_id = :serie_id");
        $stmt->execute([':serie_id' => $serie_id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows ? array_column($rows, 'lib_public') : null;
    }



    // retourne toutes les séries en format compact à completer pour le catalogue (ordre des filtres?)
    public function getAllSeriesCompact(): array {
        $series = [];
        $query = "SELECT serie_id FROM serie";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $serie = $this->getSerieById($row['serie_id']);
            if ($serie !== null) {
                $series[] = $serie;
            }
        }
        return $series;
    }
}