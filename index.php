<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/classes/dispatch/Dispatcher.php';

use iutnc\netvod\render\EpisodeRender;
use iutnc\netvod\render\SerieRender;
use iutnc\netvod\repository\Repository;
use iutnc\netvod\dispatch\Dispatcher;
use iutnc\netvod\video\episode\Episode;
use iutnc\netvod\video\serie\Serie;

// try {
//     Repository::setConfig(__DIR__ . '/Config.db.ini');
//     $repo = Repository::getInstance();
//     $pdo = $repo->getPDO();

//     $dispatcher = new Dispatcher();
//     $dispatcher->run();
// } catch (Exception $e) {
//     echo "Erreur : " . $e->getMessage();
// }


$serie = new Serie("Action", "Tous publics", "Ma Série", "Une série passionnante", 2023, 0, "images/ma_serie.jpg");
$episode1 = new Episode(1, "Pilot", 45, "", "","ceci est un resume");
$serie->addEpisode($episode1);
$episode2 = new Episode(2, "Second Episode", 50, "", "", "deci est un autre resume");
$serie->addEpisode($episode2);
$serieRender = new SerieRender($serie);
echo "Série en rendu compact :\n";
echo $serieRender->render(1);
echo "\n\nSérie en rendu long :\n";
echo $serieRender->render(2);
echo "Episode en rendu long :\n";
$episodeRender = new EpisodeRender($episode1);
echo $episodeRender->render(2);