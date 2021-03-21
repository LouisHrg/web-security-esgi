<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/helpers/Mysql.php";
require_once __DIR__ . "/helpers/Tooling.php";

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

      return $app->response()->redirect("/admin");
    }
  }

  return $app->response()->redirect("/");
});

$app->get("/admin", function() use($app, $blade) {

  if(!$_COOKIE['auth']){
    return $app->response()->redirect("/");
  }

  $mysql = new Mysql;
  $user = $_COOKIE['name'];

  echo $blade->make('admin', ['user' => $user])->render();
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

  $app->response()->markup('Database crée avec succès');

});

$app->run();
