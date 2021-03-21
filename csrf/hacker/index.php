<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/helpers/Mysql.php";
require_once __DIR__ . "/helpers/Tooling.php";
require_once __DIR__ . "/helpers/Views.php";


$app = new Leaf\App;
$app->blade;
$blade = new Leaf\Blade();

$blade->configure("views", "views/cache");

$app->get("/", function() use($app, $blade) {
  echo $blade->make('login')->render();
});

$app->run();
