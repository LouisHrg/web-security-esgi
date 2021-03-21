<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>
    <div>
        <h1>Tous mes articles</h1>
        <ul>
          @if($articles != null)
            @foreach($articles as $article)
            <li>
              <?php echo $article['title'] ?>
              <?php echo $article['content'] ?>
              <?php echo $article['author'] ?>
            </li>
            @endforeach
          @endif
        </ul>
            <form method="POST" action="http://localhost:9999/blog">
                <br>
                <p> Contenu </p>
                <textarea placeholder="contenu" name="content"></textarea><br>
                <p> Titre </p>
                <input placeholder="title" type="text" name="title"><br>
                <p> Auteur </p>
                <input placeholder="author" type="text" name="author"><br>
                <button type="submit"> Valider </button>
            </form>
    </div>
</body>

</html>
