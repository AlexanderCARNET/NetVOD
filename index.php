<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/classes/dispatch/Dispatcher.php';

use iutnc\netvod\repository\Repository;
use iutnc\netvod\dispatch\Dispatcher;

try {
    Repository::setConfig(__DIR__ . '/Config.db.ini');
    $repo = Repository::getInstance();
    $pdo = $repo->getPDO();

    $dispatcher = new Dispatcher();
    $dispatcher->run();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
