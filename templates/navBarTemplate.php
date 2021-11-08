<!doctype html>

<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">

  <!-- Bootstrap core CSS -->
  <link href="bootstrap/bootstrap.css" rel="stylesheet">
  <?= $templateProperties["header"] ?>


</head>

<body>

  <?= $templateProperties["script"] ?>

  <header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <h2>Planing Poker</h2>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
          aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="#">Spiel erstellen</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="#">Spiel beitreten</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="#">Meine Spiele</a>
            </li>
          </ul>
          <a class="justify-content-right"  style="color:grey; text-decoration: none;" href="#">Logout</a>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <?= $templateProperties["content"] ?>
  </main>

  <script src="bootstrap/bootstrap.bundle.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous">
  </script>

</html>