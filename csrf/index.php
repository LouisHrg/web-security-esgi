<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/helpers/Mysql.php";
require_once __DIR__ . "/helpers/Tooling.php";
require_once __DIR__ . "/helpers/Views.php";


$app = new Leaf\App;
$app->blade;
$blade = new Leaf\Blade();

use Leaf\Auth;

$blade->configure("views", "views/cache");

$app->get("/", function() use($app, $blade) {
  echo $blade->make('login')->render();
});

$app->get('/logout', function() use ($app) {

  foreach($_COOKIE as $cookie_name => $cookie_value){
      unset($_COOKIE[$cookie_name]);
      setcookie($cookie_name, '', time() - 4200, '/');
   }

   return $app->response()->redirect("/");
});

$app->post("/login", function() use($app, $blade) {

  $email = $app->request()->get('email');
  $password = $app->request()->get('password');

  $mysql = new Mysql;
  $result = $mysql->select('users', '*', ['email' => $email]);

  if(isset($result[0]))
  {
    if($result[0]['password'] === $password){
      setcookie('auth', true);
      setcookie('email', $email);
      setcookie('name', $result[0]['name']);
      setcookie('id', $result[0]['id']);

      return $app->response()->redirect("/vote");
    }
  }

  return $app->response()->redirect("/");
});

$app->get("/vote", function() use($app, $blade) {

  if(!$_COOKIE['auth']){
    return $app->response()->redirect("/");
  }

  session_start();

  // On créer un token
  $token = md5(uniqid());

  // ... qu'on ajoute dans la session
  // la session est uniquement lisible côté serveur
  $_SESSION['token'] = $token;

  $mysql = new Mysql;
  $polls = $mysql->select('polls', '*');
  $user = $_COOKIE['name'];

  // on envoie le token dans la page pour l'afficher dans le formulaire
  echo $blade->make('vote', [
    'polls' => $polls,
    'user' => $user,
    'token' => $token,
  ])->render();
});

$app->post("/vote", function() use($app, $blade) {

  if(!$_COOKIE['auth']){
    return $app->response()->redirect("/");
  }


  $toVote = $app->request()->get('user');

  // On recupère le token envoyé dans le formulaire
  $token = $app->request()->get('token');

  session_start();

  // On verifie que le token du formulaire correspond bien au token stocké en session
  if($_SESSION['token'] !== $token)
  {
    return $app->response()->redirect("/");
  }

  $mysql = new Mysql;
  $mysql->insert('polls', ['name' => $toVote]);

  return $app->response()->redirect("/vote");
});

$app->get("/boot", function() use($app) {

  $mysql = new Mysql;

  $mysql->boot();

  $mysql = new Mysql;

  $mysql->insert('users', [
    'name' => 'Admin Admin',
    'password' => 'toto',
    'email' => 'admin@gmail.com',
  ]);

  $mysql->insert('users', [
    'name' => 'John doe',
    'password' => 'toto',
    'email' => 'john@gmail.com',
  ]);

  $mysql->insert('users', [
    'name' => 'Jane Doe',
    'password' => 'toto',
    'email' => 'jane@gmail.com',
  ]);

  $mysql->insert('polls', ['name' => 'John doe']);
  $mysql->insert('polls', ['name' => 'Jane Doe']);

  $app->response()->markup('Database crée avec succès');

});

$app->run();
