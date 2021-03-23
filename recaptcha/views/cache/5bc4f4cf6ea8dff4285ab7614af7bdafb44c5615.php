<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>
    <div>
        <form method="POST" id="demo-form" action="/save">
            <input type="text" name="firstname" placeholder="Your firstname" autocomplete="off">
            <div class="g-recaptcha" data-sitekey="<?php echo e($token); ?>"></div>
            <button type="submit"> Valider </button>
        </form>
    </div>
</body>

</html>
<?php /**PATH /home/app/views/index.blade.php ENDPATH**/ ?>