<?php
session_start();

require_once __DIR__ . '/../src/autoload/Autoloader.php';

$loader = new \deefy\autoload\Autoloader('iutnc\\deefy\\', __DIR__ . '/../src');
$loader->register();

// config BD
\iutnc\deefy\repository\DeefyRepository::setConfig(__DIR__ . '/../config/deefy.db.ini');

// dispatcher
$d = new \iutnc\deefy\dispatch\Dispatcher();
$d->run();
