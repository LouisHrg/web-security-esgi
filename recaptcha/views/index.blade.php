<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>
    <div>
        Connecté en tant que {{ $_COOKIE['name'] }}
        <a href="http://localhost:9999/logout">Se déconnecter</a>
        <h1>Voter pour le président du monde</h1>
            @if($polls)
            <ul>
                @foreach($polls as $poll)
                <li> {{ $poll['name'] }}</li>
                @endforeach
            </ul>
            @endif
            <form method="POST" action="http://localhost:9999/vote">
                Je rentre mon nom pour voter pour la pétition
                <input type="text" name="user" />
                <button type="submit"> Je vote </button>
            </form>
    </div>
</body>

</html>
