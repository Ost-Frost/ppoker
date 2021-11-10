<!--- angepasst von: https://getbootstrap.com/docs/4.3/examples/checkout/ --->
<div class="container">
    <div class="py-5 text-center">
      <h2>Spiel erstellen</h2>
      <p class="lead">Erstellen Sie ein Spiel und laden Ihre Kollegen ein.</p>
    </div>


    <div class="container">
      <form class="needs-validation">
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="form-floating">
              <input type="text" class="form-control" id="floating-story">
              <label for="floating-story">Story</label>
            </div>
          </div>

          <div class="col-md-12 mb-3">
            <div class="form-floating">
              <textarea class="form-control" id="floating-remark" style="height: 150px; width: 100%;"></textarea>
              <label for="floating-remark">Beschreibung</label>
            </div>
          </div>
        </div>

        <h4 class="mb-3" style="margin-top: 5%;">Spieler einladen</h4>
        <ul class="list-group" id="antwort"></ul>
        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="form-floating">
              <input type="search" class="form-control" id="suche" name="userName" autocomplete="off">
              <label for="suche">Benutzername oder Email</label>
            </div>
            <div class="list-group" id="suggestions"></div>
          </div>
          <div class="col-md-6 mb-3 mt-1">
            <button class="btn btn-primary btn-lg btn-block type" type="button">Einladen</button>
          </div>
        </div>
        <button class="btn btn-primary btn-lg btn-block" type="submit">Spiel erstellen</button>
        <div style="height: 300px;">
      </form>

    </div>
  </div>