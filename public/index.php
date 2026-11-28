<?php
// Ce fichier est le point d entree public ou une ressource PHP.

require dirname(__DIR__) . '/config/app.php';
require dirname(__DIR__) . '/app/Core/Controller.php';
require dirname(__DIR__) . '/app/Core/Database.php';
require dirname(__DIR__) . '/app/Models/JobHuntData.php';
require dirname(__DIR__) . '/app/Controllers/PageController.php';

use App\Controllers\PageController;

$page = $_GET['page'] ?? 'home';
$controller = new PageController();
$controller->handle($page);
