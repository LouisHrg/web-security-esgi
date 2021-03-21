<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/helpers/Tooling.php";


$app = new Leaf\App;

$app->post("/example", function() use($app) {

  $firstname = $app->request()->get('firstname');
  $lastname = $app->request()->get('lastname');

  if($firstname && $lastname)
  {
    return $app->response()->json(['message' => 'ok !']);
  }

  return $app->response->throwErr('Erreur', 400);

});


$app->run();
