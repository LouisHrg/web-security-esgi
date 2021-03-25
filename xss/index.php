<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/helpers/Mysql.php";
require_once __DIR__ . "/helpers/Tooling.php";
require_once __DIR__ . "/helpers/Views.php";


$app = new Leaf\App;
$app->blade;
$blade = new Leaf\Blade();
$blade->configure("views", "views/cache");

$app->get("/", function() use($app) {

  $title = isset($_GET['title']) ? $_GET['title'] : 'My title';
  $content = isset($_GET['content']) ? $_GET['content'] : 'My content';


  // htmlspecialchars permet de transformer les caractères spéciaux en entités HTML
  $app->response()->markup('Title : '.htmlspecialchars($title).'<br> The content : '.htmlspecialchars($content));
});


$app->get("/blog", function() use($app, $blade) {

  $mysql = new Mysql;
  $articles = $mysql->select('articles', '*');

  echo $blade->make('index', compact('articles'))->render();

});

$app->post("/blog", function() use($app) {


  $title = $_POST['title'];
  $content = $_POST['content'];
  $author = $_POST['author'];

  $mysql = new Mysql;

  $mysql->insert('articles', [
    'title' => htmlspecialchars($title),
    'content' => htmlspecialchars($content),
    'author' => htmlspecialchars($author),
  ]);

  return $app->response()->redirect("/blog");
});


$app->get("/boot", function() use($app) {

  $mysql = new Mysql;

  $mysql->boot();

  $mysql->insert('articles', [
    'title' => 'Mon titre',
    'content' => "Mon super contenu",
    'author' => "Admin",
  ]);

  $mysql->insert('articles', [
    'title' => 'Mon titre 2',
    'content' => "Mon super contenu 2",
    'author' => "Admin",
  ]);

  $mysql->insert('articles', [
    'title' => 'Mon titre 3',
    'content' => "Mon super contenu 3",
    'author' => "Admin",
  ]);

  $app->response()->markup('Database crée avec succès');

});

$app->run();
