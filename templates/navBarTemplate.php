<!doctype html>

<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">

  <!-- Bootstrap core CSS -->
  <link href="bootstrap/bootstrap.css" rel="stylesheet">
  <link href="./CSS/notifications.css" rel="stylesheet">
  <?= $templateProperties["header"] ?>


</head>

<body>

  <?= $templateProperties["script"] ?>
  <script src="JS/notifications.js"></script>

  <header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="Home">
          <h2 > Planing Poker</h2>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
          aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" data-target="#navbarCollapse">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="Create">Spiel erstellen</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="Join">Spiel beitreten</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="Collection">Meine Spiele</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <div id="notification" class="d-flex justify-content-center pe-none fixed-top d-none">
      <div id="notificationAlert" class="mt-2 alert alert-primary pe-auto align-items-center text-break container" role="alert">
        <div class="row">
          <div class="col-10">
            <span id="notificationText"></span>
          </div>
          <div class="col-2 d-flex justify-content-end align-items-center">
            <button id="notificationClose" class="button btn-sm btn-close" aria-label="Close" type="button"></button>
          </div>
        </div>
        <div class="progress mt-2" style="height: 2px;">
          <div id="notificationProgress" class="progress-bar w100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>
    <?= $templateProperties["content"] ?>
  </main>

  <script src="bootstrap/bootstrap.bundle.js">
  </script>

</html>