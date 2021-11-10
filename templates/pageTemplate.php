<!doctype html>
<html lang="de">
    <head>
        <link href="./bootstrap/bootstrap.css" rel="stylesheet">
        <link href="./CSS/centralLayout.css" rel="stylesheet">
        <?= $templateProperties["header"] ?>
    </head>

    <body class="text-center">
        <?= $templateProperties["script"] ?>

        <!--- angepasst von: https://getbootstrap.com/docs/5.0/examples/sign-in/ --->
        <main class="centralLayout">
            <?= $templateProperties["content"] ?>
            <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
        </main>
    </body>
</html>
