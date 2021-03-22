<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/helpers/Tooling.php";



$app = new Leaf\App;
$blade->configure("views", "views/cache");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app->get("/", function() use($app, $blade) {

  echo $blade->make('index', [
    'token' => $_ENV['V2_SECET']
  ])->render();
});

$app->post("/save", function() use($app, $blade) {

  $recaptcha_response = $app->request()->get('g-recaptcha-response');

  $client = new GuzzleHttp\Client();

  $res = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
      'form_params' => [
        'response' => $recaptcha_response,
        'secret' => $_ENV['BACK_V2_SECRET'],
      ],
  ]);

  $body = json_decode($res->getBody());

  if($body->success){
    return $app->response()->redirect("/human");
  }

  return $app->response()->redirect("/");

});

$app->get("/human", function() use($app, $blade) {

  echo $app->response()->markup('Bravo vous êtes un humain');
});


$app->get("/v3", function() use($app, $blade) {

  echo $blade->make('v3', [
    'token' => $_ENV['V3_SECET']
  ])->render();
});

$app->post("/save-v3", function() use($app, $blade) {

  $recaptcha_response = $app->request()->get('g-recaptcha-response');

  $client = new GuzzleHttp\Client();

  $res = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
      'form_params' => [
        'response' => $recaptcha_response,
        'secret' => $_ENV['BACK_V3_SECRET'],
      ],
  ]);

  $body = json_decode($res->getBody());

  if($body->success){
    return $app->response()->redirect("/human");
  }

  return $app->response()->redirect("/");

});

$app->run();
