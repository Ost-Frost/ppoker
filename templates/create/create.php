<!--- angepasst von: https://getbootstrap.com/docs/4.3/examples/checkout/ --->
<div class="container">
    <div class="py-5 text-center">
      <h2>Spiel erstellen</h2>
      <p class="lead">Erstellen Sie ein Spiel und laden Ihre Kollegen ein.</p>
    </div>


    <div class="container">
      <form class="needs-validation" method="POST" action="Create">

        <h4 class="mb-3" style="margin-top: 5%;" id="epicHeader">Epic auswählen</h4>
        <div class="list-group" id="epicSelected"></div>
        <div class="row" id="epicSelect">
          <div class="col-md-6 mb-3">
            <div class="form-floating">
              <input type="search" class="form-control" id="sucheEpic" autocomplete="off">
              <label for="sucheEpic">Epic-Name</label>
            </div>
            <div class="list-group" id="suggestionsEpic"></div>
          </div>
          <div class="col-md-6 mb-3 mt-1">
            <button class="btn btn-primary btn-lg btn-block type" type="button" id="btnEpicSelect">Auswählen</button>
            <button class="btn btn-primary btn-lg btn-block type" type="button" id="btnSwitchEpicCreate">Neue Epic Erstellen</button>
          </div>
        </div>

        <div class="row d-none" id="epicCreate" >
          <div class="col-md-8 mb-3">
            <div class="form-floating">
              <input type="text" class="form-control" id="floatingEpicName" name="epicName">
              <label for="floatingEpicName">Epic</label>
            </div>
          </div>
          <div class="col-md-4 mb-3 mt-1">
              <button class="btn btn-primary btn-lg btn-block type" type="button" id="btnSwitchEpicSelect">Bestehende Epic Auswählen</button>
          </div>

          <div class="col-md-12 mb-3">
            <div class="form-floating">
              <textarea class="form-control" id="floatingEpicDescription" style="height: 150px; width: 100%;" name="epicDescription"></textarea>
              <label for="floatingEpicDescription">Beschreibung</label>
            </div>
          </div>
        </div>

        <h4 class="mb-3" style="margin-top: 5%;">User Story erstellen</h4>
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="form-floating">
              <input type="text" class="form-control" id="floatingStory" name="gameTask">
              <label for="floatingStory">Story</label>
            </div>
          </div>

          <div class="col-md-12 mb-3">
            <div class="form-floating">
              <textarea class="form-control" id="floatingDescription" style="height: 150px; width: 100%;" name="gameDescription"></textarea>
              <label for="floatingDescription">Beschreibung</label>
            </div>
          </div>
        </div>

        <h4 class="mb-3" style="margin-top: 5%;">Spieler einladen</h4>
        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="list-group" id="antwort"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="form-floating">
              <input type="search" class="form-control" id="suche" name="userName" autocomplete="off">
              <label for="suche">Benutzername oder Email</label>
            </div>
            <div class="list-group" id="suggestions"></div>
          </div>
          <div class="col-md-6 mb-3 mt-1">
            <button class="btn btn-primary btn-lg btn-block type" type="button" id="inviteBtn">Einladen</button>
          </div>
        </div>
        <button class="btn btn-primary btn-lg btn-block" type="submit">Spiel erstellen</button>
        <div style="height: 300px;">
      </form>

    </div>
  </div>