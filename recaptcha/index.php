<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/helpers/Tooling.php";


$app = new Leaf\App;
$app->blade;
$blade = new Leaf\Blade();

$blade->configure("views", "views/cache");

$app->get("/", function() use($app, $blade) {
  echo $blade->make('index')->render();
});

$app->post("/save", function() use($app) {
  //
});


$app->run();
