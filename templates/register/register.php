
<!--- angepasst von: https://getbootstrap.com/docs/5.0/examples/sign-in/ --->

<form id="registerBlock" action="Register" method="POST">
    <h1 class="h3 mb-3 fw-normal">Registrierung zum Planning Poker</h1>

    <div class="form-floating">
        <input type="text" class="form-control" id="floatingUserName" name="userName" maxlength="20" value="<?= $templateProperties["userName"] ?>">
        <label for="floatingUserName">Username</label>
    </div>
    <div class="form-floating">
        <input type="text" class="form-control" id="floatingFirstName" name="preName" maxlength="50" value="<?= $templateProperties["preName"] ?>">
        <label for="floatingFirstName">Vorname</label>
    </div>
    <div class="form-floating">
        <input type="text" class="form-control" id="floatingLastName" name="lastName" maxlength="50" value="<?= $templateProperties["lastName"] ?>">
        <label for="floatingLastName">Nachname</label>
    </div>
    <div class="form-floating">
        <input type="email" class="form-control" id="floatingEmail" name="email" maxlength="100" value="<?= $templateProperties["email"] ?>">
        <label for="floatingEmail">E-Mail Addresse</label>
    </div>
    <div class="form-floating">
        <input type="email" class="form-control" id="floatingEmailRepeat" maxlength="100" name="emailRepeat" value="<?= $templateProperties["emailRepeat"] ?>">
        <label for="floatingEmailRepeat">bitte E-Mail wiederholen</label>
    </div>
    <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" maxlength="50" name="password" value="<?= $templateProperties["password"] ?>">
        <label for="floatingPassword">Passwort</label>
    </div>
    <div class="form-floating">
        <input type="password" class="form-control" id="floatingPasswordRepeat" maxlength="50" name="passwordRepeat" value="<?= $templateProperties["passwordRepeat"] ?>">
        <label for="floatingPasswordRepeat">bitte Passwort wiederholen</label>
    </div>

    <p class="my-1 text-start text-danger" id="invalidFeedbackField"></p>
    <button id="submitButton" class="w-100 btn btn-lg btn-primary my-2" type="submit">Registrieren</button>
    <p><a href="Login">oder hier einloggen</a></p>
</form>
