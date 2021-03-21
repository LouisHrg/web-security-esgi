<?php



class Views
{
  public static function blog($articles)
  {
    $html = "<div> <h1>Tous mes articles</h1>";
    $end = "</div>";

    $html .= "<ul>";

    foreach ($articles as $key => $value) {
      $html .= "<li><b>".$value['title'].'</b>:'.
      $value['content'].'écrit par <i>'.$value['author']
      .'</i></li>';
    }

    $form = "<form method='POST' action='http://localhost:9999/blog'/>
    <br>
    <p> Contenu </p>
    <textarea placeholder='contenu' name='content'></textarea><br>
    <p> Titre </p>
    <input placeholder='title' type='text' name='title'/><br>
    <p> Auteur </p>
    <input placeholder='author' type='text' name='author'/><br>
    <button type='submit'> Valider </button>
    </form>";

    return $html.$form.$end;

  }
}
