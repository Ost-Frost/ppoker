
<!--- angepasst von: https://getbootstrap.com/docs/5.0/examples/sign-in/ --->

<form id="registerBlock" action="Register" method="POST">
    <h1 class="h3 mb-3 fw-normal">Registrierung zum Planning Poker</h1>

    <div class="form-floating">
        <input type="text" class="form-control" id="floatingUserName" name="userName" value="<?= $templateProperties["userName"] ?>">
        <label for="floatingUserName">Username</label>
    </div>
    <div class="form-floating">
        <input type="text" class="form-control" id="floatingFirstName" name="preName" value="<?= $templateProperties["preName"] ?>">
        <label for="floatingFirstName">Vorname</label>
    </div>
    <div class="form-floating">
        <input type="text" class="form-control" id="floatingLastName" name="lastName" value="<?= $templateProperties["lastName"] ?>">
        <label for="floatingLastName">Nachname</label>
    </div>
    <div class="form-floating">
        <input type="email" class="form-control" id="floatingEmail" name="email" value="<?= $templateProperties["email"] ?>">
        <label for="floatingEmail">E-Mail Addresse</label>
    </div>
    <div class="form-floating">
        <input type="email" class="form-control" id="floatingEmailRepeat" name="emailRepeat" value="<?= $templateProperties["emailRepeat"] ?>">
        <label for="floatingEmailRepeat">bitte E-Mail wiederholen</label>
    </div>
    <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" name="password" value="<?= $templateProperties["password"] ?>">
        <label for="floatingPassword">Passwort</label>
    </div>
    <div class="form-floating">
        <input type="password" class="form-control" id="floatingPasswordRepeat" name="passwordRepeat" value="<?= $templateProperties["passwordRepeat"] ?>">
        <label for="floatingPasswordRepeat">bitte Passwort wiederholen</label>
    </div>

    <p class="my-1 text-start text-danger" id="invalidFeedbackField"></p>
    <button id="submitButton" class="w-100 btn btn-lg btn-primary my-2" type="submit">Registrieren</button>
    <p><a href="Login">oder hier einloggen</a></p>
</form>
