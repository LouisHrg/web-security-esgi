<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/helpers/Mysql.php";
require_once __DIR__ . "/helpers/Tooling.php";
require_once __DIR__ . "/helpers/Views.php";


$app = new Leaf\App;
$app->blade;
$blade = new Leaf\Blade();

$blade->configure("views", "views/cache");

$app->get("/login", function() use($app, $blade) {
  echo $blade->make('login')->render();
});

$app->post("/login", function() use($app, $blade) {

  $email = $_POST['email'] ?? null;
  $password = $_POST['password'] ?? null;

  if($email && $password)
  {
    $mysql = new Mysql;

    $sql = "SELECT * FROM users WHERE email = '".$email."'";

    $result = mysqli_multi_query($mysql->conn, $sql);

    if(!$result) return $result;

    $output = [];

    if ($result = $mysql->conn->store_result()) {
       while($row = mysqli_fetch_assoc($result)) {
          $output[] = $row;
       }
    }

  }

  return $app->response()->redirect("/login");
});


$app->get("/boot", function() use($app) {

  $mysql = new Mysql;

  $mysql->boot();

  $app->response()->markup('Database crée avec succès');

});

$app->run();
