<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>
    <div>
        Connecté en tant que <?php echo e($_COOKIE['name']); ?>

        <a href="http://localhost:9999/logout">Se déconnecter</a>
        <h1>Voter pour le président du monde</h1>
            <?php if($polls): ?>
            <ul>
                <?php $__currentLoopData = $polls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $poll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li> <?php echo e($poll['name']); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php endif; ?>
            <form method="POST" action="http://localhost:9999/vote">
                Je rentre mon nom pour voter pour la pétition
                <input type="text" name="user" />
                <button type="submit"> Je vote </button>
            </form>
    </div>
</body>

</html>
<?php /**PATH /home/app/views/vote.blade.php ENDPATH**/ ?>