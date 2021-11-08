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
            <label>Story</label>
            <input type="text" class="form-control" placeholder="">
          </div>

          <label>Beschreibung</label>
          <div class="col-md-12 mb-3">
            <textarea placeholder="Beschreibung eingeben!" style="height: 150px; width: 100%;"></textarea>
          </div>
        </div>

        <button class="btn btn-primary btn-lg btn-block" type="submit">Spiel erstellen</button>
      </form>

      <form>
        <h4 class="mb-3" style="margin-top: 5%;">Spieler einladen</h4>
        <ul class="list-group" id="antwort"></ul>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label>Benutzername oder Email</label>
            <input type="text" class="form-control" placeholder="" id="suche" name="userName" autocomplete="off">
            <div class="list-group" id="suggestions"></div>
          </div>
          <div class="col-md-6 mb-3">
            <button class="btn btn-primary btn-lg btn-block type mt-3">Einladen</button>
          </div>
        </div>
        <div style="height: 300px;">
      </form>

    </div>
  </div>