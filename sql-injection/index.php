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

    // En tant normal sur PHP, utilisez PDO !

    $sql = "SELECT id FROM users WHERE email = ?";

    if ($stmt = mysqli_prepare($mysql->conn, $sql)) {


        // addslashes permet d'enlever les quotes d'une chaine de caractère
        mysqli_stmt_bind_param($stmt, "s", addslashes($email));

        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $userId);

        mysqli_stmt_fetch($stmt);

        // On a récupéré l'id de l'utilisateur de manière sécurisée
        // on peut faire d'autres traitements par la suite
        dd($userId);

        mysqli_stmt_close($stmt);
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
