
<!--- angepasst von: https://getbootstrap.com/docs/5.0/examples/sign-in/ --->

<form id="registerBlock" action="Login" method="POST">
    <h1 class="h3 mb-3 fw-normal">Login zum Planning Poker</h1>

    <div class="form-floating">
        <input type="text" class="form-control" id="floatingUserName">
        <label for="floatingUserName">Username</label>
    </div>
    <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword">
        <label for="floatingPassword">Passwort</label>
    </div>

    <p class="my-1 text-start text-danger" id="invalidFeedbackField"></p>
    <button id="submitButton" class="w-100 btn btn-lg btn-primary my-2" type="submit">Anmelden</button>
    <p><a href="Register">oder hier registrieren</a></p>
</form>
