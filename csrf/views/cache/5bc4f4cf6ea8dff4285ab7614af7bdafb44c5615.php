<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>
    <div>
        <h1>Tous mes articles</h1>
        <ul>
          <?php if($articles != null): ?>
            <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
              <?php echo $article['title'] ?>
              <?php echo $article['content'] ?>
              <?php echo $article['author'] ?>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
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
<?php /**PATH /home/app/views/index.blade.php ENDPATH**/ ?>