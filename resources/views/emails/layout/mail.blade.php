<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('title')
</head>
    <body>
        <main class="container">
            @yield('content')
        </main>
        <footer class="footer">Copyright &copy;Koli&co @php date('Y') @endphp</footer>
    </body>
</html>
