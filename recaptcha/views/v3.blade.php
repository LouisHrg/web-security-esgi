<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
     <script src="https://www.google.com/recaptcha/api.js"></script>

</head>

<body>
    <div>
        <form method="POST" id="demo-form" action="/save-v3">
            <input type="text" name="firstname" placeholder="Your firstname" autocomplete="off">
            <button class="g-recaptcha"
                    data-sitekey="{{ $token }}"
                    data-callback='onSubmit'
                    data-action='submit'>Submit
            </button>
        </form>

    </div>
    <script>
      function onSubmit(token) {
        document.getElementById("demo-form").submit();
      }
    </script>

</body>

</html>
